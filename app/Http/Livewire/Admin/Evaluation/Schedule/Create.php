<?php

namespace App\Http\Livewire\Admin\Evaluation\Schedule;

use App\Http\Livewire\LivewireForm;
use App\Models\Schedule;
use App\Models\Section;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Create extends Component
{
    use LivewireForm;

    public $school_year  = '';
    public $section = '';
    public $semester = '';
    public $date = '';
    public $start = '';
    public $end = '';
    public $status = 1;
    public $grade = '';
    public $evaluation_type = '';

    public function render()
    {
        return view('livewire.admin.evaluation.schedule.create', [
            'stored_sections' => Section::query()->where('grade', $this->grade)->get(),
        ]);
    }

    public function store()
    {
        $this->validate([
            'school_year' => 'required|date_format:Y',
            'semester' => 'required|integer',
            'grade' => 'required|integer',
            'section' => 'required|integer',
            'status' => 'required|boolean',
            'evaluation_type' => 'required',
        ]);

        $this->validate([
            'date' => 'required|date',
            'start' => [
                'required_if:evaluation_type,TIMED',
                'date_format:H:i',
                'before:end',
            ],
            'end' => [
                'required_if:evaluation_type,TIMED',
                'date_format:H:i',
                'after:start',
            ],
        ]);

        $type = [
            'TIMED' => 0,
            'OPEN' => 1
        ][$this->evaluation_type];

        try {
            DB::transaction(function () use ($type) {
                Schedule::create([
                    'school_year' => $this->school_year,
                    'section_id' => $this->section,
                    'status' => $this->status,
                    'semester' => $this->semester,
                    'whole_day' => $type,
                    'date' => $this->date,
                    'start' => (!$type) ? $this->start : '00:00:00',
                    'end' => (!$type) ? $this->end : '00:00:00',
                ]);
            });
        } catch(\Illuminate\Database\QueryException $e) {
            $this->clear();

            return $this->emit('errorMsg', ['title' => 'Transaction Error', 'message' => $e->getMessage()]);
        }

        $this->clear();

        $this->emit('tableRefresh');
        $this->emit('closeModal', ['id' => '#mdl_create']);
        $this->emit('msg', ['message' => 'Schedule created.']);
    }

    public function clear()
    {
        $this->resetErrorBag();
        $this->reset();
    }
}
