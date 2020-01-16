<?php

namespace App\Http\Api;

use App\Http\Resources\TransactionResource;
use App\Models\SlackNotificationSender;
use App\Models\Transaction;
use App\Notifications\SlackNotification;
use App\Repositories\FundraisingRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class FundraisingApi extends BaseApi
{

    /**
     * FundraisingApi constructor.
     * @param FundraisingRepository $repository
     */
    public function __construct(FundraisingRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param Request $request
     * @return TransactionResource
     * @throws \Exception
     */
    public function takeCharge(Request $request)
    {
        $data = [
            'stripe' => $request->get('token'),
            'email'  => $request->get('paymentEmail') ?: null,
            'amount' => $request->get('selectedMoney'),
            'payRate' => $request->get('payRate'),
            'isCoveringFee' => $request->get('isCoveringFee'),
        ];

        if (is_nan(array_get($data, 'amount')) || (float) array_get($data, 'amount') <= 0) {
            return report_error('Fundraising', 'Invalid Amount: ' . $data['amount']);
        }

        $response = $this->repository->createCharge($data);

        if ($response instanceof Transaction) {

            if ($response->transaction_email) {
                try{
                    Notification::route('mail', $response->transaction_email)
                        ->notify(new \App\Notifications\FundRaisingReceivedNotification($response, array_get($request->all(), 'lang', null)));
                    if (env('APP_ENV') != 'local') {
                        Notification::send(new SlackNotificationSender(), new SlackNotification('An receipt has sent to: ' .  $response->transaction_email));
                    }
                } catch(\Exception $e) {
                    return report_error('Fundraising', 'Fail to send email to  ' . $response->transaction_email);
                }
            }

            return new TransactionResource($response);

        } else {
            return json_error($response);
        }

    }
}
