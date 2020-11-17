<?php

namespace App\Http\Livewire\Admin\Evaluation\Questionnaire\Question;

use App\Http\Livewire\LivewireForm;
use App\Models\Question;
use App\Models\QuestionGroup;
use Livewire\Component;

class Create extends Component
{
    use LivewireForm;

    public $question = '';
    public $group = '';

    public function render()
    {
        return view('livewire.admin.evaluation.questionnaire.question.create', [
            'groups' => QuestionGroup::query()->get(),
        ]);
    }

    public function store()
    {
        $this->validate([
            'group' => 'required|integer',
            'question' => 'required',
        ]);

        Question::create([
            'group_id' => $this->group,
            'question' => $this->question,
        ]);

        $this->emit('closeModal', ['id' => '#mdl_create_question']);
        $this->dispatchBrowserEvent('reRenderQuestionnaire');
        $this->toast('Question Created.');
        $this->clear();
    }

    public function clear()
    {
        $this->reset();
        $this->resetErrorBag();
    }
}
