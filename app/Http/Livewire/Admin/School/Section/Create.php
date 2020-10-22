<?php

namespace App\Http\Livewire\Admin\School\Section;

use App\Models\Section;
use App\Models\Subject;
use Livewire\Component;
use App\Models\Instructor;
use App\Http\Livewire\LivewireForm;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Create extends Component
{
    use LivewireForm, AuthorizesRequests;

    public $name = '';
    public $grade = '';
    public $subject = '';
    public $instructor = '';
    public $semester = 1;
    public $status = 1;

    public $assignments = [
        1 => [],
        2 => [],
    ];

    public function render()
    {
        return view('livewire.admin.school.section.create', [
            'stored_subjects' => Subject::query()->where('grade', $this->grade)->get(),
            'stored_instructors' =>  Instructor::all(),
        ]);
    }

    public function addAssignment()
    {
        $this->validate([
            'subject' => 'required',
            'instructor' => 'required',
        ]);

        $this->subject = (json_decode($this->subject, true));
        $this->instructor = (json_decode($this->instructor, true));

        $selected_assignment = [
            'subject' => [
                'id' => $this->subject['id'],
                'name' => $this->subject['name'],
            ],
            'instructor' => [
                'id' => $this->instructor['id'],
                'name' => $this->instructor['formatted_full_name'],
            ],
            'semester' => $this->semester,
        ];

        $filter_assignments = collect($this->assignments[$this->semester])->filter(function ($key) {
            return $key['subject']['id'] == $this->subject['id'];
        })->count();

        if ($filter_assignments) {
            $this->emit('closeDialogBox');

            return $this->addError('subject', 'Selected subject already exists.');
        }

        $this->assignments[$this->semester][] = $selected_assignment;
        $this->subject = '';
        $this->instructor = '';
    }

    public function removeAssignment($key)
    {
        unset($this->assignments[$this->semester][$key]);
    }

    public function store()
    {
        $this->authorize('permission:class.create');

        $data = $this->validate([
            'grade' => 'required|integer',
            'name' => 'required|string',
        ]);

        $section = Section::create($data);

        $selected_assignments = [];

        foreach ($this->assignments as $semester) {
            foreach ($semester as $assignment) {
                $selected_assignments[] = [
                    'subject_id' => $assignment['subject']['id'],
                    'instructor_id' => $assignment['instructor']['id'],
                    'semester' => $assignment['semester']
                ];
            }
        }

        $section->assignments()->createMany($selected_assignments);

        $this->clear();

        $this->emit('tableRefresh');
        $this->emit('closeModal', ['id' => '#mdl_create']);
        $this->emit('msg', ['message' => 'Subject created']);
    }

    public function updatedSemester()
    {
        $this->subject = '';
        $this->instructor = '';

        $this->resetErrorBag([
            'subject', 'instructor',
        ]);
    }

    public function clear()
    {
        $this->reset();
        $this->resetErrorBag();
    }
}
