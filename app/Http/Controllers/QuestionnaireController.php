<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QuestionnaireController extends Controller
{
    public function __construct() {
        $this->middleware('auth'); // prevents unathorized users from access to this controller
    }

    public function create() {
        return view('questionnaire.create');
    }

    public function store() {
        $data = request()->validate([
            'title' => 'required',
            'purpose' => 'required'
        ]);

        // $data['user_id'] = auth()->user()->id;

        // $questionnaire = \App\Questionnaire::create($data);

        $questionnaire = auth()->user()->questionnaires()->create($data);
        // refactor after linking User and Questionaire models
        // Questionaire model's link has
        // return $this->belongsTo(User::class);

        return redirect('/questionnaires/'.$questionnaire->id);
    }

    public function show(\App\Questionnaire $questionnaire) {

        $questionnaire->load('questions.answers.responses');

        return view('questionnaire.show', compact('questionnaire'));
    }
}
