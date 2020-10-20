<?php

namespace App\Http\Controllers\Admin\Evaluation;

use App\Models\Section;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SectionController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:class.access');
    }

    public function index()
    {
        return view('pages.admin.evaluation.section');
    }

    public function table(Request $request)
    {
        $form = [
            'status' => $request->form['status'] ?? null,
            'search' => $request->form['search'] ?? null,
            'column' => $request->form['column'] ?? null,
            'grade' => $request->form['grade'] ?? null,
        ];

        return datatables()
            ->eloquent(Section::query()
                ->with([
                    'first_semester_assignments.subject',
                    'first_semester_assignments.instructor',
                    'second_semester_assignments.subject',
                    'second_semester_assignments.instructor'
                ]))
            ->filter(function ($q) use ($form) {
                $columns = [
                    1 => 'id',
                    2 => 'name',
                ];

                if (!is_null($form['status'])) {
                    $q->where('status', $form['status']);
                }

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
            ->editColumn('first_semester_assignments', function ($class) {
                $assignments = '';

                if ($class->first_semester_assignments) {
                    foreach ($class->first_semester_assignments as $assignment) {
                        $assignments .= '<label class="badge badge-info mb-1">' . $assignment->subject->name . ' | ' . $assignment->instructor->formatted_full_name . '</label><br>';
                    }
                }

                return $assignments;
            })
            ->editColumn('second_semester_assignments', function ($class) {
                $assignments = '';

                if ($class->second_semester_assignments) {
                    foreach ($class->second_semester_assignments as $assignment) {
                        $assignments .= '<label class="badge badge-info mb-1">' . $assignment->subject->name . ' | ' . $assignment->instructor->formatted_full_name . '</label><br>';
                    }
                }

                return $assignments;
            })
            ->addColumn('btn', function ($class) {
                $btn = '<button data-toggle="tooltip" title="View" type="button" class="btn btn-light btn-icon btn-view mr-2 border-dark" value="' . $class->id . '"><i class="ik ik-eye"></i></button>';

                if (auth()->user()->can('class.edit')) {
                    $btn .= '<button data-toggle="tooltip" title="Edit" type="button" class="btn btn-outline-primary btn-icon btn-edit mr-2" value="' . $class->id . '"><i class="ik ik-edit"></i></button>';
                }

                if (auth()->user()->can('class.delete')) {
                    $btn .= '<button data-toggle="tooltip" title="Delete" type="button" class="btn btn-outline-danger btn-icon btn-delete" value="' . $class->id . '"><i class="ik ik-trash"></i></button>';
                }

                return $btn;
            })
            ->addColumn('html_status', function ($class) {
                return $class->html_status;
            })
            ->rawColumns(['btn', 'html_status', 'second_semester_assignments', 'first_semester_assignments'])
            ->toJson();
    }
}
