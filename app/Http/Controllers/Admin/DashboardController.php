<?php

namespace App\Http\Controllers\Admin;

use App\Models\Instructor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('pages.admin.dashboard', [
            'instructors' => number_format(Instructor::count()),
        ]);
    }
}
