<div class="row" x-data="edit()">
    <div class="col-12">
        <form action="#" x-on:submit.prevent="update()">
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
                <button type="button" x-show="editable" x-on:click="update()" class="btn btn-outline-primary w-49">SUBMIT</button>
                <button type="button" x-on:click="clear()" :class="editable ? 'w-49' : 'btn-block'" class="btn btn-light">CLOSE</button>
            </div>
        </form>
    </div>
</div>

@push('after_scripts')
<script>
    function edit() {
        return {
            editable: @entangle('editable')
            update() {
                SwalConfirm.fire({
                    text: 'Are you sure you want to update this instructor?',
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

        $('#dt_instructors').on('click', '.btn-view', function () {
            SwalLoading.fire();

            @this.call('get', $(this).val(), false);
        });

        $('#dt_instructors').on('click', '.btn-edit', function () {
            SwalLoading.fire();

            @this.call('get', $(this).val(), true);
        });

        $('#dt_instructors').on('click', '.btn-delete', function () {
            let id = $(this).val();

            SwalConfirm.fire({
                text: 'Are you sure you want to delete this instructor?',
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
