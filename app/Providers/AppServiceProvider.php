<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Support\ServiceProvider;
use Yajra\DataTables\EloquentDataTable;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        EloquentDataTable::macro('searchFilter', function ($columns, $form) {
            return $this->filter(function ($query) use ($columns, $form)  {
                if (!is_null($form['search']) && isset($columns[$form['column']])) {
                    if (is_array($columns[$form['column']])) {
                        $query->whereHas($columns[$form['column']][0], function ($q) use ($form, $columns) {
                            if (strpos($columns[$form['column']][1], '?') != false) {
                                $q->whereRaw($columns[$form['column']][1], ['%' . $form['search'] . '%']);
                            } else {
                                $q->where($columns[$form['column']][1], 'LIKE', '%' . $form['search'] . '%');
                            }
                        });
                    } else {
                        if (strpos($columns[$form['column']], '?') != false) {
                            $query->whereRaw($columns[$form['column']], '%' . $form['search'] . '%');
                        } else {
                            $query->where($columns[$form['column']], 'LIKE', '%' . $form['search'] . '%');
                        }
                    }
                }
            });
        });
    }
}
