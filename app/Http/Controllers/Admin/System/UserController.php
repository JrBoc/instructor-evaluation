<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('pages.admin.system.user', [
            'title' => 'User',
        ]);
    }

    public function table(Request $request)
    {
        $form = [
            'status' => $request->form['status'] ?? null,
            'search' => $request->form['search'] ?? null,
            'column' => $request->form['column'] ?? null,
        ];

        $users = User::query()->with('roles');

        $columns = [
            1 => 'id',
            2 => 'name',
            3 => 'email',
        ];

        return datatables()
            ->eloquent($users)
            ->searchFilter($columns, $form, function($query) use ($form) {
                if (!is_null($form['status'])) {
                    $query->where('status', $form['status']);
                }
            })
            ->editColumn('roles', function ($user) {
                $roles = '';

                foreach ($user->roles as $role) {
                    $roles .= '<label class="badge badge-info mb-1 mb-md-0 mr-1">' . $role->name . '</label>';
                }

                return $roles;
            })
            ->addColumn('btn', function ($user) {
                return
                    '<button data-toggle="tooltip" title="View" type="button" class="btn btn-light btn-icon btn-view mr-2 border-dark" value="' . $user->id . '"><i class="ik ik-eye"></i></button>' .
                    '<button data-toggle="tooltip" title="Edit" type="button" class="btn btn-outline-primary btn-icon btn-edit mr-2" value="' . $user->id . '"><i class="ik ik-edit"></i></button>' .
                    '<button data-toggle="tooltip" title="Delete" type="button" class="btn btn-outline-danger btn-icon btn-delete" value="' . $user->id . '"><i class="ik ik-trash"></i></button>';
            })
            ->addColumn('html_status', function ($user) {
                return $user->html_status;
            })
            ->rawColumns(['btn', 'html_status', 'roles'])
            ->toJson();
    }
}
