<?php

namespace App\Http\Livewire\Admin\Evaluation\Questionnaire;

use App\Models\Question;
use App\Models\QuestionGroup;
use Livewire\Component;

class Table extends Component
{
    public function render()
    {
        return view('livewire.admin.evaluation.questionnaire.table', [
            'groups' => QuestionGroup::query()->with('questions')->get(),
        ]);
    }

    public function reRender()
    {
        $this->render();
    }

    public function increment(Question $question)
    {
        $otherQuestion = Question::query()->where('order_id', $question->order_id + 1)->where('group_id', $question->group_id)->first();

        if(!$otherQuestion) {
            return;
        }

        $otherQuestion->update([
            'order_id' => $question->order_id,
        ]);

        $question->update([
            'order_id' => $question->order_id + 1,
        ]);

        $this->reRender();
    }

    public function decrement(Question $question)
    {
        $otherQuestion = Question::query()->where('order_id', $question->order_id - 1)->where('group_id', $question->group_id)->first();

        if(!$otherQuestion) {
            return;
        }

        $otherQuestion->update([
            'order_id' => $question->order_id,
        ]);

        $question->update([
            'order_id' => $question->order_id - 1,
        ]);

        $this->reRender();
    }
}
