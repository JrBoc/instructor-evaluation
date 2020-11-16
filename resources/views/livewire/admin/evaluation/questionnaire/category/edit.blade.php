<div class="row" x-data="createCategory()">
    <div class="col-12">
        <form action="#" x-on:submit.prevent="store()">
            <div class="form-group">
                <label>Category: <span class="text-red">*</span></label>
                <input wire:model.defer="category" type="text" class="form-control @error('category') is-invalid @enderror" placeholder="Category">
                @include('inc.invalid-feedback', ['name' => 'category'])
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
            editable: @entangle('editable'),
            update() {
                SwalConfirm.fire({
                    text: 'Are you sure you want to update this category?',
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
        $('#mdl_edit_category').on('hide.bs.modal', function () {
            @this.call('clear');
        });

        $('#dt_categories').on('click', '.btn-edit', function () {
            SwalLoading.fire();

            @this.call('get', $(this).val(), true);
        });

        $('#dt_categories').on('click', '.btn-delete', function () {
            let id = $(this).val();

            SwalConfirm.fire({
                text: 'Are you sure you want to delete this Category and the questions within?',
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
