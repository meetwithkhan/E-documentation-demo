@extends('layouts.app')
@section('title', 'Edit User')
@section('page-title', 'Edit User')

@section('content')
<div class="max-w-2xl">
  <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800
              rounded-xl p-6">
    <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-5">
      Edit — {{ $user->name }}
    </h3>

    <form method="POST" action="{{ route('users.update', $user) }}" class="space-y-4"
          x-data="deptSelector({{ $user->department_id ?? 'null' }}, {{ $user->function_id ?? 'null' }})">
      @csrf @method('PATCH')

      <!-- Employee ID -->
      @if(auth()->user()->hasRole('manager | user'))
      <div>
        <label class="block text-xs text-gray-500 mb-1.5">
          Employee ID <span class="text-rose-500">*</span>
        </label>
        <input type="text" name="employee_id"
              value="{{ old('employee_id', $user->employee_id) }}"
              required maxlength="20"
              
              readonly
              class="w-full bg-gray-50 dark:bg-gray-950 border border-gray-200
                      dark:border-gray-800 rounded-lg px-3 py-2.5 text-sm
                      text-gray-900 dark:text-gray-200 focus:outline-none
                      focus:ring-1 focus:ring-indigo-500 font-mono"
              placeholder="e.g. 90008146"/>
        @error('employee_id')
          <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
        @enderror
      </div>
      @elseif(auth()->user()->hasRole('admin'))
      <div>
        <label class="block text-xs text-gray-500 mb-1.5">
          Employee ID <span class="text-rose-500">*</span>
        </label>
        <input type="text" name="employee_id"
              value="{{ old('employee_id', $user->employee_id) }}"
              required maxlength="20"
              
              
              class="w-full bg-gray-50 dark:bg-gray-950 border border-gray-200
                      dark:border-gray-800 rounded-lg px-3 py-2.5 text-sm
                      text-gray-900 dark:text-gray-200 focus:outline-none
                      focus:ring-1 focus:ring-indigo-500 font-mono"
              placeholder="e.g. 90008146"/>
        @error('employee_id')
          <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
        @enderror
      </div>
      @endif

      <!-- Name -->
      <div>
        <label class="block text-xs text-gray-500 mb-1.5">Full Name</label>
        <input type="text" name="name" value="{{ old('name', $user->name) }}" required
               class="w-full bg-gray-50 dark:bg-gray-950 border border-gray-200
                      dark:border-gray-800 rounded-lg px-3 py-2.5 text-sm
                      text-gray-900 dark:text-gray-200 focus:outline-none
                      focus:ring-1 focus:ring-indigo-500"/>
        @error('name')<p class="text-xs text-rose-400 mt-1">{{ $message }}</p>@enderror
      </div>

      <!-- Email -->
      <div>
        <label class="block text-xs text-gray-500 mb-1.5">Email Address</label>
        <input type="email" name="email" value="{{ old('email', $user->email) }}" required
               class="w-full bg-gray-50 dark:bg-gray-950 border border-gray-200
                      dark:border-gray-800 rounded-lg px-3 py-2.5 text-sm
                      text-gray-900 dark:text-gray-200 focus:outline-none
                      focus:ring-1 focus:ring-indigo-500"/>
        @error('email')<p class="text-xs text-rose-400 mt-1">{{ $message }}</p>@enderror
      </div>

      <!-- Department + Function -->
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
          <label class="block text-xs text-gray-500 mb-1.5">Department</label>
          <select name="department_id" required
                  @change="loadFunctions($event.target.value)"
                  class="w-full bg-gray-50 dark:bg-gray-950 border border-gray-200
                         dark:border-gray-800 rounded-lg px-3 py-2.5 text-sm
                         text-gray-900 dark:text-gray-200 focus:outline-none
                         focus:ring-1 focus:ring-indigo-500">
            <option value="">Select Department</option>
            @foreach($departments as $dept)
              <option value="{{ $dept->id }}"
                      {{ $user->department_id == $dept->id ? 'selected' : '' }}>
                {{ $dept->name }}
              </option>
            @endforeach
          </select>
          @error('department_id')<p class="text-xs text-rose-400 mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
          <label class="block text-xs text-gray-500 mb-1.5">Function</label>
          <select name="function_id" required x-ref="functionSelect"
                  class="w-full bg-gray-50 dark:bg-gray-950 border border-gray-200
                         dark:border-gray-800 rounded-lg px-3 py-2.5 text-sm
                         text-gray-900 dark:text-gray-200 focus:outline-none
                         focus:ring-1 focus:ring-indigo-500">
            <option value="">Select Function</option>
            @foreach($departments->firstWhere('id', $user->department_id)?->functions ?? [] as $func)
              <option value="{{ $func->id }}"
                      {{ $user->function_id == $func->id ? 'selected' : '' }}>
                {{ $func->name }}
              </option>
            @endforeach
          </select>
          @error('function_id')<p class="text-xs text-rose-400 mt-1">{{ $message }}</p>@enderror
        </div>
      </div>

      <!-- Designation + Role -->
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
          <label class="block text-xs text-gray-500 mb-1.5">Designation</label>
          <select name="designation_id" required
                  class="w-full bg-gray-50 dark:bg-gray-950 border border-gray-200
                         dark:border-gray-800 rounded-lg px-3 py-2.5 text-sm
                         text-gray-900 dark:text-gray-200 focus:outline-none
                         focus:ring-1 focus:ring-indigo-500">
            <option value="">Select Designation</option>
            @foreach($designations as $desig)
              <option value="{{ $desig->id }}"
                      {{ $user->designation_id == $desig->id ? 'selected' : '' }}>
                {{ $desig->name }}
              </option>
            @endforeach
          </select>
          @error('designation_id')<p class="text-xs text-rose-400 mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
          <label class="block text-xs text-gray-500 mb-1.5">Role</label>
          <select name="role" required
                  class="w-full bg-gray-50 dark:bg-gray-950 border border-gray-200
                         dark:border-gray-800 rounded-lg px-3 py-2.5 text-sm
                         text-gray-900 dark:text-gray-200 focus:outline-none
                         focus:ring-1 focus:ring-indigo-500">
            @foreach($roles as $role)
              <option value="{{ $role->name }}"
                      {{ $userRole === $role->name ? 'selected' : '' }}>
                {{ ucfirst($role->name) }}
              </option>
            @endforeach
          </select>
          @error('role')<p class="text-xs text-rose-400 mt-1">{{ $message }}</p>@enderror
        </div>
      </div>

      <!-- Password -->
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
          <label class="block text-xs text-gray-500 mb-1.5">
            New Password
            <span class="text-gray-400">(leave blank to keep)</span>
          </label>
          <input type="password" name="password"
                 class="w-full bg-gray-50 dark:bg-gray-950 border border-gray-200
                        dark:border-gray-800 rounded-lg px-3 py-2.5 text-sm
                        text-gray-900 dark:text-gray-200 focus:outline-none
                        focus:ring-1 focus:ring-indigo-500"
                 placeholder="Min. 8 characters"/>
          @error('password')<p class="text-xs text-rose-400 mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
          <label class="block text-xs text-gray-500 mb-1.5">Confirm New Password</label>
          <input type="password" name="password_confirmation"
                 class="w-full bg-gray-50 dark:bg-gray-950 border border-gray-200
                        dark:border-gray-800 rounded-lg px-3 py-2.5 text-sm
                        text-gray-900 dark:text-gray-200 focus:outline-none
                        focus:ring-1 focus:ring-indigo-500"/>
        </div>
      </div>

      <div class="flex items-center gap-3 pt-2">
        <button type="submit"
                class="bg-indigo-600 hover:bg-indigo-500 text-white text-sm
                       font-medium px-5 py-2.5 rounded-lg transition-colors">
          Save Changes
        </button>
        <a href="{{ route('users.index') }}"
           class="text-sm text-gray-500 hover:text-gray-700 dark:hover:text-gray-300
                  transition-colors">Cancel</a>
      </div>
    </form>
  </div>
</div>

@push('scripts')
<script>
function deptSelector(currentDeptId, currentFuncId) {
  return {
    init() {
      // Functions already pre-loaded for existing user
    },
    loadFunctions(deptId) {
      const select = this.$refs.functionSelect;
      select.innerHTML = '<option value="">Loading...</option>';

      if (!deptId) {
        select.innerHTML = '<option value="">Select Department first</option>';
        return;
      }

      fetch(`/departments/${deptId}/functions`)
        .then(r => r.json())
        .then(data => {
          select.innerHTML = '<option value="">Select Function</option>';
          data.forEach(f => {
            const selected = f.id == currentFuncId ? 'selected' : '';
            select.innerHTML += `<option value="${f.id}" ${selected}>${f.name}</option>`;
          });
        });
    }
  }
}
</script>
@endpush

@endsection