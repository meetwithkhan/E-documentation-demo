@extends('layouts.app')
@section('title', 'Edit Role')
@section('page-title', 'Edit Role')

@section('content')
<div class="max-w-xl">
  <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800
              rounded-xl p-6">
    <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-5">
      Edit — {{ ucfirst($role->name) }}
    </h3>

    <form method="POST" action="{{ route('roles.update', $role) }}" class="space-y-5">
      @csrf @method('PATCH')

      <div>
        <label class="block text-xs text-gray-500 dark:text-gray-500 mb-1.5">
          Role Name
        </label>
        <input type="text" name="name" value="{{ old('name', $role->name) }}" required
               class="w-full bg-gray-50 dark:bg-gray-950 border border-gray-200
                      dark:border-gray-800 rounded-lg px-3 py-2.5 text-sm
                      text-gray-900 dark:text-gray-200 focus:outline-none
                      focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500"/>
        @error('name')
          <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div>
        <label class="block text-xs text-gray-500 dark:text-gray-500 mb-3">
          Permissions
        </label>
        <div class="space-y-4">
          @foreach($permissions as $group => $perms)
          <div class="bg-gray-50 dark:bg-gray-950 border border-gray-200
                      dark:border-gray-800 rounded-lg p-4">
            <div class="flex items-center justify-between mb-3">
              <p class="text-xs font-medium text-gray-500 dark:text-gray-500
                        uppercase tracking-wider">
                {{ ucfirst($group) }}
              </p>
              <!-- Select all for group -->
              <label class="flex items-center gap-1.5 cursor-pointer">
                <input type="checkbox"
                       onchange="toggleGroup(this, '{{ $group }}')"
                       class="rounded border-gray-300 dark:border-gray-700
                              bg-white dark:bg-gray-900 text-indigo-600"/>
                <span class="text-xs text-gray-400 dark:text-gray-600">All</span>
              </label>
            </div>
            <div class="grid grid-cols-2 gap-2" id="group-{{ $group }}">
              @foreach($perms as $perm)
              <label class="flex items-center gap-2 cursor-pointer group">
                <input type="checkbox"
                       name="permissions[]"
                       value="{{ $perm->name }}"
                       data-group="{{ $group }}"
                       {{ in_array($perm->name, $rolePermissions) ? 'checked' : '' }}
                       class="perm-checkbox rounded border-gray-300 dark:border-gray-700
                              bg-white dark:bg-gray-900 text-indigo-600
                              focus:ring-indigo-500 focus:ring-offset-white
                              dark:focus:ring-offset-gray-900"/>
                <span class="text-xs text-gray-600 dark:text-gray-400
                             group-hover:text-gray-900 dark:group-hover:text-gray-200
                             transition-colors">
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
                class="bg-indigo-600 hover:bg-indigo-500 text-white text-sm
                       font-medium px-5 py-2.5 rounded-lg transition-colors">
          Save Changes
        </button>
        <a href="{{ route('roles.index') }}"
           class="text-sm text-gray-500 hover:text-gray-700 dark:hover:text-gray-300
                  transition-colors">
          Cancel
        </a>
      </div>
    </form>
  </div>
</div>

@push('scripts')
<script>
function toggleGroup(masterCheckbox, group) {
  const boxes = document.querySelectorAll(`[data-group="${group}"]`);
  boxes.forEach(box => box.checked = masterCheckbox.checked);
}
</script>
@endpush

@endsection