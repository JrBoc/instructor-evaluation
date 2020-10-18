<?php

namespace App\Http\Controllers\Admin\Evaluation;

use App\Models\Subject;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:subject.access');
    }

    public function index()
    {
        return view('pages.admin.evaluation.subject');
    }

    public function table(Request $request)
    {
        $form = [
            'search' => $request->form['search'] ?? null,
            'column' => $request->form['column'] ?? null,
            'grade' => $request->form['grade'] ?? null,
        ];

        return datatables()
            ->eloquent(Subject::query())
            ->filter(function ($q) use ($form) {
                $columns = [
                    1 => 'id',
                    2 => 'name',
                ];

                if (!is_null($form['grade'])) {
                    $q->where('grade', $form['grade']);
                }

                if (!is_null($form['search']) && isset($columns[$form['column']])) {
                    if (is_array($columns[$form['column']])) {
                        $q->whereHas($columns[$form['column']][0], function ($q) use ($form, $columns) {
                            if (strpos($columns[$form['column']][1], '?') != false) {
                                $q->whereRaw($columns[$form['column']][1], ['%' . $form['search'] . '%']);
                            } else {
                                $q->where($columns[$form['column']][1], 'LIKE', '%' . $form['search'] . '%');
                            }
                        });
                    } else {
                        if (strpos($columns[$form['column']], '?') != false) {
                            $q->whereRaw($columns[$form['column']], '%' . $form['search'] . '%');
                        } else {
                            $q->where($columns[$form['column']], 'LIKE', '%' . $form['search'] . '%');
                        }
                    }
                }
            })
            ->addColumn('btn', function ($subject) {
                $btn = '';

                if (auth()->user()->can('subject.edit')) {
                    $btn .= '<button data-toggle="tooltip" title="Edit" type="button" class="btn btn-outline-primary btn-icon btn-edit mr-2" value="' . $subject->id . '"><i class="ik ik-edit"></i></button>';
                }

                if (auth()->user()->can('subject.delete')) {
                    $btn .= '<button data-toggle="tooltip" title="Delete" type="button" class="btn btn-outline-danger btn-icon btn-delete" value="' . $subject->id . '"><i class="ik ik-trash"></i></button>';
                }

                return $btn;
            })
            ->rawColumns(['btn'])
            ->toJson();
    }
}
