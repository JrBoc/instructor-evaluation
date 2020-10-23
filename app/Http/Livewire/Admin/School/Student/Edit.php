<?php

namespace App\Http\Livewire\Admin\School\Student;

use App\Models\Section;
use App\Models\Student;
use Livewire\Component;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Livewire\LivewireForm;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Edit extends Component
{
    use LivewireForm, AuthorizesRequests;

    public $student;
    public $student_id = '';
    public $last_name = '';
    public $first_name = '';
    public $middle_name = '';
    public $grade = '';
    public $section = '';
    public $status = true;
    public $editable = false;

    public function render()
    {
        return view('livewire.admin.school.student.edit', [
            'stored_sections' => Section::query()->where('grade', $this->grade)->get(),
        ]);
    }

    public function get(Student $student, $editable = false)
    {
        $this->student = $student;

        $this->student_id = $student->student_id;
        $this->last_name = $student->last_name;
        $this->first_name = $student->first_name;
        $this->middle_name = $student->middle_name;
        $this->status = $student->status;
        $this->grade = $student->section->grade ?? '';
        $this->section = $student->section->id ?? '';

        $this->editable = $editable;

        $this->emit('openModal', ['id' => '#mdl_edit', 'title' => $this->editable ? 'Edit Student' : 'View Student']);
    }

    public function update()
    {
        $this->authorize('permission:student.edit');

        $this->validate([
            'student_id' => [
                'required',
                'string',
                Rule::unique('eval_students', 'student_id')->ignore($this->student->id)
            ],
            'last_name' => 'required|string',
            'first_name' => 'required|string',
            'middle_name' => 'nullable|string',
            'grade' => 'required|integer',
            'section' => 'required|integer',
            'status' => 'required|boolean'
        ]);

        try {
            DB::transaction(function () {
                $this->student->update([
                    'student_id' => $this->student_id,
                    'last_name' => $this->last_name,
                    'first_name' => $this->first_name,
                    'middle_name' => $this->middle_name,
                    'status' => $this->status,
                ]);

                $this->student->student_section()->update([
                    'section_id' => $this->section,
                ]);
            });
        } catch (\Illuminate\Database\QueryException $e) {
            $this->clear();

            return $this->emit('errorMsg', ['title' => 'Transaction Error', 'message' => $e->getMessage()]);
        }

        $this->clear();

        $this->emit('tableRefresh');
        $this->emit('closeModal', ['id' => '#mdl_edit']);
        $this->emit('msg', ['message' => 'Student updated']);
    }

    public function destroy(Student $student)
    {
        $this->authorize('permission:student.delete');

        $student->delete();

        $this->emit('tableRefresh');
        $this->emit('msg', ['message' => 'Student deleted.']);
    }

    public function clear()
    {
        $this->reset();
        $this->resetErrorBag();
    }
}
