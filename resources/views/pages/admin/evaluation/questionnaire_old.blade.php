@extends('layouts.app')

@section('content')
<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <i class="ik ik-calendar bg-dark"></i>
                <div class="d-inline">
                    <h5>Questionnaire</h5>
                    <span>Manage the Questionnaire to be answered.</span>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <nav class="breadcrumb-container" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#dashboard"><i class="ik ik-home"></i></a>
                    </li>
                    <li class="breadcrumb-item">
                        Evaluation
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Questionnaire</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <ul class="nav nav-tabs nav-fill mt-10" id="schedule_tabs" role="tablist">
                <li class="nav-item border-top-0 pl-10">
                    <a class="nav-link active" href="#questions" data-toggle="tab" role="tab">Questions</a>
                </li>
                <li class="nav-item pr-10">
                    <a class="nav-link" href="#categories" data-toggle="tab" role="tab">Categories</a>
                </li>
            </ul>
            <div class="card-body">
                <div class="tab-content">
                    <div id="questions" class="tab-pane active" role="tabpanel">
                        <div class="d-block text-right">
                            @can('question.create')
                            <a class="btn btn-outline-primary" data-toggle="modal" href="#mdl_create" type="button">
                                <i class="ik ik-plus"></i> CREATE QUESTION
                            </a>
                            @endcan
                        </div>
                        <form id="frm_search_questions" class="form-inline mb-5" x-data="searchFilterQuestions()" x-on:submit.prevent="filter()">
                            <label class="mr-2">
                                Search:
                            </label>
                            <select x-model="column" class="form-control mr-2" data-toggle="tooltip" title="Status Filter">
                                <option value="1">ID</option>
                                <option value="2">CATEGORY ID</option>
                                <option value="3">QUESTION</option>
                            </select>
                            <span class="input-group mb-0 mr-2">
                                <input x-model="search" type="text" class="form-control" placeholder="Search">
                                <div class="input-group-append">
                                    <button type="button" x-on:click="filter()" class="btn btn-light ik ik-search border border-gray-800" data-toggle="tooltip" title="Search"></button>
                                </div>
                            </span>
                            <button x-show.transition="isClean()" type="button" class="btn text-red ik ik-x rounded-0" x-on:click="reset()" data-toggle="tooltip" title="Reset" style="padding-bottom: 26px"></button>
                        </form>
                        <table id="dt_questions" class="table table-hover border-bottom table-responsive" style="width: 100%;">
                            <thead >
                                <tr>
                                    <th>ID</th>
                                    <th>CATEGORY ID</th>
                                    <th>QUESTION</th>
                                    <th></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div id="categories" class="tab-pane fade" role="tabpanel">
                        <div class="d-block text-right">
                            @can('question.create')
                            <a class="btn btn-outline-primary" data-toggle="modal" href="#mdl_create_category" type="button">
                                <i class="ik ik-plus"></i> CREATE CATEGORY
                            </a>
                            @endcan
                        </div>
                        <form id="frm_search_categories" class="form-inline mb-5" x-data="searchFilterCategories()" x-on:submit.prevent="filter()">
                            <label class="mr-2">
                                Search:
                            </label>
                            <select x-model="column" class="form-control mr-2" data-toggle="tooltip" title="Column Filter">
                                <option value="1">ID</option>
                                <option value="2">CATEGORY</option>
                            </select>
                            <span class="input-group mb-0 mr-2">
                                <input x-model="search" type="text" class="form-control" placeholder="Search">
                                <div class="input-group-append">
                                    <button type="button" x-on:click="filter()" class="btn btn-light ik ik-search border border-gray-800" data-toggle="tooltip" title="Search"></button>
                                </div>
                            </span>
                            <button x-show.transition="isClean()" type="button" class="btn text-red ik ik-x rounded-0" x-on:click="reset()" data-toggle="tooltip" title="Reset" style="padding-bottom: 26px"></button>
                        </form>
                        <table id="dt_categories" class="table table-hover border-bottom table-responsive" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>CATEGORY</th>
                                    <th></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modals -->
<!-- Questions -->
<div class="modal fade" id="mdl_create_question" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0">
            <div class="modal-header">
                <h6 class="modal-title">Create Question</h6>
            </div>
            <div class="modal-body">
                @livewire('admin.evaluation.questionnaire.question.create')
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="mdl_edit_question" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content border-0">
            <div class="modal-header">
                <h6 class="modal-title">Edit Question</h6>
            </div>
            <div class="modal-body">
                @livewire('admin.evaluation.questionnaire.question.edit')
            </div>
        </div>
    </div>
</div>
<!-- Category -->
<div class="modal fade" id="mdl_create_category" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0">
            <div class="modal-header">
                <h6 class="modal-title">Create Category</h6>
            </div>
            <div class="modal-body">
                @livewire('admin.evaluation.questionnaire.category.create')
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="mdl_edit_category" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content border-0">
            <div class="modal-header">
                <h6 class="modal-title">Edit Category</h6>
            </div>
            <div class="modal-body">
                @livewire('admin.evaluation.questionnaire.category.edit')
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let dt_questions;
    let dt_categories;
    let frm_search_categories = {};
    let frm_search_questions = {};

    function searchFilterQuestions() {
        return {
            column: 1,
            search: '',
            filter() {
                frm_search_questions = {
                    column: this.column,
                    search: this.search,
                };

                dt_questions.ajax.reload();
            },
            isClean() {
                if (this.column != 1 || this.search.length) {
                    return true;
                }

                return false;
            },
            reset() {
                this.column = 1;
                this.search = '';

                this.filter();
            }
        }
    }

    function searchFilterCategories() {
        return {
            column: 1,
            search: '',
            status: '',
            filter() {
                frm_search_categories = {
                    column: this.column,
                    search: this.search,
                };

                dt_categories.ajax.reload();
            },
            isClean() {
                if (this.column != 1 || this.search.length) {
                    return true;
                }

                return false;
            },
            reset() {
                this.column = 1;
                this.search = '';

                this.filter();
            }
        }
    }

    $(function () {
        dt_questions = $('#dt_questions').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route("admin.evaluation.questionnaire.table_questions") }}',
                method: 'post',
                data: function (d) {
                    d.form = frm_search_questions;
                }
            },
            columns: [{
                data: 'id',
                name: 'id',
                className: 'dt-body-right w-1 text-nowrap',
            }, {
                data: 'category_id',
                name: 'category_id',
                className: 'dt-body-right w-1 text-nowrap',
            }, {
                data: 'question',
                name: 'question',
            }, {
                data: 'btn',
                name: 'btn',
                orderable: false,
                className: 'dt-body-right dt-btn',
            }]
        });

        dt_categories = $('#dt_categories').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route("admin.evaluation.questionnaire.table_categories") }}',
                method: 'post',
                data: function (d) {
                    d.form = frm_search_categories;
                }
            },
            columns: [{
                data: 'id',
                name: 'id',
                className: 'dt-body-right w-1 text-nowrap',
            }, {
                data: 'category',
                name: 'category',
            }, {
                data: 'btn',
                name: 'btn',
                orderable: false,
                className: 'dt-body-right dt-btn',
            }]
        });

        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });

        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });

</script>
@endpush
