<?php

namespace App\Http\Livewire\Student\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    public $student_id = '';
    public $password = '';
    public $remember_me = false;
    public $disabled = false;

    public function render()
    {
        return view('livewire.student.auth.login');
    }

    public function login()
    {
        $this->validate([
            'student_id' => 'required|string',
            'password' => 'required',
        ]);

        $data = [
            'student_id' => $this->student_id,
            'password' => $this->password,
        ];

        if (!auth('student')->attempt($data, false)) {
            $this->password = '';

            return $this->addError('student_id', trans('auth.failed'));
        }

        if (!auth('student')->user()->status) {
            auth('student')->logout();

            return $this->addError('student_id', 'Your account is Inactive.');
        }

        session()->flash('login_successful');

        $this->disabled = true;

        $this->dispatchBrowserEvent('redirectToDashboard');
    }
}
