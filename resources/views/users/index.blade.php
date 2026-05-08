@extends('layouts.app')
@section('title', 'Users')
@section('page-title', 'User Management')

@section('content')
@include('layouts.partials.alert')

<div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800
            rounded-xl overflow-hidden">

  <!-- Header -->
  <div class="flex items-center gap-3 px-5 py-4
            border-b border-gray-200 dark:border-gray-800">
                <!-- Title -->
   <div class="flex items-center gap-3 px-5 py-4
            border-b border-gray-200 dark:border-gray-800">

  <!-- Title -->
  <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 flex-shrink-0">
    All Users
  </h3>

  <!-- Search -->
  <div class="relative w-64">
    
    <input type="text" id="user-search"
           placeholder="Search by name, email, ID..."
           class="w-full pl-9 pr-4 py-2 text-xs rounded-lg
                  bg-gray-50 dark:bg-gray-950
                  border border-gray-200 dark:border-gray-800
                  text-gray-900 dark:text-gray-200
                  placeholder-gray-400 dark:placeholder-gray-600
                  focus:outline-none focus:ring-1 focus:ring-indigo-500"/>
  </div>

  <!-- Count -->
  <span id="user-count"
        class="text-xs text-gray-400 dark:text-gray-600 flex-shrink-0">
    {{ $users->total() }} users
  </span>

  <!-- Spacer -->
  <div class="flex-5"></div>

  <!-- Add User -->
  <a href="{{ route('users.create') }}"
     class="flex items-center gap-1.5 bg-indigo-600 hover:bg-indigo-500
            text-white text-xs font-medium px-3 py-2 rounded-lg
            transition-colors flex-shrink-0">
    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M12 4v16m8-8H4"/>
    </svg>
    Add User
  </a>
</div>
  </div>

  <!-- Table -->
  <div class="overflow-x-auto">
    <table class="w-full text-sm" id="users-table">
      <thead>
        <tr class="border-b border-gray-200 dark:border-gray-800
                   bg-gray-50 dark:bg-gray-800/40">
          <th class="text-left px-4 py-3 text-xs font-medium uppercase tracking-wider
                     text-gray-500 dark:text-gray-600 whitespace-nowrap">User</th>
          <th class="text-left px-4 py-3 text-xs font-medium uppercase tracking-wider
                     text-gray-500 dark:text-gray-600 whitespace-nowrap">Emp. ID</th>
          <th class="text-left px-4 py-3 text-xs font-medium uppercase tracking-wider
                     text-gray-500 dark:text-gray-600 whitespace-nowrap">Email</th>
          <th class="text-left px-4 py-3 text-xs font-medium uppercase tracking-wider
                     text-gray-500 dark:text-gray-600 whitespace-nowrap">Department</th>
          <th class="text-left px-4 py-3 text-xs font-medium uppercase tracking-wider
                     text-gray-500 dark:text-gray-600 whitespace-nowrap">Function</th>
          <th class="text-left px-4 py-3 text-xs font-medium uppercase tracking-wider
                     text-gray-500 dark:text-gray-600 whitespace-nowrap">Designation</th>
          <th class="text-left px-4 py-3 text-xs font-medium uppercase tracking-wider
                     text-gray-500 dark:text-gray-600 whitespace-nowrap">Role</th>
          <th class="text-left px-4 py-3 text-xs font-medium uppercase tracking-wider
                     text-gray-500 dark:text-gray-600 whitespace-nowrap">Joined</th>
          <th class="text-right px-4 py-3 text-xs font-medium uppercase tracking-wider
                     text-gray-500 dark:text-gray-600 whitespace-nowrap">Actions</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-100 dark:divide-gray-800" id="users-tbody">
        @forelse ($users as $user)
        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/40 transition-colors user-row">

          <!-- User -->
          <td class="px-4 py-3 whitespace-nowrap">
            <div class="flex items-center gap-3">
              <div class="w-8 h-8 rounded-full bg-indigo-600 flex items-center
                          justify-center text-xs font-medium text-white flex-shrink-0">
                {{ strtoupper(substr($user->name, 0, 2)) }}
              </div>
              <span class="font-medium text-gray-800 dark:text-gray-200 text-sm">
                {{ $user->name }}
              </span>
              @if(!$user->hasVerifiedEmail())
              <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs
                          bg-amber-50 dark:bg-amber-900/30
                          text-amber-600 dark:text-amber-400
                          border border-amber-200 dark:border-amber-800 ml-1"
                    title="Email not verified">
                Unverified
              </span>
            @endif
            </div>
          </td>

          <!-- Emp ID -->
          <td class="px-4 py-3 whitespace-nowrap">
            @if($user->employee_id)
              <span class="text-xs font-mono font-medium px-2 py-1 rounded
                           bg-indigo-50 dark:bg-indigo-900/30
                           text-indigo-600 dark:text-indigo-400
                           border border-indigo-200 dark:border-indigo-800">
                {{ $user->employee_id }}
              </span>
            @else
              <span class="text-gray-300 dark:text-gray-700">—</span>
            @endif
          </td>

          <!-- Email -->
          <td class="px-4 py-3 whitespace-nowrap text-xs
                     text-gray-500 dark:text-gray-500">
            {{ $user->email }}
          </td>

          <!-- Department -->
          <td class="px-4 py-3 whitespace-nowrap text-xs">
            @if($user->department)
              <span class="inline-flex items-center px-2 py-0.5 rounded text-xs
                           bg-blue-50 dark:bg-blue-900/30
                           text-blue-600 dark:text-blue-400
                           border border-blue-200 dark:border-blue-800">
                {{ $user->department->name }}
              </span>
            @else
              <span class="text-gray-300 dark:text-gray-700">—</span>
            @endif
          </td>

          <!-- Function -->
          <td class="px-4 py-3 whitespace-nowrap text-xs">
            @if($user->function)
              <span class="inline-flex items-center px-2 py-0.5 rounded text-xs
                           bg-teal-50 dark:bg-teal-900/30
                           text-teal-600 dark:text-teal-400
                           border border-teal-200 dark:border-teal-800">
                {{ $user->function->name }}
              </span>
            @else
              <span class="text-gray-300 dark:text-gray-700">—</span>
            @endif
          </td>

          <!-- Designation -->
          <td class="px-4 py-3 whitespace-nowrap text-xs">
            @if($user->designation)
              <span class="inline-flex items-center px-2 py-0.5 rounded text-xs
                           bg-amber-50 dark:bg-amber-900/30
                           text-amber-600 dark:text-amber-400
                           border border-amber-200 dark:border-amber-800">
                {{ $user->designation->name }}
              </span>
            @else
              <span class="text-gray-300 dark:text-gray-700">—</span>
            @endif
          </td>

          <!-- Role -->
          <td class="px-4 py-3 whitespace-nowrap">
            @foreach($user->roles as $role)
              @php
                $colors = [
                  'admin'   => 'bg-indigo-50 dark:bg-indigo-900/50 text-indigo-600 dark:text-indigo-400 border-indigo-200 dark:border-indigo-800',
                  'manager' => 'bg-amber-50 dark:bg-amber-900/50 text-amber-600 dark:text-amber-400 border-amber-200 dark:border-amber-800',
                  'user'    => 'bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 border-gray-200 dark:border-gray-700',
                ];
                $color = $colors[$role->name] ?? $colors['user'];
              @endphp
              <span class="inline-flex items-center px-2 py-0.5 rounded text-xs
                           border {{ $color }}">
                {{ ucfirst($role->name) }}
              </span>
            @endforeach
          </td>

          <!-- Joined -->
          <td class="px-4 py-3 whitespace-nowrap text-xs
                     text-gray-500 dark:text-gray-500">
            {{ $user->created_at->format('M d, Y') }}
          </td>

          <!-- Actions -->
          <td class="px-4 py-3 whitespace-nowrap">
            <div class="flex items-center justify-end gap-3">
              <a href="{{ route('users.edit', $user) }}"
                class="text-xs text-indigo-600 dark:text-indigo-400
                        hover:text-indigo-800 dark:hover:text-indigo-300 transition-colors">
                Edit
              </a>

              <!-- In the actions column, after Edit -->
              @if(!$user->hasVerifiedEmail())
                <form method="POST" action="{{ route('users.resend-verification', $user) }}">
                  @csrf
                  <button type="submit"
                          class="text-xs text-amber-500 hover:text-amber-700
                                dark:hover:text-amber-400 transition-colors"
                          title="Email not verified">
                    Resend Verify
                  </button>
                </form>
              @endif

              @if($user->id !== auth()->id())

                @if(auth()->user()->hasRole('admin') && !$user->hasRole('admin'))
                  {{-- Admin can delete anyone except other admins --}}
                  <form method="POST" action="{{ route('users.destroy', $user) }}"
                        onsubmit="return confirm('Delete this user?')">
                    @csrf @method('DELETE')
                    <button type="submit"
                            class="text-xs text-rose-500 hover:text-rose-700
                                  dark:hover:text-rose-400 transition-colors">
                      Delete
                    </button>
                  </form>

                @elseif(auth()->user()->hasRole('manager') && $user->hasRole('manager'))
                  {{-- Manager requests deletion of another manager --}}
                  @php
                    $pendingReq = \App\Models\DeletionRequest::where('target_user_id', $user->id)
                                    ->where('status', 'pending')->first();
                  @endphp

                  @if($pendingReq)
                    <span class="text-xs text-amber-500 dark:text-amber-400">
                      Request pending...
                    </span>
                  @else
                    <button onclick="openDeletionModal({{ $user->id }}, '{{ addslashes($user->name) }}')"
                            class="text-xs text-rose-500 hover:text-rose-700
                                  dark:hover:text-rose-400 transition-colors">
                      Request Delete
                    </button>
                  @endif

                @elseif(auth()->user()->hasRole('manager') && !$user->hasAnyRole(['admin', 'manager']))
                  {{-- Manager can directly delete regular users --}}
                  <form method="POST" action="{{ route('users.destroy', $user) }}"
                        onsubmit="return confirm('Delete this user?')">
                    @csrf @method('DELETE')
                    <button type="submit"
                            class="text-xs text-rose-500 hover:text-rose-700
                                  dark:hover:text-rose-400 transition-colors">
                      Delete
                    </button>
                  </form>

                @endif

              @endif
            </div>
          </td>

        </tr>
        @empty
        <tr id="no-results-initial">
          <td colspan="9"
              class="px-5 py-10 text-center text-sm text-gray-400 dark:text-gray-600">
            No users found.
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <!-- No search results message (hidden by default) -->
  <div id="no-search-results" class="hidden px-5 py-10 text-center">
    <p class="text-sm text-gray-400 dark:text-gray-600">
      No users match your search.
    </p>
  </div>

  @if($users->hasPages())
  <div class="px-5 py-3 border-t border-gray-200 dark:border-gray-800">
    {{ $users->links() }}
  </div>
  @endif

</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
  const input      = document.getElementById('user-search');
  const rows       = document.querySelectorAll('.user-row');
  const countEl    = document.getElementById('user-count');
  const noResults  = document.getElementById('no-search-results');
  const totalCount = rows.length;

  input.addEventListener('input', function () {
    const query = this.value.toLowerCase().trim();
    let visible = 0;

    rows.forEach(row => {
      // Search across all text content in the row
      const text = row.innerText.toLowerCase();
      const match = text.includes(query);
      row.style.display = match ? '' : 'none';
      if (match) visible++;
    });

    // Update count
    countEl.textContent = query
      ? `${visible} of ${totalCount} users`
      : `${totalCount} users`;

    // Show/hide no results message
    noResults.classList.toggle('hidden', visible > 0 || query === '');
  });
});
</script>
@endpush


<!-- Deletion Request Modal -->
<div id="deletion-modal"
     class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50">
  <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800
              rounded-xl p-6 w-full max-w-md shadow-xl">
    <h3 class="text-sm font-medium text-gray-800 dark:text-gray-200 mb-1">
      Request Manager Deletion
    </h3>
    <p class="text-xs text-gray-500 dark:text-gray-500 mb-4">
      Deleting <span id="modal-user-name" class="font-medium text-rose-500"></span>
      requires admin approval. Provide a reason below.
    </p>

    <form method="POST" action="{{ route('deletion-requests.store') }}">
      @csrf
      <input type="hidden" name="target_user_id" id="modal-user-id"/>

      <div class="mb-4">
        <label class="block text-xs text-gray-500 dark:text-gray-500 mb-1.5">
          Reason <span class="text-rose-500">*</span>
        </label>
        <textarea name="reason" rows="3" required
                  class="w-full bg-gray-50 dark:bg-gray-950 border border-gray-200
                         dark:border-gray-800 rounded-lg px-3 py-2.5 text-sm
                         text-gray-900 dark:text-gray-200 resize-none focus:outline-none
                         focus:ring-1 focus:ring-rose-500"
                  placeholder="Explain why this manager should be deleted..."></textarea>
      </div>

      <div class="flex gap-3">
        <button type="submit"
                class="flex-1 bg-rose-600 hover:bg-rose-500 text-white text-sm
                       font-medium py-2.5 rounded-lg transition-colors">
          Submit Request
        </button>
        <button type="button" onclick="closeDeletionModal()"
                class="flex-1 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200
                       dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300
                       text-sm font-medium py-2.5 rounded-lg transition-colors">
          Cancel
        </button>
      </div>
    </form>
  </div>
</div>

@push('scripts')
<script>
function openDeletionModal(userId, userName) {
  document.getElementById('modal-user-id').value = userId;
  document.getElementById('modal-user-name').textContent = userName;
  document.getElementById('deletion-modal').classList.remove('hidden');
}
function closeDeletionModal() {
  document.getElementById('deletion-modal').classList.add('hidden');
}
// Close on backdrop click
document.getElementById('deletion-modal').addEventListener('click', function(e) {
  if (e.target === this) closeDeletionModal();
});
</script>
@endpush

@endsection