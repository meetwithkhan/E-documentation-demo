@extends('layouts.app')
@section('title', 'Add User')
@section('page-title', 'Add User')

@section('content')
<div class="max-w-2xl">
  <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800
              rounded-xl p-6">
    <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-5">User Details</h3>

    <form method="POST" action="{{ route('users.store') }}" class="space-y-4"
          x-data="deptSelector()">
      @csrf

      <!-- Name -->
      <div>
        <label class="block text-xs text-gray-500 mb-1.5">Full Name<span class="text-rose-500">*</span></label>
        <input type="text" name="name" value="{{ old('name') }}" required
               class="w-full bg-gray-50 dark:bg-gray-950 border border-gray-200
                      dark:border-gray-800 rounded-lg px-3 py-2.5 text-sm
                      text-gray-900 dark:text-gray-200 focus:outline-none
                      focus:ring-1 focus:ring-indigo-500"/>
        @error('name')<p class="text-xs text-rose-400 mt-1">{{ $message }}</p>@enderror
      </div>

      <!-- Email -->
      <div>
        <label class="block text-xs text-gray-500 mb-1.5">Email Address<span class="text-rose-500">*</span></label>
        <input type="email" name="email" value="{{ old('email') }}" required
               class="w-full bg-gray-50 dark:bg-gray-950 border border-gray-200
                      dark:border-gray-800 rounded-lg px-3 py-2.5 text-sm
                      text-gray-900 dark:text-gray-200 focus:outline-none
                      focus:ring-1 focus:ring-indigo-500"/>
        @error('email')<p class="text-xs text-rose-400 mt-1">{{ $message }}</p>@enderror
      </div>

      <!-- Department + Function -->
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <!-- Employee ID -->
        <div>
          <label class="block text-xs text-gray-500 mb-1.5">
            Employee ID <span class="text-rose-500">*</span>
          </label>
          <input type="text" name="employee_id" value="{{ old('employee_id') }}"
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
                      {{ old('department_id') == $dept->id ? 'selected' : '' }}>
                {{ $dept->name }}
              </option>
            @endforeach
          </select>
          @error('department_id')<p class="text-xs text-rose-400 mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
          <label class="block text-xs text-gray-500 mb-1.5">Function</label>
          <select name="function_id" required
                  class="w-full bg-gray-50 dark:bg-gray-950 border border-gray-200
                         dark:border-gray-800 rounded-lg px-3 py-2.5 text-sm
                         text-gray-900 dark:text-gray-200 focus:outline-none
                         focus:ring-1 focus:ring-indigo-500">
            <option value="">Select Department first</option>
            @if(old('department_id'))
              @foreach($departments->find(old('department_id'))?->functions ?? [] as $func)
                <option value="{{ $func->id }}"
                        {{ old('function_id') == $func->id ? 'selected' : '' }}>
                  {{ $func->name }}
                </option>
              @endforeach
            @endif
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
                      {{ old('designation_id') == $desig->id ? 'selected' : '' }}>
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
            <option value="">Select Role</option>
            @foreach($roles as $role)
              <option value="{{ $role->name }}"
                      {{ old('role') === $role->name ? 'selected' : '' }}>
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
          <label class="block text-xs text-gray-500 mb-1.5">Password</label>
          <input type="password" name="password" required
                 class="w-full bg-gray-50 dark:bg-gray-950 border border-gray-200
                        dark:border-gray-800 rounded-lg px-3 py-2.5 text-sm
                        text-gray-900 dark:text-gray-200 focus:outline-none
                        focus:ring-1 focus:ring-indigo-500"
                 placeholder="Min. 8 characters"/>
          @error('password')<p class="text-xs text-rose-400 mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
          <label class="block text-xs text-gray-500 mb-1.5">Confirm Password</label>
          <input type="password" name="password_confirmation" required
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
          Create User
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
function deptSelector() {
  return {
    loadFunctions(deptId) {
      const select = document.querySelector('select[name="function_id"]');
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
            select.innerHTML += `<option value="${f.id}">${f.name}</option>`;
          });
        });
    }
  }
}
</script>
@endpush

@endsection