<div class="row" x-data="create()">
    <div class="col-12">
        <form action="#" x-on:submit.prevent="store()">
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
    function create() {
        return {
            store() {
                SwalConfirm.fire({
                    text: 'Are you sure you want to create a new question?',
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
                $('#mdl_create_question').modal('hide');
            }
        }
    }

    $(function () {
        $('#mdl_create_question').on('hide.bs.modal', function () {
            @this.call('clear');
        });
    });
</script>
@endpush
