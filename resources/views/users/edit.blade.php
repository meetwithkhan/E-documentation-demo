@extends('layouts.app')
@section('title', 'Edit User')
@section('page-title', 'Edit User')

@section('content')
@include('layouts.partials.alert')

<div class="max-w-xl">
  <div class="bg-gray-900 border border-gray-800 rounded-xl p-6">
    <h3 class="text-sm font-medium text-gray-300 mb-5">Edit — {{ $user->name }}</h3>

    <form method="POST" action="{{ route('users.update', $user) }}" class="space-y-4">
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

      <div>
        <label class="block text-xs text-gray-500 mb-1.5">New Password <span class="text-gray-700">(leave blank to keep current)</span></label>
        <input type="password" name="password"
               class="w-full bg-gray-950 border border-gray-800 rounded-lg px-3 py-2.5
                      text-sm text-gray-200 focus:outline-none focus:ring-1
                      focus:ring-indigo-500 focus:border-indigo-500"
               placeholder="Min. 8 characters"/>
        @error('password')<p class="text-xs text-rose-400 mt-1">{{ $message }}</p>@enderror
      </div>

      <div>
        <label class="block text-xs text-gray-500 mb-1.5">Confirm New Password</label>
        <input type="password" name="password_confirmation"
               class="w-full bg-gray-950 border border-gray-800 rounded-lg px-3 py-2.5
                      text-sm text-gray-200 focus:outline-none focus:ring-1
                      focus:ring-indigo-500 focus:border-indigo-500"/>
      </div>

      <div>
        <label class="block text-xs text-gray-500 mb-1.5">Role</label>
        <select name="role" required
                class="w-full bg-gray-950 border border-gray-800 rounded-lg px-3 py-2.5
                       text-sm text-gray-200 focus:outline-none focus:ring-1
                       focus:ring-indigo-500 focus:border-indigo-500">
          @foreach($roles as $role)
            <option value="{{ $role->name }}" {{ $userRole === $role->name ? 'selected' : '' }}>
              {{ ucfirst($role->name) }}
            </option>
          @endforeach
        </select>
        @error('role')<p class="text-xs text-rose-400 mt-1">{{ $message }}</p>@enderror
      </div>

      <div class="flex items-center gap-3 pt-2">
        <button type="submit"
                class="bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-medium
                       px-5 py-2.5 rounded-lg transition-colors">
          Save Changes
        </button>
        <a href="{{ route('users.index') }}"
           class="text-sm text-gray-500 hover:text-gray-300 transition-colors">Cancel</a>
      </div>
    </form>
  </div>
</div>
@endsection