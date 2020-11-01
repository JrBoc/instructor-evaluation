@extends('layouts.app')

@section('content')
<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <i class="ik ik-calendar bg-dark"></i>
                <div class="d-inline">
                    <h5>Schedules</h5>
                    <span>Manage Schedules when students Evaluate their instructors</span>
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
                    <li class="breadcrumb-item active" aria-current="page">Schedules</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-block text-right border-bottom-0">
                @can('instructor.create')
                <a class="btn btn-outline-primary" data-toggle="modal" href="#mdl_create" type="button">
                    <i class="ik ik-plus"></i> CREATE SCHEDULE
                </a>
                @endcan
            </div>
            <ul class="nav nav-tabs nav-fill" id="schedule_tabs" role="tablist">
                <li class="nav-item border-top-0 pl-10">
                    <a class="nav-link active" href="#ongoing" data-toggle="tab" role="tab">Ongoing</a>
                </li>
                <li class="nav-item pr-10">
                    <a class="nav-link" href="#past" data-toggle="tab" role="tab">Past Schedules</a>
                </li>
            </ul>
            <div class="card-body">
                <div class="tab-content">
                    <div id="ongoing" class="tab-pane active" role="tabpanel">
                        <form id="frm_search" class="form-inline mb-5" x-data="searchFilter()" x-on:submit.prevent="filter()">
                            <label class="mr-2">
                                Search:
                            </label>
                            <select x-model="status" class="form-control mr-2" data-toggle="tooltip" title="Status Filter">
                                <option value="">All Status</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                            <span class="input-group mb-0 mr-2">
                                <input x-model="search" type="text" class="form-control" placeholder="Search">
                                <div class="input-group-append">
                                    <button type="button" x-on:click="filter()" class="btn btn-light ik ik-search border border-gray-800" data-toggle="tooltip" title="Search"></button>
                                </div>
                            </span>
                            <button x-show.transition="isClean()" type="button" class="btn text-red ik ik-x rounded-0" x-on:click="reset()" data-toggle="tooltip" title="Reset" style="padding-bottom: 26px"></button>
                        </form>
                        <table id="dt_schedules" class="table table-hover border-bottom table-responsive" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>SCHOOL YEAR</th>
                                    <th>SEMESTER</th>
                                    <th>GRADE</th>
                                    <th>CLASS</th>
                                    <th>TYPE</th>
                                    <th>DATE</th>
                                    <th>START TIME</th>
                                    <th>END TIME</th>
                                    <th>STATUS</th>
                                    <th class="w-1"></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div id="past" class="tab-pane fade" role="tabpanel">
                        <div class="col-12 alert alert-info">
                            <i class="ik ik-info"></i> Showing schedules after: {{ now()->format('M j, Y') }}.
                        </div>
                        <table id="dt_past_schedules" class="table table-hover border-bottom table-responsive" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>SCHOOL YEAR</th>
                                    <th>SEMESTER</th>
                                    <th>GRADE</th>
                                    <th>CLASS</th>
                                    <th>TYPE</th>
                                    <th>DATE</th>
                                    <th>START TIME</th>
                                    <th>END TIME</th>
                                    <th class="w-1">STATUS</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="mdl_create" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content border-0">
            <div class="modal-header">
                <h6 class="modal-title">Create Schedule</h6>
            </div>
            <div class="modal-body">
                @livewire('admin.evaluation.schedule.create')
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="mdl_edit" tabindex="-1" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content border-0">
            <div class="modal-header">
                <h6 class="modal-title">Edit Schedule</h6>
            </div>
            <div class="modal-body">
                @livewire('admin.evaluation.schedule.edit')
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let dt_schedules;
    let dt_past_schedules;
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

                dt_schedules.ajax.reload();
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
        dt_schedules = $('#dt_schedules').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route("admin.evaluation.schedule.table") }}',
                method: 'post',
                data: function (d) {
                    d.form = frm_search;
                }
            },
            order: [
                [0, 'desc'],
            ],
            columns: [{
                data: 'id',
                name: 'id',
                className: 'dt-body-right',
            }, {
                data: 'readable_school_year',
                name: 'school_year'
            }, {
                data: 'readable_semester',
                name: 'semester',
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
                data: 'whole_day',
                name: 'whole_day',
                render: function (whole_day) {
                    return !whole_day ? 'TIMED' : 'OPEN'
                }
            }, {
                data: 'date',
                name: 'date',
            }, {
                data: 'start',
                name: 'start',
                render: function (time, t, row) {
                    if (row.whole_day) {
                        return 'WHOLE DAY'
                    }

                    return time;
                }
            }, {
                data: 'end',
                name: 'end',
                render: function (time, t, row) {
                    if (row.whole_day) {
                        return 'WHOLE DAY'
                    }

                    return time;
                }
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

        dt_past_schedules = $('#dt_past_schedules').DataTable({
            processing: true,
            serverSide: true,
            order: [
                [0, 'desc'],
            ],
            ajax: {
                url: '{{ route("admin.evaluation.schedule.table-past") }}',
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
                data: 'readable_school_year',
                name: 'school_year'
            }, {
                data: 'readable_semester',
                name: 'semester',
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
                data: 'whole_day',
                name: 'whole_day',
                render: function (whole_day) {
                    return !whole_day ? 'TIMED' : 'OPEN'
                }
            }, {
                data: 'date',
                name: 'date',
            }, {
                data: 'start',
                name: 'start',
                render: function (time, t, row) {
                    if (row.whole_day) {
                        return 'WHOLE DAY'
                    }

                    return time;
                }
            }, {
                data: 'end',
                name: 'end',
                render: function (time, t, row) {
                    if (row.whole_day) {
                        return 'WHOLE DAY'
                    }

                    return time;
                }
            }, {
                data: 'html_status',
                name: 'html_status',
                className: 'dt-btn dt-body-left w-1',
            }]
        });

        Livewire.on('tableRefresh', () => {
            dt_schedules.ajax.reload(null, false);
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
