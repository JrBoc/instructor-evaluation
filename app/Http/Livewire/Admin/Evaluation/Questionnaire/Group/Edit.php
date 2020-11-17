<?php

namespace App\Http\Livewire\Admin\Evaluation\Questionnaire\Group;

use App\Http\Livewire\LivewireForm;
use App\Models\QuestionGroup;
use Livewire\Component;

class Edit extends Component
{
    use LivewireForm;

    public $group;
    public $name = '';

    public function render()
    {
        return view('livewire.admin.evaluation.questionnaire.group.edit');
    }

    public function get(QuestionGroup $questionGroup)
    {
        $this->group = $questionGroup;
        $this->name = $questionGroup->name;

        $this->emit('openModal', ['id' => '#mdl_edit_group']);
    }

    public function destroy(QuestionGroup $questionGroup)
    {
        $questionGroup->delete();

        $this->dispatchBrowserEvent('reRenderQuestionnaire');
        $this->toast('Group and Questions within Deleted.');
    }

    public function update()
    {
        $this->validate([
            'name' => 'required',
        ]);

        $this->group->update([
            'name' => $this->name,
        ]);

        $this->emit('closeModal', ['id' => '#mdl_edit_group']);
        $this->dispatchBrowserEvent('reRenderQuestionnaire');
        $this->toast('Group Updated.');
        $this->clear();
    }

    public function clear()
    {
        $this->reset();
        $this->resetErrorBag();
    }
}
