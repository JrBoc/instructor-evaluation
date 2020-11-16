<div class="row" x-data="edit()">
    <div class="col-12">
        <form action="#" x-on:submit.prevent="update()">
            <div class="form-group">
                <label>Group: <span class="text-red">*</span></label>
                <select wire:model.defer="group" class="form-control @error('group') is-invalid @enderror">
                    <option value="">-- Select Group --</option>
                    @foreach ($groups as $g)
                        <option value="{{ $g->id }}">{{ $g->name }}</option>
                    @endforeach
                </select>
                @include('inc.invalid-feedback', ['name' => 'group'])
            </div>
            <div class="form-group">
                <label>Question: <span class="text-red">*</span></label>
                <input wire:model.defer="question" type="text" class="form-control @error('question') is-invalid @enderror" placeholder="Question">
                @include('inc.invalid-feedback', ['name' => 'question'])
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
                    text: 'Are you sure you want to update this question?',
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
                $('#mdl_edit_question').modal('hide');
            }
        }
    }

    $(function () {
        $('#mdl_edit_question').on('hide.bs.modal', function () {
            @this.call('clear');
        });

        $('#dt_questions').on('click', '.btn-edit-question', function () {
            SwalLoading.fire();

            @this.call('get', $(this).val());
        });

        $('#dt_questions').on('click', '.btn-delete-question', function () {
            let id = $(this).val();

            SwalConfirm.fire({
                text: 'Are you sure you want to delete this question?',
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
