<?php

namespace App\Http\Livewire\Admin\Evaluation\Schedule;

use Livewire\Component;

class Create extends Component
{
    public $school_year;
    public $section;
    public $semester;
    public $date;
    public $start;
    public $end;
    public $status;

    public function render()
    {
        return view('livewire.admin.evaluation.schedule.create');
    }
}
