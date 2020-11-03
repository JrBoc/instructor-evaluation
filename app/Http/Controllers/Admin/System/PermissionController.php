<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {
        return view('pages.admin.system.permission');
    }

    public function table(Request $request)
    {
        $form = [
            'search' => $request->form['search'] ?? null,
            'column' => $request->form['column'] ?? null,
        ];

        $permissions = Permission::query();

        $columns = [
            1 => 'id',
            2 => 'SUBSTRING_INDEX(NAME,\'.\',1) LIKE ?', // Module
            3 => 'SUBSTRING_INDEX(NAME,\'.\',2) LIKE ?', // Permission,
        ];

        return datatables()
            ->eloquent($permissions)
            ->searchFilter($columns, $form)
            ->addColumn('btn', function ($permission) {
                return
                    '<button data-toggle="tooltip" title="Edit" type="button" class="btn btn-outline-primary btn-icon btn-edit mr-2" value="' . $permission->id . '"><i class="ik ik-edit"></i></button>' .
                    '<button data-toggle="tooltip" title="Delete" type="button" class="btn btn-outline-danger btn-icon btn-delete" value="' . $permission->id . '"><i class="ik ik-trash"></i></button>';
            })
            ->rawColumns(['btn'])
            ->toJson();
    }
}
