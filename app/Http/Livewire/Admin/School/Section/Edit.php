<?php

namespace App\Http\Livewire\Admin\School\Section;

use App\Models\Section;
use App\Models\Subject;
use Livewire\Component;
use App\Models\Instructor;
use App\Http\Livewire\LivewireForm;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Edit extends Component
{
    use LivewireForm, AuthorizesRequests;

    public $section;
    public $name = '';
    public $grade = '';
    public $subject = '';
    public $instructor = '';
    public $semester = 1;
    public $status = 1;
    public $editable = false;

    public $assignments = [
        1 => [],
        2 => [],
    ];

    public function render()
    {
        return view('livewire.admin.school.section.edit', [
            'stored_subjects' => Subject::query()->where('grade', $this->grade)->get(),
            'stored_instructors' =>  Instructor::all(),
        ]);
    }

    public function get(Section $section, $editable = false)
    {
        $this->section = $section;

        $this->name = $section->name;
        $this->grade = $section->grade;
        $this->status = $section->status;

        foreach ($section->assignments as $assignment) {
            $this->assignments[$assignment->semester][] = [
                'instructor' => [
                    'id' => $assignment->instructor->id,
                    'name' => $assignment->instructor->formatted_full_name,
                ],
                'subject' => [
                    'id' => $assignment->subject->id,
                    'name' => $assignment->subject->name,
                ],
                'semester' => $assignment->semester,
            ];
        }

        $this->editable = $editable;

        $this->emit('openModal', [
            'id' => '#mdl_edit',
            'title' => $this->editable ? 'Edit Class' : 'View Class'
        ]);
    }

    public function update()
    {
        $this->authorize('permission:class.edit');

        $this->validate([
            'grade' => 'required|integer',
            'name' => 'required|string',
            'status' => 'required|boolean',
        ]);

        $this->section->update([
            'grade' => $this->grade,
            'name' => $this->name,
            'status' => $this->status,
        ]);

        $this->section->assignments()->delete();

        foreach ($this->assignments as $semester) {
            foreach ($semester as $assignment) {
                $selected_assignments[] = [
                    'subject_id' => $assignment['subject']['id'],
                    'instructor_id' => $assignment['instructor']['id'],
                    'semester' => $assignment['semester']
                ];
            }
        }

        $this->section->assignments()->createMany($selected_assignments);

        $this->emit('tableRefresh');
        $this->emit('closeModal', ['id' => '#mdl_edit']);
        $this->emit('msg', ['message' => 'Class updated.']);
    }

    public function destroy(Section $section)
    {
        $this->authorize('permission:class.delete');

        $section->delete();

        $this->emit('tableRefresh');
        $this->emit('msg', ['message' => 'Class deleted.']);
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

    public function updatedSemester()
    {
        $this->subject = '';
        $this->instructor = '';

        $this->resetErrorBag([
            'subject', 'instructor',
        ]);
    }

    public function removeAssignment($key)
    {
        unset($this->assignments[$this->semester][$key]);
    }

    public function clear()
    {
        $this->reset();
        $this->resetErrorBag();
    }
}
