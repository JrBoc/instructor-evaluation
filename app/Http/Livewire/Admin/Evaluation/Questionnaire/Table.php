<?php

namespace App\Http\Livewire\Admin\Evaluation\Questionnaire;

use App\Http\Livewire\LivewireForm;
use App\Models\Question;
use App\Models\QuestionGroup;
use Livewire\Component;

class Table extends Component
{
    use LivewireForm;

    public function render()
    {
        return view('livewire.admin.evaluation.questionnaire.table', [
            'groups' => QuestionGroup::query()->with('questions')->orderBy('order_id', 'asc')->get(),
            'totalQuestions' => Question::count(),
        ]);
    }

    public function reRender()
    {
        $this->render();
    }

    public function moveQuestionDown(Question $question)
    {
        $orderIds = Question::query()
            ->where('group_id', $question->group_id)
            ->orderBy('order_id', 'asc')
            ->pluck('order_id')
            ->toArray();

        $index = array_search($question->order_id, $orderIds);

        if (!$orderIds[$index + 1]) {
            return $this->toast('Cannot Move Question.', 'error');
        }

        Question::query()
            ->where('group_id', $question->group_id)
            ->where('order_id', $orderIds[$index + 1])
            ->update([
                'order_id' => $orderIds[$index],
            ]);

        $question->update([
            'order_id' => $orderIds[$index + 1],
        ]);

        $this->toast('Question Moved Down.');
        $this->reRender();
    }

    public function moveQuestionUp(Question $question)
    {
        $orderIds = Question::query()
            ->where('group_id', $question->group_id)
            ->orderBy('order_id', 'asc')
            ->pluck('order_id')
            ->toArray();

        $index = array_search($question->order_id, $orderIds);

        if (!$orderIds[$index - 1]) {
            return $this->toast('Cannot Move Question.', 'error');
        }

        Question::query()
            ->where('group_id', $question->group_id)
            ->where('order_id', $orderIds[$index - 1])
            ->update([
                'order_id' => $orderIds[$index],
            ]);

        $question->update([
            'order_id' => $orderIds[$index - 1],
        ]);

        $this->toast('Question Moved Up.');
        $this->reRender();
    }

    public function moveGroupDown(QuestionGroup $questionGroup)
    {
        $orderIds = QuestionGroup::query()
            ->orderBy('order_id', 'asc')
            ->pluck('order_id')
            ->toArray();

        $index = array_search($questionGroup->order_id, $orderIds);

        if (!$orderIds[$index + 1]) {
            return $this->toast('Cannot Move Question.', 'error');
        }

        QuestionGroup::query()
            ->where('order_id', $orderIds[$index + 1])
            ->update([
                'order_id' => $orderIds[$index],
            ]);

        $questionGroup->update([
            'order_id' => $orderIds[$index + 1],
        ]);

        $this->toast('Group Moved Down.');
        $this->reRender();
    }

    public function moveGroupUp(QuestionGroup $questionGroup)
    {
        $orderIds = QuestionGroup::query()
            ->orderBy('order_id', 'asc')
            ->pluck('order_id')
            ->toArray();

        $index = array_search($questionGroup->order_id, $orderIds);

        if (!$orderIds[$index - 1]) {
            return $this->toast('Cannot Move Group.', 'error');
        }

        QuestionGroup::query()
            ->where('order_id', $orderIds[$index - 1])
            ->update([
                'order_id' => $orderIds[$index],
            ]);

        $questionGroup->update([
            'order_id' => $orderIds[$index - 1],
        ]);

        $this->toast('Group Moved Up.');
        $this->reRender();
    }
}
