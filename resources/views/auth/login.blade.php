@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="text-center mt-3 mb-4">
                        <a href="{{ url('/') }}">
                            <img src="{{ asset('images/logo.png') }}" alt="monster-logo" width="100px">
                        </a>
                    </div>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row justify-content-center">
                            <div class="col-md-8">
                                <input id="username" type="email" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="email" autofocus placeholder="Username">

                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row justify-content-center">
                            <div class="col-md-8">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-5">
                                <button type="submit" class="btn btn-outline-info">
                                    {{ __('Login') }}
                                </button>

                                {{--@if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif--}}
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <div class="text-center">
                        <a href="#request_account_modal" data-toggle="modal">Request an Account</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="request_account_modal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Request Access</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="request_account_form" action="{{ route('account.request') }}">
                    @csrf
                    <input type="hidden" name="account_request" value="1">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col">
                                <label for="update_first_name">First Name</label>
                                <input type="text" id="update_first_name" name="first_name" class="form-control" placeholder="First Name">
                            </div>
                        </div>
                        <div class="my-3"></div>
                        <div class="row">
                            <div class="col">
                                <label for="update_middle_name">Middle Name</label>
                                <input type="text" id="update_middle_name" name="middle_name" class="form-control" placeholder="Middle Name">
                            </div>
                        </div>
                        <div class="my-3"></div>
                        <div class="row">
                            <div class="col">
                                <label for="update_last_name">Last Name</label>
                                <input type="text" id="update_last_name" name="last_name" class="form-control" placeholder="Last Name">
                            </div>
                        </div>
                        <div class="my-3"></div>
                        <div class="row">
                            <div class="col">
                                <label for="update_username">Username</label>
                                <input type="email" id="update_username" name="username" class="form-control" placeholder="Username" tooltip data-placement="right" title="It should be an email to which emails can be sent">
                            </div>
                        </div>
                        <div class="my-3"></div>
                        <div class="row">
                            <div class="col">
                                <label for="update_nickname">Nickname</label>
                                <input type="text" id="update_nickname" name="nickname" class="form-control" placeholder="Nickname">
                            </div>
                            <div class="col">
                                <label for="update_birthdate">Date of Birth</label>
                                <input type="date" id="update_birthdate" name="date_of_birth" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="btn-group">
                            <button type="submit" class="btn btn-outline-dark">Save</button>
                            <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).on('submit', '#request_account_form', function(event) {
        event.preventDefault();
        let url = $(this).attr('action');
        let formData = new FormData(this);

        postAsync(url, formData, 'JSON', beforeSend, onSuccess);

        function beforeSend() {
            manualToast.fire({
                icon: 'info',
                title: 'Sending request ...'
            });
        }

        function onSuccess(result) {
            $('.modal').modal('hide');
            $('#request_account_form').trigger('reset');

            Toast.fire({
                icon: result.status,
                title: result.message,
            });
        }
    });
</script>
@endsection
