<div class="row" x-data="createGroup()">
    <div class="col-12">
        <form action="#" x-on:submit.prevent="store()">
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
    function createGroup() {
        return {
            store() {
                SwalConfirm.fire({
                    text: 'Are you sure you want to create a new group?',
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
                $('#mdl_create_group').modal('hide');
            }
        }
    }

    $(function () {
        $('#mdl_create_group').on('hide.bs.modal', function () {
            @this.call('clear');
        });
    });

</script>
@endpush
