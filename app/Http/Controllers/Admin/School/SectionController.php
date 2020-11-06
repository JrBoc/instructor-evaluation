<?php

namespace App\Http\Controllers\Admin\School;

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
        return view('pages.admin.school.section');
    }

    public function table(Request $request)
    {
        $form = [
            'status' => $request->form['status'] ?? null,
            'search' => $request->form['search'] ?? null,
            'column' => $request->form['column'] ?? null,
            'grade' => $request->form['grade'] ?? null,
        ];

        $sections = Section::query()
            ->with([
                'first_semester_assignments.subject',
                'first_semester_assignments.instructor',
                'second_semester_assignments.subject',
                'second_semester_assignments.instructor'
            ]);

        $columns = [
            1 => 'id',
            2 => 'name',
        ];

        return datatables()
            ->eloquent($sections)
            ->searchFilter($columns, $form, function ($query) use ($form) {
                if (!is_null($form['status'])) {
                    $query->where('status', $form['status']);
                }

                if (!is_null($form['grade'])) {
                    $query->where('grade', $form['grade']);
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
