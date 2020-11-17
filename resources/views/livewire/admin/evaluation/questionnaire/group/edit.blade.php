<div class="row" x-data="editGroup()">
    <div class="col-12">
        <form action="#" x-on:submit.prevent="update()">
            <div class="form-group">
                <label>Name: <span class="text-red">*</span></label>
                <input wire:model.defer="name" type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Name">
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
    function editGroup() {
        return {
            update() {
                SwalConfirm.fire({
                    text: 'Are you sure you want to update this group?',
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
                $('#mdl_edit_group').modal('hide');
            }
        }
    }

    $(function () {
        $('#mdl_edit_group').on('hide.bs.modal', function () {
            @this.call('clear');
        });

        $('#dt_questions').on('click', '.btn-edit-group', function () {
            SwalLoading.fire();

            @this.call('get', $(this).val(), true);
        });

        $('#dt_questions').on('click', '.btn-delete-group', function () {
            let id = $(this).val();

            SwalConfirm.fire({
                text: 'Are you sure you want to delete this Group and the Questions within?',
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
