@extends('layouts.app')

@section('content')
<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <i class="ik ik-users bg-dark"></i>
                <div class="d-inline">
                    <h5>Students</h5>
                    <span>Manage Students</span>
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
                        School
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Students</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-block text-right">
                @can('instructor.create')
                <a class="btn btn-outline-primary" data-toggle="modal" href="#mdl_create" type="button">
                    <i class="ik ik-plus"></i> CREATE STUDENT
                </a>
                @endcan
            </div>
            <div class="card-body">
                <form id="frm_search" class="form-inline mb-5" x-data="searchFilter()" x-on:submit.prevent="filter()">
                    <label class="mr-2">
                        Search:
                    </label>
                    <select x-model="status" class="form-control mr-2" data-toggle="tooltip" title="Status Filter">
                        <option value="">All Status</option>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                    <select x-model="column" class="form-control mr-2" data-toggle="tooltip" title="Column Filter">
                        <option value="1">ID</option>
                        <option value="2">STUDENT ID</option>
                        <option value="3">LAST NAME</option>
                        <option value="4">FIRST NAME</option>
                        <option value="5">MIDDLE NAME</option>
                    </select>
                    <span class="input-group mb-0 mr-2">
                        <input x-model="search" type="text" class="form-control" placeholder="Search">
                        <div class="input-group-append">
                            <button type="button" x-on:click="filter()" class="btn btn-light ik ik-search border border-gray-800" data-toggle="tooltip" title="Search"></button>
                        </div>
                    </span>
                    <button x-show.transition="isClean()" type="button" class="btn text-red ik ik-x rounded-0" x-on:click="reset()" data-toggle="tooltip" title="Reset" style="padding-bottom: 26px"></button>
                </form>
                <table id="dt_students" class="table table-hover border-bottom table-responsive" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>STUDENT ID</th>
                            <th>LAST NAME</th>
                            <th>FIRST NAME</th>
                            <th>MIDDLE NAME</th>
                            <th>GRADE</th>
                            <th>CLASS</th>
                            <th>STATUS</th>
                            <th class="w-1"></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="mdl_create" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0">
            <div class="modal-header">
                <h6 class="modal-title">Create Student</h6>
            </div>
            <div class="modal-body">
                @livewire('admin.school.student.create')
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="mdl_edit" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0">
            <div class="modal-header">
                <h6 class="modal-title">Edit Student</h6>
            </div>
            <div class="modal-body">
                @livewire('admin.school.instructor.edit')
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let dt_students;
    let frm_search = {};

    function searchFilter() {
        return {
            search: '',
            column: 1,
            status: '',
            filter() {
                frm_search = {
                    column: this.column,
                    search: this.search,
                    status: this.status,
                };

                dt_students.ajax.reload();
            },
            isClean() {
                if (this.column != 1 || this.search.length || this.status != '') {
                    return true;
                }

                return false;
            },
            reset() {
                this.column = 1;
                this.search = '';
                this.status = '';

                this.filter();
            }
        }
    }

    $(function () {
        dt_students = $('#dt_students').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route("admin.school.student.table") }}',
                method: 'post',
                data: function (d) {
                    d.form = frm_search;
                }
            },
            columns: [{
                data: 'id',
                name: 'id',
                className: 'dt-body-right',
            }, {
                data: 'student_id',
                name: 'student_id'
            }, {
                data: 'last_name',
                name: 'last_name',
            }, {
                data: 'first_name',
                name: 'first_name',
            }, {
                data: 'middle_name',
                name: 'middle_name',
            }, {
                data: 'section.grade',
                name: 'section.grade',
                className: 'dt-body-right',
                orderable: false,
            }, {
                data: 'section.name',
                name: 'section.name',
                orderable: false,
            }, {
                data: 'html_status',
                name: 'html_status',
                className: 'dt-btn dt-body-left',
            }, {
                data: 'btn',
                name: 'btn',
                className: 'dt-btn',
                orderable: false,
            }]
        });

        Livewire.on('tableRefresh', () => {
            dt_students.ajax.reload(null, false);
        });
    });

</script>
@endpush
