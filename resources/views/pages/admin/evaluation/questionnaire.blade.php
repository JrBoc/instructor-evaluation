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
            <div class="card-header d-block text-right border-bottom-0">
                @can('questionnaire.create')
                <div class="d-block">
                    <a class="btn btn-outline-primary" style="width: 200px" data-toggle="modal" href="#mdl_create_question" type="button">
                        <i class="ik ik-plus"></i> CREATE QUESTION
                    </a>
                </div>
                <div class="d-block mt-5">
                    <a class="btn btn-outline-primary" style="width: 200px" data-toggle="modal" href="#mdl_create_group" type="button">
                        <i class="ik ik-plus"></i> CREATE GROUP
                    </a>
                </div>
                @endcan
            </div>
            <div class="card-body">
                @livewire('admin.evaluation.questionnaire.table')
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
    <div class="modal-dialog modal-dialog-centered" role="document">
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
<!-- Group -->
<div class="modal fade" id="mdl_create_group" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0">
            <div class="modal-header">
                <h6 class="modal-title">Create Group</h6>
            </div>
            <div class="modal-body">
                @livewire('admin.evaluation.questionnaire.group.create')
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="mdl_edit_group" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0">
            <div class="modal-header">
                <h6 class="modal-title">Edit Group</h6>
            </div>
            <div class="modal-body">
                @livewire('admin.evaluation.questionnaire.group.edit')
            </div>
        </div>
    </div>
</div>
@endsection
