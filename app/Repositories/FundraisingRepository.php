<?php

namespace App\Repositories;

use App\Models\Transaction;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Ramsey\Uuid\Uuid;

class FundraisingRepository extends BaseRepository
{

    public function getTransactionModel()
    {
        return new Transaction;
    }

    /**
     * @param $data
     * @return Transaction|array|bool
     * @throws \Exception
     */
    public function createCharge($data)
    {
        $amount = array_get($data, 'amount');

        if (array_get($data, 'isCoveringFee')) {
            if (!array_get($data, 'payRate', false) || array_get($data, 'payRate') <= 0) {
                return report_error('Fundraising', 'Pay rate is incorrect: ', array_get($data, 'payRate'));
            }
            $netAmount = array_get($data, 'amount');
            $amount = array_get($data, 'amount') + array_get($data, 'amount') * array_get($data, 'payRate') + 0.3;
        } else {
            $netAmount = ($amount - 0.3 )  / ( 1+  array_get($data, 'payRate'));
        }

        $stripeInfo = array_get($data, 'stripe');
        $email = array_get($data, 'email');

        $cardInfo['cardId'] = array_get($stripeInfo, 'card.id');
        $cardInfo['last4'] = array_get($stripeInfo, 'card.last4');
        $cardInfo['ip'] = array_get($stripeInfo, 'client_ip');
        $cardInfo['net_amount'] = $netAmount;
        $cardInfo['amount_paid'] = $amount;
        $cardInfo['rate'] = array_get($data, 'payRate');
        $cardInfo['is_covered'] = array_get($data, 'isCoveringFee');

        if ($response = $this->charge($amount, $stripeInfo, $email)) {

            if (gettype($response) == 'string') {
                return $response;
            }
            return $this->createFundraisingRecord($response, $cardInfo);
        }
        return false;
    }

    /**
     * @param $amount
     * @param $stripeInfo
     * @param $email
     * @return array
     * @throws \Exception
     */
    protected function charge($amount, $stripeInfo, $email)
    {
        $stripeRepo = new StripeRepository();

        $response = $stripeRepo->charge(array_get($stripeInfo, 'id'), [
            'email' => $email ?: null,
            'amount' => round_up($amount, 2) * 100,
            'description' => 'fundraising-' . array_get($stripeInfo, 'id'),
        ]);

        if (!$response) {
            if (env('APP_ENV') !== 'local') {
                Bugsnag::notifyError('Fundraising', 'Cannot create fundraising transaction: ' . array_get($stripeInfo, 'id'));
            }
            throw new \Exception('Cannot create fundraising transaction: ' . array_get($stripeInfo, 'id'));
        }
        if (gettype($response) == 'string') {
            if (env('APP_ENV') !== 'local') {
                Bugsnag::notifyError('Fundraising', 'Cannot create fundraising transaction: ' . $response);
            }
            return $response;
        }
        return $response;
    }

    /**
     * @param $response
     * @param $cardInfo
     * @return Transaction
     * @throws \Exception
     */
    protected function createFundraisingRecord($response, $cardInfo)
    {
        $charge = array_get($response, 'charge');
        $customer = array_get($response, 'customer');
        $newTransaction = $this->getTransactionModel();
        try {
            $newTransaction->transaction_ref         = $charge->id;
            $newTransaction->transaction_uuid        = Uuid::uuid1();
            $newTransaction->transaction_description = $charge->description;
            $newTransaction->transaction_email       = $customer ? $customer->email : null;
            $newTransaction->client_ip               = array_get($cardInfo, 'ip');
            $newTransaction->last_4_digits           = array_get($cardInfo, 'last4');
            $newTransaction->card_id                 = array_get($cardInfo, 'cardId');
            $newTransaction->transaction_purpose     = Transaction::TYPE_FUNDRAISING;
            $newTransaction->transaction_platform    = Transaction::PLATFORM_STRIPE;
            $newTransaction->transaction_status      = $charge->status;
            $newTransaction->transaction_net_amount  = round_up(array_get($cardInfo, 'net_amount'), 3);
            $newTransaction->transaction_amount_paid = $charge->amount;
            $newTransaction->transaction_rate        = array_get($cardInfo, 'rate') ?: null;
            $newTransaction->is_rate_covered         = array_get($cardInfo, 'is_covered') ? true : false;
            $newTransaction->transaction_refunded    = false;
            $newTransaction->save();
        } catch (\Exception $e) {
            return report_error('Fundraising Transaction', 'Cannot create transaction record with charge id: ' . $charge->id, true);
        }
        return $newTransaction;
    }
}
