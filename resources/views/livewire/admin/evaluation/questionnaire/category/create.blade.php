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
    function createCategory() {
        return {
            store() {
                SwalConfirm.fire({
                    text: 'Are you sure you want to create a new category?',
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
            }
        }
    }

    $(function () {
        $('#mdl_create_category').on('hide.bs.modal', function () {
            @this.call('clear');
        });
    });

</script>
@endpush
