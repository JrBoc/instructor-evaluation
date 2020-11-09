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

    public function tableQuestions(Request $request)
    {
        $form = [
            'status' => $request->form['status'] ?? null,
            'search' => $request->form['search'] ?? null,
            'column' => $request->form['column'] ?? null,
        ];

        $questions = Question::query()->with('category');

        return datatables()
            ->eloquent($questions)
            ->addColumn('btn', function($question) {
                $btn = '<button data-toggle="tooltip" title="View" type="button" class="btn btn-icon btn-view mr-2 border-dark" value="' . $question->id . '"><i class="ik ik-eye"></i></button>';

                if (auth()->user()->can('class.edit')) {
                    $btn .= '<button data-toggle="tooltip" title="Edit" type="button" class="btn btn-outline-primary btn-icon btn-edit mr-2" value="' . $question->id . '"><i class="ik ik-edit"></i></button>';
                }

                if (auth()->user()->can('class.delete')) {
                    $btn .= '<button data-toggle="tooltip" title="Delete" type="button" class="btn btn-outline-danger btn-icon btn-delete" value="' . $question->id . '"><i class="ik ik-trash"></i></button>';
                }

                return $btn;
            })
            ->rawColumns(['btn'])
            ->toJson();
    }

    public function tableCategories(Request $request)
    {
        $form = [
            'status' => $request->form['status'] ?? null,
            'search' => $request->form['search'] ?? null,
            'column' => $request->form['column'] ?? null,
        ];

        $categories = QuestionCategory::query();

        return datatables()
        ->eloquent($categories)
        ->addColumn('btn', function($category) {
            $btn = '<button data-toggle="tooltip" title="View" type="button" class="btn btn-icon btn-view mr-2 border-dark" value="' . $category->id . '"><i class="ik ik-eye"></i></button>';

            if (auth()->user()->can('class.edit')) {
                $btn .= '<button data-toggle="tooltip" title="Edit" type="button" class="btn btn-outline-primary btn-icon btn-edit mr-2" value="' . $category->id . '"><i class="ik ik-edit"></i></button>';
            }

            if (auth()->user()->can('class.delete')) {
                $btn .= '<button data-toggle="tooltip" title="Delete" type="button" class="btn btn-outline-danger btn-icon btn-delete" value="' . $category->id . '"><i class="ik ik-trash"></i></button>';
            }

            return $btn;
        })
        ->rawColumns(['btn'])
        ->toJson();
    }
}
