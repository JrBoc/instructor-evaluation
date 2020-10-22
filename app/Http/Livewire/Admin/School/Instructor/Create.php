<?php

namespace App\Http\Livewire\Admin\School\Instructor;

use Livewire\Component;
use App\Models\Instructor;
use App\Http\Livewire\LivewireForm;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

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
        return view('livewire.admin.school.instructor.create');
    }

    public function store()
    {
        $this->authorize('permission:instructor.create');

        $data = $this->validate([
            'title' => 'required|string',
            'last_name' => 'required|string',
            'first_name' => 'required|string',
            'middle_name' => 'nullable|string',
            'status' => 'nullable|boolean',
        ]);

        Instructor::create($data);

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
