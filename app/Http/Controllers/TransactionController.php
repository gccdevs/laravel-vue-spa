<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class TransactionController extends Controller
{
    public function getTransactionModal()
    {
        return new Transaction;
    }

    /**
     * @param $data
     * @return Transaction|\Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function createExternalTransaction($data)
    {
        $newTransaction = $this->getTransactionModal();
        try {
            DB::beginTransaction();
            $newTransaction->transaction_ref         = array_get($data, 'reference') != 1 ? array_get($data, 'reference') : 'AUTO_TRANS_' . Uuid::uuid4();
            $newTransaction->transaction_uuid        = Uuid::uuid1();
            $newTransaction->transaction_description = 'Manual update from' . array_get($data, 'platform');
            $newTransaction->transaction_email       = array_get($data, 'email', null);
            $newTransaction->client_ip               = null;
            $newTransaction->last_4_digits           = null;
            $newTransaction->card_id                 = null;
            $newTransaction->transaction_purpose     = Transaction::TYPE_FUNDRAISING;
            $newTransaction->transaction_platform    = array_get($data, 'platform') == 'paylinx' ? Transaction::PLATFORM_PAYLINX : Transaction::PLATOFRM_BANK;
            $newTransaction->transaction_status      = Transaction::STATUS_SUCCESS;
            $newTransaction->transaction_net_amount  = (int) array_get($data, 'amount') * 100;
            $newTransaction->transaction_amount_paid = (int) array_get($data, 'amount') * 100;
            $newTransaction->transaction_rate        = array_get($data, 'pay_rate', null);
            $newTransaction->is_rate_covered         = false;
            $newTransaction->transaction_refunded    = false;
            $newTransaction->save();
            DB::commit();
            return $newTransaction;
        } catch (\Exception $e) {
            DB::rollback();
            return report_error('Fundraising Transaction', 'Cannot create transaction record with charge id: ' . $charge->id, true);
        }
    }
}
