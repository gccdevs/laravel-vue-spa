<?php

namespace App\Repositories;

use App\Models\Event;
use App\Models\EventField;
use App\Models\EventPayment;
use App\Models\FormPayment;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Exception;
use Illuminate\Support\Facades\DB;

class EventsRepository extends BaseRepository
{

    protected function getEventModel()
    {
        return new Event;
    }

    protected function getEventFieldModel()
    {
        return new EventField;

    }

    protected function getEventPaymentModel()
    {
        return new EventPayment;
    }

    /**
     * @param $data
     * @return Event
     * @throws Exception
     */
    public function createNewEvent($data)
    {
        try {
            DB::beginTransaction();

            $newEvent = $this->getEventModel();

            //Step 1: save event detail
            $newEvent = $this->saveEventDetail($newEvent, $data);

            //Step 2: save event field detail
            $this->saveEventFieldsDetail($newEvent, $data);

            //Step 3: charge
            if ($newEvent->has_payment) {
                $paymentEmail = array_get($data, 'payment_email');
                if (!$paymentEmail) {
                    if (env('APP_ENV') !== 'local') {
                        Bugsnag::notifyError('EventsRepo', 'Cannot get payment email for event: ' .
                            $newEvent->form_name);
                    }
                    throw new Exception('Cannot get payment email for event: ' .
                        $newEvent->form_name);
                }

                $formPayment = FormPayment::where('form_id', $newEvent->form_id)->first();
                $amount = $formPayment->amount;
                if (!$amount || $amount < 0) {
                    if (env('APP_ENV') !== 'local') {
                        Bugsnag::notifyError('EventsRepo', 'Cannot get correct amount for event: ' .
                            $newEvent->form_name);
                    }
                    throw new Exception('Cannot get correct amount for event: ' .
                        $newEvent->form_name);
                }

                $stripeInfo = array_get($data, 'stripe_token', []);
                $stripeInfo['payment_email'] = $paymentEmail;
                $paymentResponse = $this->createCharge($newEvent, $amount, $stripeInfo, $paymentEmail);
                $eventPayment = $this->saveEventPaymentDetail($newEvent, $stripeInfo, $paymentResponse);
                $newEvent->event_payment_id = $eventPayment->id;
            }
            $newEvent->save();
            DB::commit();
            return $newEvent;
        }catch (Exception $e) {
            DB::rollback();
            if (env('APP_ENV') !== 'local') {
                Bugsnag::notifyError('EventsRepo', 'Failed to create event', $e->getMessage());
            }
            throw new Exception( 'Error.' . $e->getMessage());
        }
    }

    public function saveEventDetail($event, $data)
    {
        $event->fill(array_only($data, [
            'form_name',
            'has_payment',
            'form_id',
        ]));
        $event->save();
        return $event;
    }

    public function saveEventFieldsDetail($event, $data)
    {
        foreach (array_get($data, 'fields') as $field) {
            $newEventField = $this->getEventFieldModel();
            $newEventField->event_id = $event->id;
            $newEventField->form_id = array_get($data, 'form_id');
            $newEventField->fill(array_only($field, [
                'form_field_id',
                'field_label',
                'required',
                'type'
            ]));
            $newEventField->field_value = array_get($field, 'field_value');
            $newEventField->save();
        }
    }

    /**
     * @param $event
     * @param $amount
     * @param $stripeInfo
     * @param $paymentEmail
     * @return array
     * @throws Exception
     */
    public function createCharge($event, $amount, $stripeInfo, $paymentEmail)
    {
        $stripeRepo = new StripeRepository();
        $response = $stripeRepo->charge(array_get($stripeInfo, 'id'), [
            'email' =>$paymentEmail,
            'amount' => $amount * 100,
            'description' => 'payment_event_id_' . $event->id,
        ]);

        if (!$response) {
            if (env('APP_ENV') !== 'local') {
                Bugsnag::notifyError('EventsRepo', 'Cannot create charge event: ' . $event->id);
            }
            throw new Exception('Cannot create charge event: ' . $event->id);
        }
        return $response;
    }

    /**
     * @param $event
     * @param $info
     * @param $paymentResponse
     * @return EventPayment
     */
    public function saveEventPaymentDetail($event, $info, $paymentResponse)
    {
        $payment = $this->getEventPaymentModel();
        $charge = array_get($paymentResponse, 'charge');
        $customer = array_get($paymentResponse, 'customer');

        $payment->stripe_charge_id = $charge->id;
        $payment->stripe_client_id = $customer->id;
        $payment->client_ip = array_get($info, 'client_ip');
        $payment->payment_email = array_get($info, 'payment_email');
        $payment->paid_amount = $charge->amount;
        $payment->customer_name = array_get($info, 'customer_name', null);
        $payment->save();
        return $payment;
    }
}
