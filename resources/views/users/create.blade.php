@extends('layouts.app')
@section('title', 'Add User')
@section('page-title', 'Add User')

@section('content')
<div class="max-w-xl">
  <div class="bg-gray-900 border border-gray-800 rounded-xl p-6">
    <h3 class="text-sm font-medium text-gray-300 mb-5">User Details</h3>

    <form method="POST" action="{{ route('users.store') }}" class="space-y-4">
      @csrf

      <div>
        <label class="block text-xs text-gray-500 mb-1.5">Full Name</label>
        <input type="text" name="name" value="{{ old('name') }}" required
               class="w-full bg-gray-950 border border-gray-800 rounded-lg px-3 py-2.5
                      text-sm text-gray-200 focus:outline-none focus:ring-1
                      focus:ring-indigo-500 focus:border-indigo-500"
               placeholder="John Doe"/>
        @error('name')<p class="text-xs text-rose-400 mt-1">{{ $message }}</p>@enderror
      </div>

      <div>
        <label class="block text-xs text-gray-500 mb-1.5">Email Address</label>
        <input type="email" name="email" value="{{ old('email') }}" required
               class="w-full bg-gray-950 border border-gray-800 rounded-lg px-3 py-2.5
                      text-sm text-gray-200 focus:outline-none focus:ring-1
                      focus:ring-indigo-500 focus:border-indigo-500"
               placeholder="john@example.com"/>
        @error('email')<p class="text-xs text-rose-400 mt-1">{{ $message }}</p>@enderror
      </div>

      <div>
        <label class="block text-xs text-gray-500 mb-1.5">Password</label>
        <input type="password" name="password" required
               class="w-full bg-gray-950 border border-gray-800 rounded-lg px-3 py-2.5
                      text-sm text-gray-200 focus:outline-none focus:ring-1
                      focus:ring-indigo-500 focus:border-indigo-500"
               placeholder="Min. 8 characters"/>
        @error('password')<p class="text-xs text-rose-400 mt-1">{{ $message }}</p>@enderror
      </div>

      <div>
        <label class="block text-xs text-gray-500 mb-1.5">Confirm Password</label>
        <input type="password" name="password_confirmation" required
               class="w-full bg-gray-950 border border-gray-800 rounded-lg px-3 py-2.5
                      text-sm text-gray-200 focus:outline-none focus:ring-1
                      focus:ring-indigo-500 focus:border-indigo-500"
               placeholder="Repeat password"/>
      </div>

      <div>
        <label class="block text-xs text-gray-500 mb-1.5">Role</label>
        <select name="role" required
                class="w-full bg-gray-950 border border-gray-800 rounded-lg px-3 py-2.5
                       text-sm text-gray-200 focus:outline-none focus:ring-1
                       focus:ring-indigo-500 focus:border-indigo-500">
          <option value="">Select a role</option>
          @foreach($roles as $role)
            <option value="{{ $role->name }}" {{ old('role') === $role->name ? 'selected' : '' }}>
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
          Create User
        </button>
        <a href="{{ route('users.index') }}"
           class="text-sm text-gray-500 hover:text-gray-300 transition-colors">Cancel</a>
      </div>
    </form>
  </div>
</div>
@endsection