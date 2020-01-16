<?php

namespace App\Http\Api;

use App\Models\FormNote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class HomeApi extends BaseApi
{
    public function saveNote(Request $request)
    {
        $note = request('note');
        $formNote = new FormNote();

        $formNote->note = $note;
        $formNote->save();
    }

    public function getNote()
    {
        return FormNote::orderBy('created_at', 'DESC')->first();
    }
}
