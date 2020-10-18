<?php

namespace App\Http\Livewire\Admin\Evaluation\Subject;

use App\Models\Subject;
use Livewire\Component;
use Illuminate\Validation\Rule;
use App\Http\Livewire\LivewireForm;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Create extends Component
{
    use LivewireForm, AuthorizesRequests;

    public $name = '';
    public $grade = '';

    public function render()
    {
        return view('livewire.admin.evaluation.subject.create');
    }

    public function store()
    {
        $this->authorize('permission:subject.create');

        $data = $this->validate([
            'grade' => 'required|integer|in:' . implode(',', config('evaluation.grades')),
            'name' => [
                'required',
                'string',
                Rule::unique('eval_subjects', 'name')->where(function ($q) {
                    $q->where('grade', $this->grade);
                })
            ],
        ], null, [
            'name' => 'subject'
        ]);

        Subject::create($data);

        $this->clear();

        $this->emit('tableRefresh');
        $this->emit('closeModal', ['id' => '#mdl_create']);
        $this->emit('msg', ['message' => 'Subject created']);
    }

    public function clear()
    {
        $this->reset();
        $this->resetErrorBag();
    }
}
