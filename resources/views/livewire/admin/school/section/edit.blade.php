<div class="row" x-data="edit()">
    <div class="col-12">
        <form action="#" x-on:submit.prevent="update()">
            <div class="form-group">
                <label>Grade: {!! $editable ? '<span class="text-red">*</span>' : '' !!}</label>
                <select wire:model="grade" class="form-control @error('grade') @enderror" {{ !$editable ? 'disabled="disabled"' : '' }}>
                    <option value="">-- Select Grade --</option>
                    @foreach(config('evaluation.grades') as $grade)
                    <option value="{{ $grade }}">Grade {{ $grade }}</option>
                    @endforeach
                </select>
                @include('inc.invalid-feedback', ['name' => 'grade'])
            </div>
            <div class="form-group">
                <label>Name: {!! $editable ? '<span class="text-red">*</span>' : '' !!}</label>
                <input wire:model.defer="name" type="text" class="form-control @error('name') @enderror" placeholder="Name" {{ !$editable ? 'disabled="disabled"' : '' }}>
                @include('inc.invalid-feedback', ['name' => 'name'])
            </div>
            <div class="form-group">
                <label>Status: {!! $editable ? '<span class="text-red">*</span>' : '' !!}</label>
                <select wire:model.defer="status" class="form-control @error('status') is-invalid @enderror" {{ !$editable ? 'disabled="disabled"' : '' }}>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
                @include('inc.invalid-feedback', ['name' => 'status'])
            </div>
            <label>Assignments:</label>
            <div class="card shadow-none">
                <ul class="nav nav-tabs nav-fill" id="sem_tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link {{ ($semester == 1) ? 'active' : '' }}" href="#" data-toggle="tab" wire:click="$set('semester', 1)" role="tab">1st Sem</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ ($semester == 2) ? 'active' : '' }}" href="#" data-toggle="tab" wire:click="$set('semester', 2)" role="tab">2nd Sem</a>
                    </li>
                </ul>
                <div class="card-body border border-top-0 p-0">
                    <div class="tab-content mt-3">
                        <div class="tab-pane active" role="tabpanel">
                            <table class="table mb-0">
                                <thead>
                                    <tr>
                                        <th>SUBJECT</th>
                                        <th>INSTRUCTOR</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($assignments[$semester] as $key => $assignment)
                                    <tr>
                                        <td>{{ $assignment['subject']['name'] }}</td>
                                        <td>{{ $assignment['instructor']['name'] }}</td>
                                        <td class="w-1 text-nowrap text-right">
                                            @if($editable)
                                            <button wire:click="removeAssignment({{ $key }})" type="button" class="btn btn-icon btn-outline-danger" title="Remove" data-toggle="tooltip" data-original-title="Remove">
                                                <i class="ik ik-trash"></i>
                                            </button>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="text-center">No Assignments for {{ ($semester == 1) ? '1st' : '2nd' }} Semester</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                                @if($editable)
                                <tfoot>
                                    <tr>
                                        <td style="vertical-align: text-top">
                                            <select wire:model.defer="subject" class="form-control @error('subject') is-invalid @enderror">
                                                <option value="">-- Select Subject --</option>
                                                @foreach($stored_subjects as $s)
                                                <option value="{{ $s }}">{{ $s->name }}</option>
                                                @endforeach
                                            </select>
                                            @include('inc.invalid-feedback', ['name' => 'subject'])
                                        </td>
                                        <td style="vertical-align: text-top">
                                            <select wire:model.defer="instructor" class="form-control @error('instructor') is-invalid @enderror">
                                                <option value="">-- Select Instructor --</option>
                                                @foreach($stored_instructors as $i)
                                                <option value="{{ $i }}">{{ $i->formatted_full_name }}</option>
                                                @endforeach
                                            </select>
                                            @include('inc.invalid-feedback', ['name' => 'instructor'])
                                        </td>
                                        <td class="w-1 text-nowrap text-right" style="vertical-align: text-top">
                                            <button wire:click="addAssignment" type="button" class="btn btn-icon btn-outline-primary" data-toggle="tooltip" data-title="Add Assignment">
                                                <i class="ik ik-plus"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tfoot>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <button type="button" x-show="editable" x-on:click="update()" class="btn btn-outline-primary w-49">SUBMIT</button>
                <button type="button" x-on:click="clear()" :class="editable ? 'w-49' : 'btn-block'" class="btn btn-light">CLOSE</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function edit() {
        return {
            editable: @entangle('editable'),
            update() {
                SwalConfirm.fire({
                    text: 'Are you sure you want to update this class?',
                    preConfirm: function (choice) {
                        if (choice) {
                            @this.call('update');
                        }
                        return choice;
                    },
                }).then(function (choice) {
                    if (choice.value) {
                        SwalLoading.fire();
                    }
                });
            },
            clear() {
                $('#mdl_edit').modal('hide');
            }
        }
    }

    $(function () {
        $('#mdl_edit').on('hide.bs.modal', function () {
            @this.call('clear');
        });

        $('#dt_classes').on('click', '.btn-view', function () {
            SwalLoading.fire();

            @this.call('get', $(this).val(), false);
        });

        $('#dt_classes').on('click', '.btn-edit', function () {
            SwalLoading.fire();

            @this.call('get', $(this).val(), true);
        });

        $('#dt_classes').on('click', '.btn-delete', function () {
            let id = $(this).val();

            SwalConfirm.fire({
                text: 'Are you sure you want to delete this class?',
                preConfirm: function (choice) {
                    if (choice) {
                        @this.call('destroy', id);
                    }
                    return choice;
                }
            }).then(function (choice) {
                if (choice.value) {
                    SwalLoading.fire();
                }
            });
        });
    });

</script>
@endpush
