<div class="dataTables_wrapper dt-bootstrap4 no-footer">
    @php
    $item_id = 1;
    @endphp
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
                        <td colspan="2">
                            <strong>
                                {{ $group->name }}
                            </strong>
                        </td>
                        <td class="w-1 text-nowrap text-center">
                            <button data-toggle="tooltip" data-original-title="Edit" type="button" class="btn btn-outline-primary btn-icon btn-edit-group" value="{{ $group->id }}"><i class="ik ik-edit"></i></button>
                            <button data-toggle="tooltip" data-original-title="Delete" type="button" class="btn btn-outline-danger btn-icon btn-delete-group" value="{{ $group->id }}"><i class="ik ik-trash"></i></button>
                            <br>
                            @if(!$loop->first)
                            <button data-toggle="tooltip" data-original-title="Move Up" wire:click="moveGroupUp({{ $group->id }})" type="button" class="btn btn-icon btn-view mt-1 border-dark"><i class="ik ik-arrow-up"></i></button>
                            @endif
                            @if(!$loop->last)
                            <button data-toggle="tooltip" data-original-title="Move Down" wire:click="moveGroupDown({{ $group->id }})" type="button" class="btn btn-icon btn-view mt-1 border-dark"><i class="ik ik-arrow-down"></i></button>
                            @endif
                        </td>
                    </tr>
                    @forelse($group->questions as $question)
                    <tr>
                        <td style="width: 50px"></td>
                        <td>{{ $item_id . '. ' . $question->question }}</td>
                        <td class="w-1 text-nowrap text-center">
                            <button data-toggle="tooltip" data-original-title="Edit" type="button" class="btn btn-outline-primary btn-icon btn-edit-question" value="{{ $question->id }}"><i class="ik ik-edit"></i></button>
                            <button data-toggle="tooltip" data-original-title="Delete" type="button" class="btn btn-outline-danger btn-icon btn-delete-question" value="{{ $question->id }}"><i class="ik ik-trash"></i></button>
                            <br>
                            @if(!$loop->first)
                            <button data-toggle="tooltip" data-original-title="Move Up" wire:click="moveQuestionUp({{ $question->id }})" type="button" class="btn btn-icon btn-view mt-1 border-dark"><i class="ik ik-arrow-up"></i></button>
                            @endif
                            @if(!$loop->last)
                            <button data-toggle="tooltip" data-original-title="Move Down" wire:click="moveQuestionDown({{ $question->id }})" type="button" class="btn btn-icon btn-view mt-1 border-dark"><i class="ik ik-arrow-down"></i></button>
                            @endif
                        </td>
                    </tr>
                    @php
                        $item_id += 1;
                    @endphp
                    @empty
                    <tr>
                        <td class="text-center" colspan="3">
                            No Questions in this Group.
                        </td>
                    </tr>
                    @endforelse
                    @empty
                    <tr>
                        <td class="text-center" colspan="2">
                            No Registered Groups. Please Create a group.
                        </td>
                        <td class="w-1"></td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div id="dt_questions_processing" class="dataTables_processing card" wire:loading>
                <i class="fas fa-spinner fa-pulse"></i> Please wait...
            </div>
        </div>
        <div class="col-sm-12 col-md-5">
            <div class="dataTables_info" id="dt_students_info" role="status" aria-live="polite">Showing {{ $totalQuestions ? 1 : 0 }} to {{ $totalQuestions }} of {{ $totalQuestions }} entries</div>
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
