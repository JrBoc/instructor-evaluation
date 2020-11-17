<div x-data="login()">
    <form x-on:submit.prevent="login()">
        <div>
            @if (session()->has('login_successful'))
                <div class="alert alert-success bg-success text-white shadow animated fadeInUp">
                    <i class="ik ik-check"></i> Login Successful. Redirecting Shortly.
                </div>
            @endif
        </div>
        <div class="form-group">
            <input wire:model.defer="student_id" type="text" class="form-control @error('student_id') is-invalid @enderror" placeholder="Student ID" {{ $disabled ? 'disabled="disabled"' : '' }}>
            <i class="ik ik-user"></i>
            @include('inc.invalid-feedback', ['name' => 'student_id'])
        </div>
        <div class="form-group">
            <input wire:model.defer="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" {{ $disabled ? 'disabled="disabled"' : '' }}>
            <i class="ik ik-lock"></i>
            @include('inc.invalid-feedback', ['name' => 'password'])
        </div>
        <div class="sign-btn text-center">
            <button type="submit" class="btn btn-theme" wire:loading.attr="disabled" wire:target="login" {{ $disabled ? 'disabled="disabled"' : '' }}>
                <span wire:loading wire:target="login">
                    <i class="fa fa-pulse fa-spinner"></i> Signing In...
                </span>
                <span wire:loading.remove wire:target="login">
                    Sign In
                </span>
            </button>
        </div>
    </form>
</div>

@push('after_scripts')
<script>
    function login() {
        return {
            login() {
                $(document).find('.invalid-feedback').remove();
                $(document).find('.is-invalid').removeClass('is-invalid');

                @this.call('login')
            }
        }
    }

    $(function() {
        $(document).on('redirectToDashboard', function() {
             setTimeout(function() {
                 window.location.replace('{{ route("student.dashboard") }}');
            }, 2500);
        });
    });
</script>
@endpush
