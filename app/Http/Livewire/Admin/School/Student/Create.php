<?php

namespace App\Http\Livewire\Admin\School\Student;

use App\Models\Section;
use App\Models\Student;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Http\Livewire\LivewireForm;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Create extends Component
{
    use LivewireForm, AuthorizesRequests;

    public $student_id = '';
    public $last_name = '';
    public $first_name = '';
    public $middle_name = '';
    public $grade = '';
    public $section = '';
    public $status = true;

    public function render()
    {
        return view('livewire.admin.school.student.create', [
            'stored_sections' => Section::query()->where('grade', $this->grade)->get(),
        ]);
    }

    public function store()
    {
        $this->authorize('permission:student.create');

        $this->validate([
            'student_id' => 'required|string',
            'last_name' => 'required|string',
            'first_name' => 'required|string',
            'middle_name' => 'nullable|string',
            'grade' => 'required|integer',
            'section' => 'required|integer',
            'status' => 'required|boolean'
        ]);

        try {
            DB::transaction(function() {
                $student = Student::create([
                    'student_id' => $this->student_id,
                    'last_name' => $this->last_name,
                    'first_name' => $this->first_name,
                    'middle_name' => $this->middle_name,
                    'password' => Hash::make(str_replace(' ','',strtolower($this->last_name))),
                    'status' => $this->status,
                ]);

                $student->student_section()->create([
                    'section_id' => $this->section,
                ]);
            });
        } catch(\Illuminate\Database\QueryException $e) {
            $this->clear();

            return $this->emit('errorMsg', ['title' => 'Transaction Error', 'message' => $e->getMessage()]);
        }

        $this->clear();

        $this->emit('tableRefresh');
        $this->emit('closeModal', ['id' => '#mdl_create']);
        $this->emit('msg', ['message' => 'Student created']);
    }

    public function clear()
    {
        $this->reset();
        $this->resetErrorBag();
    }
}
