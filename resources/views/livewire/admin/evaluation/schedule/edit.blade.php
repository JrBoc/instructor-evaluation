<div x-data="edit()">
    <form action="#" x-on:submit.prevent="update()" class="row">
        <div class="col-12 col-md-6">
            <div class="form-group">
                <label>School Year: {!! $editable ? '<span class="text-red">*</span>' : '' !!}</label>
                <select wire:model.defer="school_year" class="form-control @error('school_year') is-invalid @enderror" {{ !$editable ? 'disabled="disabled"' : '' }}>
                    <option value="">-- Select School Year --</option>
                    <option value="{{ now()->format('Y') }}">{{ now()->format('Y') }} - {{ now()->addYear()->format('Y') }}</option>
                </select>
                @include('inc.invalid-feedback', ['name' => 'school_year'])
            </div>
            <div class="form-group">
                <label>Semester: {!! $editable ? '<span class="text-red">*</span>' : '' !!}</label>
                <select wire:model.defer="semester" class="form-control @error('semester') is-invalid @enderror" {{ !$editable ? 'disabled="disabled"' : '' }}>
                    <option value="">-- Select Semester --</option>
                    <option value="1">1st Semester</option>
                    <option value="2">2nd Semester</option>
                </select>
                @include('inc.invalid-feedback', ['name' => 'semester'])
            </div>
            <div class="form-group">
                <label>Grade: {!! $editable ? '<span class="text-red">*</span>' : '' !!}</label>
                <select wire:model="grade" class="form-control @error('grade') is-invalid @enderror" {{ !$editable ? 'disabled="disabled"' : '' }}>
                    <option value="">-- Select Grade --</option>
                    @foreach(config('evaluation.grades') as $g)
                    <option value="{{ $g }}">Grade {{ $g }}</option>
                    @endforeach
                </select>
                @include('inc.invalid-feedback', ['name' => 'grade'])
            </div>
            <div class="form-group">
                <label>Class: {!! $editable ? '<span class="text-red">*</span>' : '' !!}</label>
                <select wire:model="section" class="form-control @error('section') is-invalid @enderror" {{ !$editable ? 'disabled="disabled"' : '' }}>
                    <option value="">-- Select Class --</option>
                    @foreach($stored_sections as $s)
                    <option value="{{ $s->id }}">{{ $s->name }}</option>
                    @endforeach
                </select>
                @include('inc.invalid-feedback', ['name' => 'grade'])
            </div>
            <div class="form-group">
                <label>Status: {!! $editable ? '<span class="text-red">*</span>' : '' !!}</label>
                <select wire:model.defer="status" class="form-control @error('status') is-invalid @enderror" {{ !$editable ? 'disabled="disabled"' : '' }}>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
                @include('inc.invalid-feedback', ['name' => 'status'])
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="form-group">
                <label>Evaluation Type:{!! $editable ? '<span class="text-red">*</span>' : '' !!}</label>
                <select x-model="evaluation_type" wire:model.defer="evaluation_type" class="form-control @error('evaluation_type') is-invalid @enderror" {{ !$editable ? 'disabled="disabled"' : '' }}>
                    <option value="">-- Select Evaluation Type --</option>
                    <option value="OPEN">OPEN (WHOLE DAY)</option>
                    <option value="TIMED">TIMED</option>
                </select>
                @include('inc.invalid-feedback', ['name' => 'evaluation_type'])
            </div>
            <div x-show="evaluation_type">
                <label>Schedule: {!! $editable ? '<span class="text-red">*</span>' : '' !!}</label>
                <div class="card card-body shadow-none border">
                    <div class="form-group">
                        <label>Date: {!! $editable ? '<span class="text-red">*</span>' : '' !!}</label>
                        <input wire:model.defer="date" type="date" class="form-control @error('date') is-invalid @enderror" placeholder="Date" {{ !$editable ? 'disabled="disabled"' : '' }}>
                        @include('inc.invalid-feedback', ['name' => 'date'])
                    </div>
                    <div x-show="evaluation_type == 'TIMED'" class="form-group">
                        <label>Start: {!! $editable ? '<span class="text-red">*</span>' : '' !!}</label>
                        <input wire:model.defer="start" type="time" class="form-control @error('start') is-invalid @enderror" placeholder="Start Time" {{ !$editable ? 'disabled="disabled"' : '' }}>
                        @include('inc.invalid-feedback', ['name' => 'start'])
                    </div>
                    <div x-show="evaluation_type == 'TIMED'" class="form-group">
                        <label>End: {!! $editable ? '<span class="text-red">*</span>' : '' !!}</label>
                        <input wire:model.defer="end" type="time" class="form-control @error('end') is-invalid @enderror" placeholder="End Time" {{ !$editable ? 'disabled="disabled"' : '' }}>
                        @include('inc.invalid-feedback', ['name' => 'end'])
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="d-flex justify-content-between">
                <button type="button" x-show="editable" x-on:click="update()" class="btn btn-outline-primary w-49">SUBMIT</button>
                <button type="button" x-on:click="clear()" :class="editable ? 'w-49' : 'btn-block'" class="btn btn-light">CLOSE</button>
            </div>
        </div>
    </form>
</div>

@push('after_scripts')
<script>
    function edit() {
        return {
            evaluation_type: @entangle('evaluation_type'),
            editable: @entangle('editable'),
            update() {
                SwalConfirm.fire({
                    text: 'Are you sure you want to update this schedule?',
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

        $('#dt_schedules').on('click', '.btn-view', function () {
            SwalLoading.fire();

            @this.call('get', $(this).val(), false);
        });

        $('#dt_schedules').on('click', '.btn-edit', function () {
            SwalLoading.fire();

            @this.call('get', $(this).val(), true);
        });

        $('#dt_schedules').on('click', '.btn-delete', function () {
            let id = $(this).val();

            SwalConfirm.fire({
                text: 'Are you sure you want to delete this schedule?',
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
