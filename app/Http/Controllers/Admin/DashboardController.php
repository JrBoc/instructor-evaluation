<?php

namespace App\Http\Controllers\Admin;

use App\Models\Instructor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\Section;
use App\Models\Student;

class DashboardController extends Controller
{
    public function index()
    {
        return view('pages.admin.dashboard', [
            'instructors' => number_format(Instructor::count()),
            'students' => number_format(Student::count()),
            'sections' => number_format(Section::count()),
            'evaluations' => number_format(Schedule::count()),
        ]);
    }
}
