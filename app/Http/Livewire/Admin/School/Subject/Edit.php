<?php

namespace App\Http\Livewire\Admin\School\Subject;

use App\Models\Subject;
use Livewire\Component;
use Illuminate\Validation\Rule;
use App\Http\Livewire\LivewireForm;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Edit extends Component
{
    use LivewireForm, AuthorizesRequests;

    public $subject;
    public $name = '';
    public $grade = '';

    public function render()
    {
        return view('livewire.admin.school.subject.edit');
    }

    public function get(Subject $subject)
    {
        $this->subject = $subject;

        $this->grade = $subject->grade;
        $this->name = $subject->name;

        $this->emit('openModal', [
            'id' => '#mdl_edit',
            'title' => 'Edit Subject'
        ]);
    }

    public function update()
    {
        $this->authorize('permission:subject.edit');

        $data = $this->validate([
            'grade' => 'required|integer|in:' . implode(',', config('evaluation.grades')),
            'name' => [
                'required',
                'string',
                Rule::unique('eval_subjects')
                    ->ignore($this->subject->id)
                    ->where(function ($q) {
                        return $q->where('grade', $this->grade);
                    }),
            ],
        ], null, [
            'name' => 'subject'
        ]);

        $this->subject->update($data);

        $this->emit('tableRefresh');
        $this->emit('closeModal', ['id' => '#mdl_edit']);
        $this->emit('msg', ['message' => 'Subject updated.']);
    }

    public function destroy(Subject $subject)
    {
        $this->authorize('permission:subject.delete');

        $subject->delete();

        $this->emit('tableRefresh');
        $this->emit('msg', ['message' => 'Subject deleted.']);
    }

    public function clear()
    {
        $this->reset();
        $this->resetErrorBag();
    }
}
