<div class="dataTables_wrapper dt-bootstrap4 no-footer">
    <div class="row">
        <div class="col-sm-12">
            <table id="dt_questions" class="table table-hover dataTable border-bottom table-responsive">
                <thead>
                    <tr>
                        <th colspan="2">Questionnaire</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($groups as $group)
                    <tr>
                        <td colspan="2">{{ $group->name }}</td>
                        <td class="w-1 text-nowrap text-center">
                            <button data-toggle="tooltip" data-original-title="Edit" type="button" class="btn btn-outline-primary btn-icon btn-edit mr-1" value="{{ $group->id }}"><i class="ik ik-edit"></i></button>
                            <button data-toggle="tooltip" data-original-title="Delete" type="button" class="btn btn-outline-danger btn-icon btn-delete" value="{{ $group->id }}"><i class="ik ik-trash"></i></button>
                        </td>
                    </tr>
                    @forelse($group->questions as $question)
                    <tr>
                        <td style="width: 50px"></td>
                        <td>{{ $question->question }}</td>
                        <td class="w-1 text-nowrap text-center">
                            <button data-toggle="tooltip" data-original-title="Edit" type="button" class="btn btn-outline-primary btn-icon btn-edit-question mr-1" value="{{ $question->id }}"><i class="ik ik-edit"></i></button>
                            <button data-toggle="tooltip" data-original-title="Delete" type="button" class="btn btn-outline-danger btn-icon btn-delete-question" value="{{ $question->id }}"><i class="ik ik-trash"></i></button>
                            <br>
                            @if(!$loop->first)
                            <button data-toggle="tooltip" data-original-title="Move Up" wire:click="decrement({{$question->id}})" type="button" class="btn btn-icon btn-view mr-1 mt-2 border-dark" value="{{ $question->id }}"><i class="ik ik-arrow-up"></i></button>
                            @endif
                            @if(!$loop->last)
                            <button data-toggle="tooltip" data-original-title="Move Down" wire:click="increment({{$question->id}})" type="button" class="btn btn-icon btn-view mr-1 mt-2 border-dark" value="{{ $question->id }}"><i class="ik ik-arrow-down"></i></button>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td class="text-center" colspan="3">
                            No Questions in this Group.
                        </td>
                    </tr>
                    @endforelse
                    @empty
                    <tr>
                        <td class="text-center" colspan="3">
                            No Registered Groups. Please Create a group.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('after_scripts')
<script>
    $(function () {


        $(document).on('reRenderQuestionnaire', function () {
            @this.call('reRender');
        });
    });
</script>
@endpush
