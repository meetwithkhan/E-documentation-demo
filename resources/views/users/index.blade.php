@extends('layouts.app')
@section('title', 'Users')
@section('page-title', 'User Management')

@section('content')
@include('layouts.partials.alert')

<div class="bg-gray-900 border border-gray-800 rounded-xl overflow-hidden">

  <!-- Header -->
  <div class="flex items-center justify-between px-5 py-4 border-b border-gray-800">
    <h3 class="text-sm font-medium text-gray-300">All Users</h3>
    <a href="{{ route('users.create') }}"
       class="flex items-center gap-1.5 bg-indigo-600 hover:bg-indigo-500 text-white
              text-xs font-medium px-3 py-2 rounded-lg transition-colors">
      <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
      </svg>
      Add User
    </a>
  </div>

  <!-- Table -->
  <div class="overflow-x-auto">
    <table class="w-full text-sm">
      <thead>
        <tr class="border-b border-gray-800">
          <th class="text-left px-5 py-3 text-xs text-gray-600 font-medium uppercase tracking-wider">User</th>
          <th class="text-left px-5 py-3 text-xs text-gray-600 font-medium uppercase tracking-wider">Email</th>
          <th class="text-left px-5 py-3 text-xs text-gray-600 font-medium uppercase tracking-wider">Role</th>
          <th class="text-left px-5 py-3 text-xs text-gray-600 font-medium uppercase tracking-wider">Joined</th>
          <th class="text-right px-5 py-3 text-xs text-gray-600 font-medium uppercase tracking-wider">Actions</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-800">
        @forelse ($users as $user)
        <tr class="hover:bg-gray-800/40 transition-colors">
          <td class="px-5 py-3.5">
            <div class="flex items-center gap-3">
              <div class="w-8 h-8 rounded-full bg-indigo-600 flex items-center justify-center
                          text-xs font-medium text-white flex-shrink-0">
                {{ strtoupper(substr($user->name, 0, 2)) }}
              </div>
              <span class="text-gray-300 font-medium">{{ $user->name }}</span>
            </div>
          </td>
          <td class="px-5 py-3.5 text-gray-500">{{ $user->email }}</td>
          <td class="px-5 py-3.5">
            @foreach($user->roles as $role)
              @php
                $colors = ['admin' => 'bg-indigo-900/50 text-indigo-400 border-indigo-800',
                           'manager' => 'bg-amber-900/50 text-amber-400 border-amber-800',
                           'user' => 'bg-gray-800 text-gray-400 border-gray-700'];
                $color = $colors[$role->name] ?? 'bg-gray-800 text-gray-400 border-gray-700';
              @endphp
              <span class="inline-flex items-center px-2 py-0.5 rounded text-xs border {{ $color }}">
                {{ ucfirst($role->name) }}
              </span>
            @endforeach
          </td>
          <td class="px-5 py-3.5 text-gray-500 text-xs">{{ $user->created_at->format('M d, Y') }}</td>
          <td class="px-5 py-3.5">
            <div class="flex items-center justify-end gap-2">
              <a href="{{ route('users.edit', $user) }}"
                 class="text-xs text-indigo-400 hover:text-indigo-300 transition-colors">Edit</a>
              @if($user->id !== auth()->id())
              <form method="POST" action="{{ route('users.destroy', $user) }}"
                    onsubmit="return confirm('Delete this user?')">
                @csrf @method('DELETE')
                <button type="submit" class="text-xs text-rose-500 hover:text-rose-400 transition-colors">
                  Delete
                </button>
              </form>
              @endif
            </div>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="5" class="px-5 py-10 text-center text-gray-600 text-sm">No users found.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <!-- Pagination -->
  @if($users->hasPages())
  <div class="px-5 py-3 border-t border-gray-800">
    {{ $users->links() }}
  </div>
  @endif

</div>
@endsection