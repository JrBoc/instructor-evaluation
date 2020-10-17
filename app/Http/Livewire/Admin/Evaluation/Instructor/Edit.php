<?php

namespace App\Http\Livewire\Admin\Evaluation\Instructor;

use App\Http\Livewire\LivewireForm;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class Edit extends Component
{
    use LivewireForm, AuthorizesRequests;

    public function render()
    {
        return view('livewire.admin.evaluation.instructor.edit');
    }

    public function get()
    {
        //
    }

    public function update()
    {
        $this->authorize('permission:instructor.edit');
    }

    public function destroy()
    {
        $this->authorize('permission:instructor.delete');
    }
}
