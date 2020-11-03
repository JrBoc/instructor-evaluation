<?php

namespace App\Http\Controllers\Admin\Evaluation;

use Carbon\Carbon;
use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ScheduleController extends Controller
{
    public function index()
    {
        return view('pages.admin.evaluation.schedule');
    }

    public function table(Request $request)
    {
        $form = [
            'status' => $request->form['status'] ?? null,
            'search' => $request->form['search'] ?? null,
            'column' => $request->form['column'] ?? null,
        ];

        $schedules = Schedule::query()
            ->with('section')
            ->where('date', Carbon::now()->format('Y-m-d'));

        $columns = [
            1 => 'id'
        ];

        $selectionFilters = [
            'status' => 'status',
        ];

        return datatables()
            ->eloquent($schedules)
            ->searchFilter($columns, $form, $selectionFilters)
            ->addColumn('btn', function ($schedule) {
                $btn = '<button data-toggle="tooltip" title="View" type="button" class="btn btn-icon btn-view mr-2 border-dark" value="' . $schedule->id . '"><i class="ik ik-eye"></i></button>';

                if (auth()->user()->can('schedule.edit')) {
                    $btn .= '<button data-toggle="tooltip" title="Edit" type="button" class="btn btn-outline-primary btn-icon btn-edit mr-2" value="' . $schedule->id . '"><i class="ik ik-edit"></i></button>';
                }

                if (auth()->user()->can('schedule.delete')) {
                    $btn .= '<button data-toggle="tooltip" title="Delete" type="button" class="btn btn-outline-danger btn-icon btn-delete" value="' . $schedule->id . '"><i class="ik ik-trash"></i></button>';
                }

                return $btn;
            })
            ->rawColumns(['btn', 'html_status'])
            ->toJson();
    }

    public function tablePastSchedule(Request $request)
    {
        $schedules = Schedule::query()
            ->with('section')
            ->where('date', '<', Carbon::now()->format('Y-m-d'));

        return datatables()
            ->eloquent($schedules)
            ->rawColumns(['btn', 'html_status'])
            ->toJson();
    }
}
