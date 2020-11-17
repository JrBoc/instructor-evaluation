<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login()
    {
        return view('pages.student.login');
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('student.login');
    }
}
