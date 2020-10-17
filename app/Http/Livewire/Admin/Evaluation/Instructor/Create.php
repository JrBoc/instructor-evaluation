<?php

namespace App\Http\Livewire\Admin\Evaluation\Instructor;

use App\Http\Livewire\LivewireForm;
use App\Models\Instructor;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class Create extends Component
{
    use LivewireForm, AuthorizesRequests;

    public $title = '';
    public $last_name = '';
    public $first_name = '';
    public $middle_name = '';
    public $status = true;

    public function render()
    {
        return view('livewire.admin.evaluation.instructor.create');
    }

    public function store()
    {
        $this->authorize('permission:instructor.create');

        $validated_data = $this->validate([
            'title' => 'required|string',
            'last_name' => 'required|string',
            'first_name' => 'required|string',
            'middle_name' => 'nullable|string',
            'status' => 'nullable|boolean',
        ]);

        Instructor::create($validated_data);

        $this->clear();

        $this->emit('tableRefresh');
        $this->emit('closeModal', ['id' => '#mdl_create']);
        $this->emit('msg', ['message' => 'Instructor created']);
    }

    public function clear()
    {
        $this->reset();
        $this->resetErrorBag();
    }
}
