<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Notifications\UserCodeChangedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Ramsey\Uuid\Uuid;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function showAmountInput($token)
    {
        $user = auth()->user();

        if (!$token || $token != $user->user_code) {
            if (env('APP_ENV') != 'local') {
                return view('404');
            }
        }

        return view('donation-summary');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function updateAmount(Request $request)
    {
        $user = auth()->user();

        if ($user->id == 1 || $user->id == 2 || $user->id == 3) {

            $this->validate($request, [
                'number'    => 'required|numeric',
            ]);
            if (request('hotpot')) {
                report_error('Donation amount update', 'hidden input contains value');
                return redirect()->back()->with('error', true);
            }

            if ($request->get('number') <= 0) {
                report_error('Donation amount update', 'Failed to create new external transaction record.');
                return redirect()->back()->with('error', true);
            }

            $emma = User::find(3);

            $emma->user_note = serialize($request->get('number'));
            $emma->save();
            return redirect()->back()->with('success', true);
        }
    }
}