<?php

namespace App\Http\Controllers;

use App\Models\Form;
use DB;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index()
    {

        $forms = Form::latest()->get();

        return view('welcome', compact('forms'));
    }

    public function viewForm(Form $form)
    {

        $form->loadMissing('fields');
        //dd($form);

        return view('view-form', compact('form'));
    }

    public function submitForm(Request $request, Form $form)
    {

        DB::table($form->table_name)->insert($request->except('_token'));

        return redirect()->route('welcome')->with('success', 'Form submitted successfully');
    }
}
