<?php

use Illuminate\Database\Seeder;

class FormNoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $note = \App\Models\FormNote::create([
            'note' => "# Development Progress\n" .
                "1. Events registration page" .
                "2".
                "<br>\n\n" .
                "# Bugs".
                "\n\n- Image path".
                "- Vuex `currentFormBuilder`"
        ]);
    }
}
