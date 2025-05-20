@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">
                    <i class="fas fa-image mr-2"></i> Profile Avatar
                </h2>
            </div>
            <div class="card-body">
                <p class="text-muted">
                    Update your profile picture.
                </p>
                <form method="post" action="{{ route('profile.avatar') }}" enctype="multipart/form-data" class="mt-3">
                    @csrf
                    @method('patch')
                    <div class="form-group row">
                        <div class="col-md-3 text-center">
                            <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('assets/img/default-150x150.png') }}" 
                                alt="Avatar" class="img-circle elevation-2" width="80" height="80">
                        </div>
                        <div class="col-md-9">
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" name="avatar" class="custom-file-input" id="avatarInput" accept="image/*">
                                    <label class="custom-file-label" for="avatarInput">Choose file</label>
                                </div>
                            </div>
                            @if($errors->has('avatar'))
                                <div class="text-danger mt-2">{{ $errors->first('avatar') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-9 offset-md-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-upload mr-1"></i> Upload
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h2 class="card-title">
                    <i class="fas fa-user mr-2"></i> Profile Information
                </h2>
            </div>
            <div class="card-body">
                <p class="text-muted">
                    Update your account's profile information and email address.
                </p>
                <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                    @csrf
                </form>
                <form method="post" action="{{ route('profile.update') }}" class="mt-3">
                    @csrf
                    @method('patch')
                    <div class="form-group">
                        <label for="name">
                            <i class="fas fa-user mr-1"></i> Name
                        </label>
                        <input id="name" name="name" type="text" class="form-control" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
                        @if($errors->has('name'))
                            <div class="text-danger mt-2">{{ $errors->first('name') }}</div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="email">
                            <i class="fas fa-envelope mr-1"></i> Email
                        </label>
                        <input id="email" name="email" type="email" class="form-control" value="{{ old('email', $user->email) }}" required autocomplete="username" />
                        @if($errors->has('email'))
                            <div class="text-danger mt-2">{{ $errors->first('email') }}</div>
                        @endif
                        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                            <div class="alert alert-warning mt-3">
                                <i class="fas fa-exclamation-triangle mr-1"></i>
                                Your email address is unverified.
                                <button form="send-verification" class="btn btn-link p-0 m-0">
                                    Click here to re-send the verification email.
                                </button>
                            </div>
                            @if (session('status') === 'verification-link-sent')
                                <div class="alert alert-success mt-2">
                                    <i class="fas fa-check mr-1"></i>
                                    A new verification link has been sent to your email address.
                                </div>
                            @endif
                        @endif
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-1"></i> Save
                        </button>
                        @if (session('status') === 'profile-updated')
                            <span class="text-success ml-3">
                                <i class="fas fa-check mr-1"></i> Saved.
                            </span>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h2 class="card-title">
                    <i class="fas fa-lock mr-2"></i> Update Password
                </h2>
            </div>
            <div class="card-body">
                <p class="text-muted">
                    Ensure your account is using a long, random password to stay secure.
                </p>
                <form method="post" action="{{ route('password.update') }}" class="mt-3">
                    @csrf
                    @method('put')
                    <div class="form-group">
                        <label for="update_password_current_password">
                            <i class="fas fa-key mr-1"></i> Current Password
                        </label>
                        <input id="update_password_current_password" name="current_password" type="password" class="form-control" autocomplete="current-password" />
                        @if($errors->updatePassword && $errors->updatePassword->has('current_password'))
                            <div class="text-danger mt-2">{{ $errors->updatePassword->first('current_password') }}</div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="update_password_password">
                            <i class="fas fa-lock mr-1"></i> New Password
                        </label>
                        <input id="update_password_password" name="password" type="password" class="form-control" autocomplete="new-password" />
                        @if($errors->updatePassword && $errors->updatePassword->has('password'))
                            <div class="text-danger mt-2">{{ $errors->updatePassword->first('password') }}</div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="update_password_password_confirmation">
                            <i class="fas fa-check mr-1"></i> Confirm Password
                        </label>
                        <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-control" autocomplete="new-password" />
                        @if($errors->updatePassword && $errors->updatePassword->has('password_confirmation'))
                            <div class="text-danger mt-2">{{ $errors->updatePassword->first('password_confirmation') }}</div>
                        @endif
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-1"></i> Save
                        </button>
                        @if (session('status') === 'password-updated')
                            <span class="text-success ml-3">
                                <i class="fas fa-check mr-1"></i> Saved.
                            </span>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <div class="card card-danger">
            <div class="card-header">
                <h2 class="card-title">
                    <i class="fas fa-trash mr-2"></i> Delete Account
                </h2>
            </div>
            <div class="card-body">
                <p class="text-muted">
                    Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.
                </p>
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#confirm-user-deletion-modal">
                    <i class="fas fa-trash mr-1"></i> Delete Account
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="confirm-user-deletion-modal" tabindex="-1" role="dialog" aria-labelledby="confirmUserDeletionLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="confirmUserDeletionLabel">
                    <i class="fas fa-exclamation-triangle mr-1"></i> Delete Account
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="{{ route('profile.destroy') }}">
                @csrf
                @method('delete')
                <div class="modal-body">
                    <p>Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.</p>
                    <div class="form-group">
                        <label for="password">
                            <i class="fas fa-lock mr-1"></i> Password
                        </label>
                        <input id="password" name="password" type="password" class="form-control" placeholder="Enter your password" />
                        @if($errors->userDeletion && $errors->userDeletion->has('password'))
                            <div class="text-danger mt-2">{{ $errors->userDeletion->first('password') }}</div>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fas fa-times mr-1"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash mr-1"></i> Delete Account
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Handle custom file input label
    $(document).ready(function () {
        $('.custom-file-input').on('change', function() {
            var fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').html(fileName || 'Choose file');
        });
    });
</script>
@endsection