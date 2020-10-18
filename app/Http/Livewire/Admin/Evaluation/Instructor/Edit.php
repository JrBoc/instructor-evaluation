<?php

namespace App\Http\Livewire\Admin\Evaluation\Instructor;

use Livewire\Component;
use App\Models\Instructor;
use App\Http\Livewire\LivewireForm;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Edit extends Component
{
    use LivewireForm, AuthorizesRequests;

    public $instructor;
    public $title = '';
    public $last_name = '';
    public $first_name = '';
    public $middle_name = '';
    public $status = true;
    public $editable = false;

    public function render()
    {
        return view('livewire.admin.evaluation.instructor.edit');
    }

    public function get(Instructor $instructor, $editable = false)
    {
        $this->instructor = $instructor;

        $this->title = $instructor->title;
        $this->last_name = $instructor->last_name;
        $this->first_name = $instructor->first_name;
        $this->middle_name = $instructor->middle_name;
        $this->status = $instructor->status;

        $this->editable = $editable;

        $this->emit('openModal', [
            'id' => '#mdl_edit',
            'title' => $this->editable ? 'Edit Instructor' : 'View Instructor'
        ]);
    }

    public function update()
    {
        $this->authorize('permission:instructor.edit');

        $data = $this->validate([
            'title' => 'required|string',
            'last_name' => 'required|string',
            'first_name' => 'required|string',
            'middle_name' => 'nullable|string',
            'status' => 'nullable|boolean',
        ]);

        $this->instructor->update($data);

        $this->emit('tableRefresh');
        $this->emit('closeModal', ['id' => '#mdl_edit']);
        $this->emit('msg', ['message' => 'Instructor updated.']);
    }

    public function destroy(Instructor $instructor)
    {
        $this->authorize('permission:instructor.delete');

        $instructor->delete();

        $this->emit('tableRefresh');
        $this->emit('msg', ['message' => 'Instructor deleted.']);
    }

    public function clear()
    {
        $this->reset();
        $this->resetErrorBag();
    }
}
