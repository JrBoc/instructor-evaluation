<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Yajra\DataTables\DataTableAbstract;

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
        DataTableAbstract::macro('searchFilter', function ($columns = [], $form = [], $selectionFilters = []) {
            return $this->filter(function ($query) use ($columns, $form, $selectionFilters)  {
                if(!is_null($form) && !is_null($columns)) {
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
                }

                if(!is_null($selectionFilters) && !is_null($form)) {
                    foreach($selectionFilters as $columnKey => $formKey) {
                        if (!is_null($form[$formKey])) {
                            $query->where($columnKey, $form[$formKey]);
                        }
                    }
                }
            });
        });
    }
}
