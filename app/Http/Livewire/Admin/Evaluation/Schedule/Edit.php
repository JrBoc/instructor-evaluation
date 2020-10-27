<?php

namespace App\Http\Livewire\Admin\Evaluation\Schedule;

use App\Models\Section;
use Livewire\Component;
use App\Models\Schedule;
use Illuminate\Support\Facades\DB;
use App\Http\Livewire\LivewireForm;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Edit extends Component
{
    use LivewireForm, AuthorizesRequests;

    public $schedule;
    public $school_year  = '';
    public $section = '';
    public $semester = '';
    public $date = '';
    public $start = '';
    public $end = '';
    public $status = 1;
    public $grade = '';
    public $evaluation_type = '';
    public $editable = false;

    public function render()
    {
        return view('livewire.admin.evaluation.schedule.edit', [
            'stored_sections' => Section::query()->where('grade', $this->grade)->get(),
        ]);
    }

    public function get(Schedule $schedule, $editable = false)
    {
        $this->schedule = $schedule;

        $this->school_year = $schedule->school_year;
        $this->section = $schedule->section_id;
        $this->semester = $schedule->semester;
        $this->date = $schedule->date->format('Y-m-d');
        $this->start = $schedule->start->format('H:i');
        $this->end = $schedule->end->format('H:i');
        $this->status = $schedule->status;
        $this->grade = $schedule->section->grade;
        $this->evaluation_type = $this->evaluation_type ? 'TIMED' : 'OPEN';

        $this->editable = $editable;

        $this->emit('openModal', [
            'id' => '#mdl_edit',
            'title' => $this->editable ? 'Edit Schedule' : 'View Schedule',
        ]);
    }

    public function update()
    {
        $this->authorize('permission:schedule.edit');

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
    }

    public function destroy(Schedule $schedule)
    {
        $this->authorize('permission:schedule.delete');

        $schedule->delete();

        $this->emit('tableRefresh');
        $this->emit('msg', ['message' => 'Schedule deleted.']);
    }

    public function clear()
    {
        $this->reset();
        $this->resetErrorBag();
    }
}
