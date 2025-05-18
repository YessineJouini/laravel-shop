@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
            <div class="max-w-xl">
                <!-- Avatar Update Form -->
                <section>
                    <header>
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            Profile Avatar
                        </h2>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            Update your profile picture.
                        </p>
                    </header>
                    <form method="post" action="{{ route('profile.avatar') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
                        @csrf
                        @method('patch')
                        <div class="flex items-center gap-4">
                            <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('assets/img/default-150x150.png') }}" alt="Avatar" class="rounded-full" width="80" height="80">
                            <input type="file" name="avatar" accept="image/*" class="form-input">
                        </div>
                        @if($errors->has('avatar'))
                            <div class="text-danger mt-2">{{ $errors->first('avatar') }}</div>
                        @endif
                        <div class="flex items-center gap-4">
                            <button type="submit" class="btn btn-primary">Upload</button>
                        </div>
                    </form>
                </section>
            </div>
        </div>
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
            <div class="max-w-xl">
                <!-- Profile Info Update Form -->
                <section>
                    <header>
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            Profile Information
                        </h2>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            Update your account's profile information and email address.
                        </p>
                    </header>
                    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                        @csrf
                    </form>
                    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
                        @csrf
                        @method('patch')
                        <div>
                            <label for="name">Name</label>
                            <input id="name" name="name" type="text" class="mt-1 block w-full form-control" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
                            @if($errors->has('name'))
                                <div class="text-danger mt-2">{{ $errors->first('name') }}</div>
                            @endif
                        </div>
                        <div>
                            <label for="email">Email</label>
                            <input id="email" name="email" type="email" class="mt-1 block w-full form-control" value="{{ old('email', $user->email) }}" required autocomplete="username" />
                            @if($errors->has('email'))
                                <div class="text-danger mt-2">{{ $errors->first('email') }}</div>
                            @endif
                            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                                <div>
                                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                                        Your email address is unverified.
                                        <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                                            Click here to re-send the verification email.
                                        </button>
                                    </p>
                                    @if (session('status') === 'verification-link-sent')
                                        <p class="mt-2 font-medium text-sm text-success">
                                            A new verification link has been sent to your email address.
                                        </p>
                                    @endif
                                </div>
                            @endif
                        </div>
                        <div class="flex items-center gap-4">
                            <button type="submit" class="btn btn-primary">Save</button>
                            @if (session('status') === 'profile-updated')
                                <p class="text-sm text-success ml-3">Saved.</p>
                            @endif
                        </div>
                    </form>
                </section>
            </div>
        </div>
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
            <div class="max-w-xl">
                <!-- Password Update Form -->
                <section>
                    <header>
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            Update Password
                        </h2>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            Ensure your account is using a long, random password to stay secure.
                        </p>
                    </header>
                    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
                     
                        <div>
                            <label for="update_password_current_password">Current Password</label>
                            <input id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full form-control" autocomplete="current-password" />
                            @if($errors->updatePassword && $errors->updatePassword->has('current_password'))
                                <div class="text-danger mt-2">{{ $errors->updatePassword->first('current_password') }}</div>
                            @endif
                        </div>
                        <div>
                            <label for="update_password_password">New Password</label>
                            <input id="update_password_password" name="password" type="password" class="mt-1 block w-full form-control" autocomplete="new-password" />
                            @if($errors->updatePassword && $errors->updatePassword->has('password'))
                                <div class="text-danger mt-2">{{ $errors->updatePassword->first('password') }}</div>
                            @endif
                        </div>
                        <div>
                            <label for="update_password_password_confirmation">Confirm Password</label>
                            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full form-control" autocomplete="new-password" />
                            @if($errors->updatePassword && $errors->updatePassword->has('password_confirmation'))
                                <div class="text-danger mt-2">{{ $errors->updatePassword->first('password_confirmation') }}</div>
                            @endif
                        </div>
                        <div class="flex items-center gap-4">
                            <button type="submit" class="btn btn-primary">Save</button>
                            @if (session('status') === 'password-updated')
                                <p class="text-sm text-success ml-3">Saved.</p>
                            @endif
                        </div>
                    </form>
                </section>
            </div>
        </div>
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
            <div class="max-w-xl">
                <!-- Delete User Form -->
                <section class="space-y-6">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            Delete Account
                        </h2>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.
                        </p>
                    </header>
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#confirm-user-deletion-modal">
                        Delete Account
                    </button>
                    <!-- Modal -->
                    <div class="modal fade" id="confirm-user-deletion-modal" tabindex="-1" role="dialog" aria-labelledby="confirmUserDeletionLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
                                    @csrf
                                    @method('delete')
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="confirmUserDeletionLabel">Are you sure you want to delete your account?</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.</p>
                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <input id="password" name="password" type="password" class="form-control" placeholder="Password" />
                                            @if($errors->userDeletion && $errors->userDeletion->has('password'))
                                                <div class="text-danger mt-2">{{ $errors->userDeletion->first('password') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-danger">Delete Account</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
@endsection
