<?php

namespace App\Http\Controllers\Admin\Evaluation;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\QuestionCategory;
use Illuminate\Http\Request;

class QuestionnaireController extends Controller
{
    public function index()
    {
        return view('pages.admin.evaluation.questionnaire');
    }
}
