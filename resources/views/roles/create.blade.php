@extends('layouts.app')
@section('title', 'Add Role')
@section('page-title', 'Add Role')

@section('content')
<div class="max-w-xl">
  <div class="bg-gray-900 border border-gray-800 rounded-xl p-6">
    <h3 class="text-sm font-medium text-gray-300 mb-5">Role Details</h3>

    <form method="POST" action="{{ route('roles.store') }}" class="space-y-5">
      @csrf

      <div>
        <label class="block text-xs text-gray-500 mb-1.5">Role Name</label>
        <input type="text" name="name" value="{{ old('name') }}" required
               class="w-full bg-gray-950 border border-gray-800 rounded-lg px-3 py-2.5
                      text-sm text-gray-200 focus:outline-none focus:ring-1
                      focus:ring-indigo-500 focus:border-indigo-500"
               placeholder="e.g. editor"/>
        @error('name')<p class="text-xs text-rose-400 mt-1">{{ $message }}</p>@enderror
      </div>

      <div>
        <label class="block text-xs text-gray-500 mb-3">Permissions</label>
        <div class="space-y-4">
          @foreach($permissions as $group => $perms)
          <div>
            <p class="text-xs text-gray-600 uppercase tracking-wider mb-2">{{ ucfirst($group) }}</p>
            <div class="grid grid-cols-2 gap-2">
              @foreach($perms as $perm)
              <label class="flex items-center gap-2 cursor-pointer group">
                <input type="checkbox" name="permissions[]" value="{{ $perm->name }}"
                       {{ in_array($perm->name, old('permissions', [])) ? 'checked' : '' }}
                       class="rounded border-gray-700 bg-gray-950 text-indigo-600
                              focus:ring-indigo-500 focus:ring-offset-gray-900"/>
                <span class="text-xs text-gray-500 group-hover:text-gray-300 transition-colors">
                  {{ $perm->name }}
                </span>
              </label>
              @endforeach
            </div>
          </div>
          @endforeach
        </div>
      </div>

      <div class="flex items-center gap-3 pt-2">
        <button type="submit"
                class="bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-medium
                       px-5 py-2.5 rounded-lg transition-colors">
          Create Role
        </button>
        <a href="{{ route('roles.index') }}"
           class="text-sm text-gray-500 hover:text-gray-300 transition-colors">Cancel</a>
      </div>
    </form>
  </div>
</div>
@endsection