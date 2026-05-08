@extends('layouts.app')
@section('title', 'Roles')
@section('page-title', 'Roles & Permissions')

@section('content')
@include('layouts.partials.alert')

<div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800
            rounded-xl overflow-hidden">
  <div class="flex items-center justify-between px-5 py-4
              border-b border-gray-200 dark:border-gray-800">
    <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300">All Roles</h3>
    <a href="{{ route('roles.create') }}"
       class="flex items-center gap-1.5 bg-indigo-600 hover:bg-indigo-500 text-white
              text-xs font-medium px-3 py-2 rounded-lg transition-colors">
      <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 4v16m8-8H4"/>
      </svg>
      Add Role
    </a>
  </div>

  <div class="overflow-x-auto">
    <table class="w-full text-sm">
      <thead>
        <tr class="border-b border-gray-200 dark:border-gray-800
                   bg-gray-50 dark:bg-gray-800/40">
          <th class="text-left px-5 py-3 text-xs text-gray-500 dark:text-gray-600
                     font-medium uppercase tracking-wider">Role</th>
          <th class="text-left px-5 py-3 text-xs text-gray-500 dark:text-gray-600
                     font-medium uppercase tracking-wider">Permissions</th>
          <th class="text-left px-5 py-3 text-xs text-gray-500 dark:text-gray-600
                     font-medium uppercase tracking-wider">Users</th>
          <th class="text-right px-5 py-3 text-xs text-gray-500 dark:text-gray-600
                     font-medium uppercase tracking-wider">Actions</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
        @foreach($roles as $role)
        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/40 transition-colors">
          <td class="px-5 py-3.5">
            <span class="font-medium text-gray-800 dark:text-gray-200">
              {{ ucfirst($role->name) }}
            </span>
          </td>
          <td class="px-5 py-3.5">
            <div class="flex flex-wrap gap-1">
              @foreach($role->permissions->take(4) as $perm)
                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs
                             bg-gray-100 dark:bg-gray-800
                             text-gray-600 dark:text-gray-400
                             border border-gray-200 dark:border-gray-700">
                  {{ $perm->name }}
                </span>
              @endforeach
              @if($role->permissions->count() > 4)
                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs
                             bg-indigo-50 dark:bg-indigo-900/30
                             text-indigo-600 dark:text-indigo-400
                             border border-indigo-200 dark:border-indigo-800">
                  +{{ $role->permissions->count() - 4 }} more
                </span>
              @endif
            </div>
          </td>
          <td class="px-5 py-3.5 text-gray-500 dark:text-gray-500 text-sm">
            {{ $role->users_count }}
          </td>
          <td class="px-5 py-3.5">
            <div class="flex items-center justify-end gap-3">
              <a href="{{ route('roles.edit', $role) }}"
                 class="text-xs text-indigo-600 dark:text-indigo-400
                        hover:text-indigo-800 dark:hover:text-indigo-300 transition-colors">
                Edit
              </a>
              <form method="POST" action="{{ route('roles.destroy', $role) }}"
                    onsubmit="return confirm('Delete this role?')">
                @csrf @method('DELETE')
                <button type="submit"
                        class="text-xs text-rose-500 hover:text-rose-700
                               dark:hover:text-rose-400 transition-colors">
                  Delete
                </button>
              </form>
            </div>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection