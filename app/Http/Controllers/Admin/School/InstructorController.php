<?php

namespace App\Http\Controllers\Admin\School;

use App\Models\Instructor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InstructorController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:instructor.access');
    }

    public function index()
    {
        return view('pages.admin.school.instructor');
    }

    public function table(Request $request)
    {
        $form = [
            'search' => $request->form['search'] ?? null,
            'column' => $request->form['column'] ?? null,
            'status' => $request->form['status'] ?? null,
        ];

        $instructors = Instructor::query();

        $columns = [
            1 => 'id',
            2 => 'last_name',
            3 => 'last_name',
            4 => 'first_name',
            5 => 'middle_name',
        ];

        return datatables()
            ->eloquent($instructors)
            ->filter(function ($q) use ($form) {
                if (!is_null($form['status'])) {
                    $q->where('status', $form['status']);
                }
            })
            ->searchFilter($columns, $form)
            ->addColumn('btn', function ($instructor) {
                $btn = '<button data-toggle="tooltip" title="View" type="button" class="btn btn-icon btn-view mr-2 border-dark" value="' . $instructor->id . '"><i class="ik ik-eye"></i></button>';

                if (auth()->user()->can('instructor.edit')) {
                    $btn .= '<button data-toggle="tooltip" title="Edit" type="button" class="btn btn-outline-primary btn-icon btn-edit mr-2" value="' . $instructor->id . '"><i class="ik ik-edit"></i></button>';
                }

                if (auth()->user()->can('instructor.delete')) {
                    $btn .= '<button data-toggle="tooltip" title="Delete" type="button" class="btn btn-outline-danger btn-icon btn-delete" value="' . $instructor->id . '"><i class="ik ik-trash"></i></button>';
                }

                return $btn;
            })
            ->rawColumns(['btn', 'html_status'])
            ->toJson();
    }
}
