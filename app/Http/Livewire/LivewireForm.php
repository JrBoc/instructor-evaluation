<?php

namespace App\Http\Livewire;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

/**
 * @see vendor\livewire\livewire\src\ComponentConcerns\ValidatesInput.php
 */
trait LivewireForm
{
    protected $validate_messages = [];
    protected $validate_attributes = [];

    public function validate($rules = null, $messages = [], $attributes = [])
    {
        [$rules, $messages, $attributes] = $this->providedOrGlobalRulesMessagesAndAttributes($rules, $messages ?? $this->validate_messages, $attributes ?? $this->validate_attributes);

        $data = $this->prepareForValidation(
            $this->getDataForValidation($rules)
        );

        $validator = Validator::make($data, $rules, $messages, $attributes);

        $this->shortenModelAttributes($data, $rules, $validator);

        if ($validator->fails()) {
            $this->emit('closeDialogBox');

            return $validator->validate();
        }

        $validatedData = $validator->validate();

        $this->resetErrorBag();

        return $validatedData;
    }
}
