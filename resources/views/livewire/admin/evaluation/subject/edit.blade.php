<div class="row" x-data="edit()">
    <div class="col-12">
        <form action="#" x-on:submit.prevent="update()">
            <div class="form-group">
                <label>Grade: <span class="text-red">*</span></label>
                <select wire:model.defer="grade" class="form-control @error('grade') is-invalid @enderror">
                    <option value="">-- Select Grade --</option>
                    @foreach(config('evaluation.grades') as $grade)
                    <option value="{{ $grade }}">Grade {{ $grade}}</option>
                    @endforeach
                </select>
                @include('inc.invalid-feedback', ['name' => 'grade'])
            </div>
            <div class="form-group">
                <label>Subject: <span class="text-red">*</span></label>
                <input wire:model.defer="name" type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Subject">
                @include('inc.invalid-feedback', ['name' => 'name'])
            </div>
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-outline-primary" style="width: 49%">SUBMIT</button>
                <button type="button" x-on:click="clear()" class="btn btn-light" style="width: 49%">CLOSE</button>
            </div>
        </form>
    </div>
</div>

@push('after_scripts')
<script>
    function edit() {
        return {
            update() {
                SwalConfirm.fire({
                    text: 'Are you sure you want to update this subject?',
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
            },
        }
    }

    $(function () {
        $('#mdl_edit').on('hide.bs.modal', function () {
            @this.call('clear');
        });

        $('#dt_subjects').on('click', '.btn-edit', function () {
            SwalLoading.fire();

            @this.call('get', $(this).val());
        });

        $('#dt_subjects').on('click', '.btn-delete', function () {
            let id = $(this).val();

            SwalConfirm.fire({
                text: 'Are you sure you want to delete this subject?',
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
