<?php

namespace App\Http\Livewire\Admin\Evaluation\Questionnaire\Category;

use App\Http\Livewire\LivewireForm;
use App\Models\QuestionCategory;
use Livewire\Component;

class Create extends Component
{
    use LivewireForm;

    public $category;

    public function render()
    {
        return view('livewire.admin.evaluation.questionnaire.category.create');
    }

    public function store()
    {
        $this->validate([
            'category' => 'required',
        ]);

        try {
            QuestionCategory::create([
                'category' => $this->category,
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            return $this->emitError($e);
        }

        $this->emit('tableRefresh', ['id' => '#dt_categories']);
        $this->emit('closeModal', ['id' => '#mdl_create_category']);
        $this->toast('Category created.');
    }

    public function clear()
    {
        $this->reset();
        $this->resetErrorBag();
    }
}
