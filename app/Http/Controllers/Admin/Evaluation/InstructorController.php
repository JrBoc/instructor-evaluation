<?php

namespace App\Http\Controllers\Admin\Evaluation;

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
        return view('pages.admin.evaluation.instructor');
    }

    public function table(Request $request)
    {
        $form = [
            'search' => $request->form['search'] ?? null,
            'column' => $request->form['column'] ?? null,
            'status' => $request->form['status'] ?? null,
        ];

        return datatables()
            ->eloquent(Instructor::query())
            ->filter(function ($q) use ($form) {
                $columns = [
                    1 => 'id',
                    2 => 'last_name',
                    3 => 'last_name',
                    4 => 'first_name',
                    5 => 'middle_name',
                ];

                if (!is_null($form['status'])) {
                    $q->where('status', $form['status']);
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
