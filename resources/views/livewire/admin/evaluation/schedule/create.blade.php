<div x-data="create()">
    <form action="#" x-on:submit.prevent="store()" class="row">
        <div class="col-12 col-md-6">
            <div class="form-group">
                <label>School Year: <span class="text-red">*</span></label>
                <select wire:model.defer="school_year" class="form-control @error('school_year') is-invalid @enderror">
                    <option value="">-- Select School Year --</option>
                    <option value="{{ \Carbon\Carbon::now()->format('Y') }}">{{ \Carbon\Carbon::now()->format('Y') }} - {{ \Carbon\Carbon::now()->addYear()->format('Y') }}</option>
                </select>
                @include('inc.invalid-feedback', ['name' => 'school_year'])
            </div>
            <div class="form-group">
                <label>Semester: <span class="text-red">*</span></label>
                <select wire:model.defer="semester" class="form-control @error('semester') is-invalid @enderror">
                    <option value="">-- Select Semester --</option>
                    <option value="1">1st Semester</option>
                    <option value="2">2nd Semester</option>
                </select>
                @include('inc.invalid-feedback', ['name' => 'semester'])
            </div>
            <div class="form-group">
                <label>Grade: <span class="text-red">*</span></label>
                <select wire:model="grade" class="form-control @error('grade') is-invalid @enderror">
                    <option value="">-- Select Grade --</option>
                    @foreach(config('evaluation.grades') as $g)
                    <option value="{{ $g }}">Grade {{ $g }}</option>
                    @endforeach
                </select>
                @include('inc.invalid-feedback', ['name' => 'grade'])
            </div>
            <div class="form-group">
                <label>Class: <span class="text-red">*</span></label>
                <select wire:model="section" class="form-control @error('section') is-invalid @enderror">
                    <option value="">-- Select Class --</option>
                    @foreach($stored_sections as $s)
                    <option value="{{ $s->id }}">{{ $s->name }}</option>
                    @endforeach
                </select>
                @include('inc.invalid-feedback', ['name' => 'grade'])
            </div>
            <div class="form-group">
                <label>Status: <span class="text-red">*</span></label>
                <select wire:model.defer="status" class="form-control @error('status') is-invalid @enderror">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
                @include('inc.invalid-feedback', ['name' => 'status'])
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="form-group">
                <label>Evaluation Type: <span class="text-red">*</span></label>
                <select x-model="evaluation_type" wire:model.defer="evaluation_type" class="form-control @error('evaluation_type') is-invalid @enderror">
                    <option value="">-- Select Evaluation Type --</option>
                    <option value="OPEN">OPEN (WHOLE DAY)</option>
                    <option value="TIMED">TIMED</option>
                </select>
                @include('inc.invalid-feedback', ['name' => 'evaluation_type'])
            </div>
            <div x-show="evaluation_type">
                <label>Schedule: <span class="text-red">*</span></label>
                <div class="card card-body shadow-none border">
                    <div class="form-group">
                        <label>Date: <span class="text-red">*</span></label>
                        <input wire:model.defer="date" type="date" class="form-control @error('date') is-invalid @enderror" placeholder="Date">
                        @include('inc.invalid-feedback', ['name' => 'date'])
                    </div>
                    <div x-show="evaluation_type == 'TIMED'" class="form-group">
                        <label>Start: <span class="text-red">*</span></label>
                        <input wire:model.defer="start" type="time" class="form-control @error('start') is-invalid @enderror" placeholder="Start Time">
                        @include('inc.invalid-feedback', ['name' => 'start'])
                    </div>
                    <div x-show="evaluation_type == 'TIMED'" class="form-group">
                        <label>End: <span class="text-red">*</span></label>
                        <input wire:model.defer="end" type="time" class="form-control @error('end') is-invalid @enderror" placeholder="End Time">
                        @include('inc.invalid-feedback', ['name' => 'end'])
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-outline-primary" style="width: 49%">SUBMIT</button>
                <button type="button" x-on:click="clear()" class="btn btn-light" style="width: 49%">CLOSE</button>
            </div>
        </div>
    </form>
</div>

@push('after_scripts')
<script>
    function create() {
        return {
            store() {
                SwalConfirm.fire({
                    text: 'Are you sure you want to create a new schedule?',
                    preConfirm: function (choice) {
                        if (choice) {
                            @this.call('store');
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
                $('#mdl_create').modal('hide');
            },
            evaluation_type: @entangle('evaluation_type')
        }
    }

    $(function () {
        $('#mdl_create').on('hide.bs.modal', function () {
            @this.call('clear');
        });
    });

</script>
@endpush
