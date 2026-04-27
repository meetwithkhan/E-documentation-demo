@extends('layouts.app')
@section('title', 'Profile Settings')
@section('page-title', 'Profile Settings')

@section('content')
@include('layouts.partials.alert')

<div class="max-w-xl space-y-4">

  <!-- Profile Info -->
  <div class="bg-gray-900 border border-gray-800 rounded-xl p-6">
    <h3 class="text-sm font-medium text-gray-300 mb-5">Profile Information</h3>
    <form method="POST" action="{{ route('profile.update') }}" class="space-y-4">
      @csrf @method('PATCH')
      <div>
        <label class="block text-xs text-gray-500 mb-1.5">Full Name</label>
        <input type="text" name="name" value="{{ old('name', $user->name) }}" required
               class="w-full bg-gray-950 border border-gray-800 rounded-lg px-3 py-2.5
                      text-sm text-gray-200 focus:outline-none focus:ring-1
                      focus:ring-indigo-500 focus:border-indigo-500"/>
        @error('name')<p class="text-xs text-rose-400 mt-1">{{ $message }}</p>@enderror
      </div>
      <div>
        <label class="block text-xs text-gray-500 mb-1.5">Email Address</label>
        <input type="email" name="email" value="{{ old('email', $user->email) }}" required
               class="w-full bg-gray-950 border border-gray-800 rounded-lg px-3 py-2.5
                      text-sm text-gray-200 focus:outline-none focus:ring-1
                      focus:ring-indigo-500 focus:border-indigo-500"/>
        @error('email')<p class="text-xs text-rose-400 mt-1">{{ $message }}</p>@enderror
      </div>
      <button type="submit"
              class="bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-medium
                     px-5 py-2.5 rounded-lg transition-colors">
        Save Changes
      </button>
    </form>
  </div>

  <!-- Change Password -->
  <div class="bg-gray-900 border border-gray-800 rounded-xl p-6">
    <h3 class="text-sm font-medium text-gray-300 mb-5">Change Password</h3>
    <form method="POST" action="{{ route('profile.password') }}" class="space-y-4">
      @csrf @method('PATCH')
      <div>
        <label class="block text-xs text-gray-500 mb-1.5">Current Password</label>
        <input type="password" name="current_password" required
               class="w-full bg-gray-950 border border-gray-800 rounded-lg px-3 py-2.5
                      text-sm text-gray-200 focus:outline-none focus:ring-1
                      focus:ring-indigo-500 focus:border-indigo-500"/>
        @error('current_password')<p class="text-xs text-rose-400 mt-1">{{ $message }}</p>@enderror
      </div>
      <div>
        <label class="block text-xs text-gray-500 mb-1.5">New Password</label>
        <input type="password" name="password" required
               class="w-full bg-gray-950 border border-gray-800 rounded-lg px-3 py-2.5
                      text-sm text-gray-200 focus:outline-none focus:ring-1
                      focus:ring-indigo-500 focus:border-indigo-500"/>
        @error('password')<p class="text-xs text-rose-400 mt-1">{{ $message }}</p>@enderror
      </div>
      <div>
        <label class="block text-xs text-gray-500 mb-1.5">Confirm New Password</label>
        <input type="password" name="password_confirmation" required
               class="w-full bg-gray-950 border border-gray-800 rounded-lg px-3 py-2.5
                      text-sm text-gray-200 focus:outline-none focus:ring-1
                      focus:ring-indigo-500 focus:border-indigo-500"/>
      </div>
      <button type="submit"
              class="bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-medium
                     px-5 py-2.5 rounded-lg transition-colors">
        Update Password
      </button>
    </form>
  </div>

  <!-- Delete Account -->
  <div class="bg-gray-900 border border-rose-900/50 rounded-xl p-6">
    <h3 class="text-sm font-medium text-rose-400 mb-2">Danger Zone</h3>
    <p class="text-xs text-gray-600 mb-4">Once deleted, your account cannot be recovered.</p>
    <form method="POST" action="{{ route('profile.destroy') }}"
          onsubmit="return confirm('Are you sure? This cannot be undone.')">
      @csrf @method('DELETE')
      <div class="mb-3">
        <label class="block text-xs text-gray-500 mb-1.5">Enter Password to Confirm</label>
        <input type="password" name="password" required
               class="w-full bg-gray-950 border border-gray-800 rounded-lg px-3 py-2.5
                      text-sm text-gray-200 focus:outline-none focus:ring-1
                      focus:ring-rose-500 focus:border-rose-500"/>
        @error('password')<p class="text-xs text-rose-400 mt-1">{{ $message }}</p>@enderror
      </div>
      <button type="submit"
              class="bg-rose-700 hover:bg-rose-600 text-white text-sm font-medium
                     px-5 py-2.5 rounded-lg transition-colors">
        Delete My Account
      </button>
    </form>
  </div>

</div>
@endsection