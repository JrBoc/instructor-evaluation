<div class="row" x-data="create()">
    <div class="col-12">
        <form action="#" x-on:submit.prevent="store()">
            <div class="form-group">
                <label>Title: <span class="text-red">*</span></label>
                <select wire:model.defer="title" class="form-control @error('title') is-invalid @enderror">
                    <option value="">-- Select Title --</option>
                    <option value="Mr.">Mr.</option>
                    <option value="Ms.">Ms.</option>
                    <option value="Mrs.">Mrs.</option>
                </select>
                @include('inc.invalid-feedback', ['name' => 'title'])
            </div>
            <div class="form-group">
                <label>Last Name: <span class="text-red">*</span></label>
                <input wire:model.defer="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" placeholder="Last Name">
                @include('inc.invalid-feedback', ['name' => 'last_name'])
            </div>
            <div class="form-group">
                <label>First Name: <span class="text-red">*</span></label>
                <input wire:model.defer="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" placeholder="First Name">
                @include('inc.invalid-feedback', ['name' => 'first_name'])
            </div>
            <div class="form-group">
                <label>Middle Name:</label>
                <input wire:model.defer="middle_name" type="text" class="form-control @error('middle_name') is-invalid @enderror" placeholder="Middle Name">
                @include('inc.invalid-feedback', ['name' => 'middle_name'])
            </div>
            <div class="form-group">
                <label>Status: <span class="text-red">*</span></label>
                <select wire:model.defer="status" class="form-control @error('status') is-invalid @enderror">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
                @include('inc.invalid-feedback', ['name' => 'status'])
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
    function create() {
        return {
            store() {
                SwalConfirm.fire({
                    text: 'Are you sure you want to create a new instructor?',
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
        $('#mdl_create').on('hide.bs.modal', function () {
            @this.call('clear');
        });
    });
</script>
@endpush
