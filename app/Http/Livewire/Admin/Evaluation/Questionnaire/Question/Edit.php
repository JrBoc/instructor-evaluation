<?php

namespace App\Http\Livewire\Admin\Evaluation\Questionnaire\Question;

use App\Http\Livewire\LivewireForm;
use App\Models\Question;
use App\Models\QuestionGroup;
use Livewire\Component;

class Edit extends Component
{
    use LivewireForm;

    public $questionModel;
    public $question = '';
    public $group = '';

    public function render()
    {
        return view('livewire.admin.evaluation.questionnaire.question.edit', [
            'groups' => QuestionGroup::query()->get(),
        ]);
    }

    public function destroy(Question $question)
    {
        $question->delete();

        $this->dispatchBrowserEvent('reRenderQuestionnaire');
        $this->toast('Question Deleted.');
    }

    public function update()
    {
        $this->validate([
            'group' => 'required|integer',
            'question' => 'required',
        ]);

        $this->questionModel->update([
            'group_id' => $this->group,
            'question' => $this->question,
        ]);

        $this->emit('closeModal', ['id' => '#mdl_edit_question']);
        $this->dispatchBrowserEvent('reRenderQuestionnaire');
        $this->toast('Question Updated.');
        $this->clear();
    }

    public function get(Question $question)
    {
        $this->questionModel = $question;

        $this->question = $question->question;
        $this->group = $question->group_id;

        $this->emit('openModal', ['id' => '#mdl_edit_question']);
    }

    public function clear()
    {
        $this->reset();
        $this->resetErrorBag();
    }
}
