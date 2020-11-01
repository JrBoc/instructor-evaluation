<?php

namespace App\Http\Controllers\Admin\Evaluation;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionnaireController extends Controller
{
    public function index()
    {
        return view('pages.admin.evaluation.questionnaire');
    }

    public function table(Request $request)
    {
        $form = [
            'status' => $request->form['status'] ?? null,
            'search' => $request->form['search'] ?? null,
            'column' => $request->form['column'] ?? null,
        ];

        $questions = Question::query()->with('category');

        return datatables()
            ->eloquent($questions)
            ->toJson();
    }
}
