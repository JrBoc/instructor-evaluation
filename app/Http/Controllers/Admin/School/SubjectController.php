<?php

namespace App\Http\Controllers\Admin\School;

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
        return view('pages.admin.school.subject');
    }

    public function table(Request $request)
    {
        $form = [
            'search' => $request->form['search'] ?? null,
            'column' => $request->form['column'] ?? null,
            'grade' => $request->form['grade'] ?? null,
        ];

        $subjects = Subject::query();

        $columns = [
            1 => 'id',
            2 => 'name',
        ];

        return datatables()
            ->eloquent($subjects)
            ->filter(function ($q) use ($form) {
                if (!is_null($form['grade'])) {
                    $q->where('grade', $form['grade']);
                }
            })
            ->searchFilter($columns, $form)
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
