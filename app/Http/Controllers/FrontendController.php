<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Form;
use App\Http\Resources\FormResource;
use Illuminate\Support\Facades\DB;

class FrontendController extends Controller
{
    public function index()
    {
        if (array_get($_GET, 'lang') == 'en') {
            app()->setLocale('en');
        } else {
            app()->setLocale('tw');
        }
        return view('frontend.index');
    }

    public function show($event)
    {
    	if (Form::find($event) || Form::where('form_name', $event)->first()) {
    		return view('frontend.index');
    	} else {
    		echo 'Not Found';
    	}
    }
    public function getTotalNumber()
    {
        $user = User::find(3);
        return json_encode(array('totalNumber' => unserialize($user->user_note) > 2 ?  unserialize($user->user_note) : 122));
    }
}
