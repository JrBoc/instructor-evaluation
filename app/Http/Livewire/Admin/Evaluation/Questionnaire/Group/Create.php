<?php

namespace App\Http\Livewire\Admin\Evaluation\Questionnaire\Group;

use App\Http\Livewire\LivewireForm;
use App\Models\QuestionGroup;
use Livewire\Component;

class Create extends Component
{
    use LivewireForm;

    public $name;

    public function render()
    {
        return view('livewire.admin.evaluation.questionnaire.group.create');
    }

    public function store()
    {
        $this->validate([
            'name' => 'required',
        ]);

        try {
            QuestionGroup::create([
                'name' => $this->name,
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->emitError($e);
        }

        $this->dispatchBrowserEvent('reRenderQuestionnaire');
        $this->emit('closeModal', ['id' => '#mdl_create_group']);
        $this->toast('Group created.');
    }

    public function clear()
    {
        $this->reset();
        $this->resetErrorBag();
    }
}
