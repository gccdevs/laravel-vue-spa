<?php

namespace App\Repositories;

use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Stripe\Charge;
use Stripe\Customer;
use Stripe\Stripe;

class StripeRepository extends BaseRepository
{

    /**
     * @param $token
     * @param null $data
     * @return array|string|\Stripe\ApiResource
     */
    public function charge($token, $data = null)
    {
        Stripe::setApiKey(config('app.stripe.secret'));
        $customer = null;
        if (array_get($data, 'email')) {
            $customer = $this->createCustomer($token, array_get($data, 'email'));
            if (gettype($customer) == 'string') {
                return $customer;
            }
        }
        $charge = $this->createCharge(
            $token,
            $customer,
            array_get($data, 'amount'),
            array_get($data, 'description'));

        if (gettype($charge) == 'string') {
            return $charge;
        }
        return [
            'charge' => $charge,
            'customer' => $customer
        ];
    }

    /**
     * @param $token
     * @param $email
     * @param null $name
     * @return string|\Stripe\ApiResource
     */
    public function createCustomer($token, $email, $name = null)
    {
        try {
            if ($name) {
                $customer = Customer::create([
                    'email'  => $email,
                    'name'   => $name,
                    'source' => $token,
                ]);

            } else {
                $customer = Customer::create([
                    'email'  => $email,
                    'source' => $token,
                ]);
            }
        } catch (\Exception $e) {
            if (env('APP_ENV') !== 'local') {
                Bugsnag::notifyError('StripeRepo', 'Failed to create Stripe customer ' . $e->getMessage());
            }
            return $e->getMessage();
        }
        return $customer;
    }

    /**
     * Create charge
     * @param $token
     * @param null $customer
     * @param $amount
     * @param null $description
     * @return string|\Stripe\ApiResource
     */
    public function createCharge($token, $customer = null, $amount, $description = null)
    {
        try {

            if ($customer) {
                $charge = Charge::create([
                    'description' => $description,
                    'currency' => 'AUD',
                    'customer' => $customer->id,
                    'amount' => $amount,
                ]);
            } else {
                $charge = Charge::create([
                    'description' => $description,
                    'currency' => 'AUD',
                    'source' => $token,
                    'amount' => $amount,
                ]);
            }
        } catch (\Exception $e) {
            if (env('APP_ENV') !== 'local') {
                Bugsnag::notifyError('StripeRepo', 'Failed to create Stripe charge ' . $e->getMessage());
            }
            return $e->getMessage();
        }
        return $charge;
    }
}
