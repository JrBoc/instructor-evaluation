<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        return view('pages.admin.system.role');
    }

    public function table(Request $request)
    {
        $form = [
            'search' => $request->form['search'] ?? null,
            'column' => $request->form['column'] ?? null,
        ];

        $roles = Role::query();

        $columns = [
            1 => 'id',
            2 => 'name',
        ];

        return datatables()
            ->eloquent($roles)
            ->searchFilter($columns, $form)
            ->addColumn('btn', function ($role) {
                if ($role->name == 'Super Admin') {
                    return null;
                }

                return
                    '<button data-toggle="tooltip" title="View" type="button" class="btn btn-light btn-icon btn-view mr-2 border-dark" value="' . $role->id . '"><i class="ik ik-eye"></i></button>' .
                    '<button data-toggle="tooltip" title="Edit" type="button" class="btn btn-outline-primary btn-icon btn-edit mr-2" value="' . $role->id . '"><i class="ik ik-edit"></i></button>' .
                    '<button data-toggle="tooltip" title="Delete" type="button" class="btn btn-outline-danger btn-icon btn-delete" value="' . $role->id . '"><i class="ik ik-trash"></i></button>';
            })
            ->rawColumns(['btn'])
            ->toJson();
    }
}
