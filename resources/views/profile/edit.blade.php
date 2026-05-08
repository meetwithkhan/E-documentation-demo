@extends('layouts.app')
@section('title', 'Profile Settings')
@section('page-title', 'Profile Settings')

@section('content')
@include('layouts.partials.alert')

<div class="max-w-xl space-y-4">

  <!-- Profile Info -->
  <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl p-6">
    <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-5">
      Profile Information
    </h3>

    <form method="POST" action="{{ route('profile.update') }}" class="space-y-4">
      @csrf @method('PATCH')

      <!-- Employee ID (readonly) -->
      <div>
        <label class="block text-xs text-gray-500 dark:text-gray-500 mb-1.5">
          Employee ID
        </label>
        <div class="flex items-center gap-3">
          <span class="text-sm font-mono font-medium px-3 py-2 rounded-lg
                       bg-gray-100 dark:bg-gray-800
                       border border-gray-200 dark:border-gray-700
                       text-indigo-600 dark:text-indigo-400">
            {{ auth()->user()->employee_id ?? '—' }}
          </span>
          <span class="text-xs text-gray-400 dark:text-gray-600">
            Cannot be changed
          </span>
        </div>
      </div>

      <!-- Full Name -->
      <div>
        <label class="block text-xs text-gray-500 dark:text-gray-500 mb-1.5">
          Full Name
        </label>
        <input type="text" name="name"
               value="{{ old('name', auth()->user()->name) }}" required
               class="w-full bg-gray-50 dark:bg-gray-950 border border-gray-200
                      dark:border-gray-800 rounded-lg px-3 py-2.5 text-sm
                      text-gray-900 dark:text-gray-200 focus:outline-none
                      focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500"/>
        @error('name')
          <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
        @enderror
      </div>

      <!-- Email -->
      <div>
        <label class="block text-xs text-gray-500 dark:text-gray-500 mb-1.5">
          Email Address
        </label>
        <input type="email" name="email"
               value="{{ old('email', auth()->user()->email) }}" required
               class="w-full bg-gray-50 dark:bg-gray-950 border border-gray-200
                      dark:border-gray-800 rounded-lg px-3 py-2.5 text-sm
                      text-gray-900 dark:text-gray-200 focus:outline-none
                      focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500"/>
        @error('email')
          <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
        @enderror
      </div>

      <!-- Readonly info fields -->
      <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-2
                  border-t border-gray-100 dark:border-gray-800">
        <div>
          <label class="block text-xs text-gray-500 dark:text-gray-500 mb-1.5">
            Designation
          </label>
          <p class="text-sm text-gray-700 dark:text-gray-300 px-3 py-2 rounded-lg
                    bg-gray-50 dark:bg-gray-800 border border-gray-200
                    dark:border-gray-700">
            {{ auth()->user()->designation?->name ?? '—' }}
          </p>
        </div>
        <div>
          <label class="block text-xs text-gray-500 dark:text-gray-500 mb-1.5">
            Department
          </label>
          <p class="text-sm text-gray-700 dark:text-gray-300 px-3 py-2 rounded-lg
                    bg-gray-50 dark:bg-gray-800 border border-gray-200
                    dark:border-gray-700">
            {{ auth()->user()->department?->name ?? '—' }}
          </p>
        </div>
        <div>
          <label class="block text-xs text-gray-500 dark:text-gray-500 mb-1.5">
            Function
          </label>
          <p class="text-sm text-gray-700 dark:text-gray-300 px-3 py-2 rounded-lg
                    bg-gray-50 dark:bg-gray-800 border border-gray-200
                    dark:border-gray-700">
            {{ auth()->user()->function?->name ?? '—' }}
          </p>
        </div>
      </div>

      <button type="submit"
              class="bg-indigo-600 hover:bg-indigo-500 text-white text-sm
                     font-medium px-5 py-2.5 rounded-lg transition-colors">
        Save Changes
      </button>
    </form>
  </div>

  <!-- Signature -->
  <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl p-6">
    <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
      My Signature
    </h3>
    <p class="text-xs text-gray-400 dark:text-gray-600 mb-4">
      Required to submit logbook entries. Upload a clear signature on white background (PNG recommended).
    </p>

    <!-- Current signature -->
    @if(auth()->user()->hasSignature())
    <div class="mb-4 p-3 bg-gray-50 dark:bg-gray-950 border border-gray-200
                dark:border-gray-800 rounded-lg inline-block">
      <img src="{{ auth()->user()->signatureUrl() }}"
          alt="My Signature"
          class="h-16 object-contain"/>
    </div>
    <div class="flex items-center gap-2 mb-4">
      <span class="inline-flex items-center gap-1 text-xs text-emerald-600
                  dark:text-emerald-400">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M5 13l4 4L19 7"/>
        </svg>
        Signature on file
      </span>
    </div>
    @else
    <div class="mb-4 flex items-center gap-2 px-4 py-3 rounded-lg
                bg-amber-50 dark:bg-amber-900/20
                border border-amber-200 dark:border-amber-800">
      <svg class="w-4 h-4 text-amber-500 flex-shrink-0"
          fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0
                000-3L12.71 3.86a2 2 0 00-3.42 0z"/>
      </svg>
      <p class="text-xs text-amber-700 dark:text-amber-400">
        No signature uploaded. You cannot submit logbook entries without a signature.
      </p>
    </div>
    @endif

    <!-- Upload form -->
    <form method="POST" action="{{ route('signature.update') }}"
          enctype="multipart/form-data" class="space-y-3">
      @csrf

      <div x-data="{ preview: null }" class="space-y-3">
        <div>
          <label class="block text-xs text-gray-500 dark:text-gray-500 mb-1.5">
            {{ auth()->user()->hasSignature() ? 'Replace Signature' : 'Upload Signature' }}
          </label>
          <input type="file" name="signature"
                accept="image/png,image/jpeg,image/jpg"
                required
                @change="preview = URL.createObjectURL($event.target.files[0])"
                class="w-full text-xs text-gray-500 dark:text-gray-400
                        file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0
                        file:text-xs file:font-medium
                        file:bg-indigo-50 dark:file:bg-indigo-900/30
                        file:text-indigo-600 dark:file:text-indigo-400
                        hover:file:bg-indigo-100 dark:hover:file:bg-indigo-900/50"/>
          <p class="text-xs text-gray-400 dark:text-gray-600 mt-1">
            PNG or JPG · Max 2MB · Max 800×400px · White background recommended
          </p>
        </div>

        <!-- Preview -->
        <div x-show="preview" class="p-3 bg-gray-50 dark:bg-gray-950 border
                                      border-gray-200 dark:border-gray-800 rounded-lg">
          <p class="text-xs text-gray-400 dark:text-gray-600 mb-2">Preview:</p>
          <img :src="preview" class="h-16 object-contain"/>
        </div>
      </div>

      <button type="submit"
              class="bg-indigo-600 hover:bg-indigo-500 text-white text-sm
                    font-medium px-5 py-2.5 rounded-lg transition-colors">
        {{ auth()->user()->hasSignature() ? 'Update Signature' : 'Upload Signature' }}
      </button>
    </form>

    @if(auth()->user()->hasSignature())
    <form method="POST" action="{{ route('signature.destroy') }}" class="mt-3">
      @csrf @method('DELETE')
      <button type="submit"
              onclick="return confirm('Remove your signature?')"
              class="text-xs text-rose-500 hover:text-rose-700
                    dark:hover:text-rose-400 transition-colors">
        Remove signature
      </button>
    </form>
    @endif
  </div>

  <!-- Change Password -->
  <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl p-6">
    <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-5">
      Change Password
    </h3>
    <form method="POST" action="{{ route('profile.password') }}" class="space-y-4">
      @csrf @method('PATCH')

      <div>
        <label class="block text-xs text-gray-500 dark:text-gray-500 mb-1.5">
          Current Password
        </label>
        <input type="password" name="current_password" required
               class="w-full bg-gray-50 dark:bg-gray-950 border border-gray-200
                      dark:border-gray-800 rounded-lg px-3 py-2.5 text-sm
                      text-gray-900 dark:text-gray-200 focus:outline-none
                      focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500"/>
        @error('current_password')
          <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div>
        <label class="block text-xs text-gray-500 dark:text-gray-500 mb-1.5">
          New Password
        </label>
        <input type="password" name="password" required
               class="w-full bg-gray-50 dark:bg-gray-950 border border-gray-200
                      dark:border-gray-800 rounded-lg px-3 py-2.5 text-sm
                      text-gray-900 dark:text-gray-200 focus:outline-none
                      focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500"/>
        @error('password')
          <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div>
        <label class="block text-xs text-gray-500 dark:text-gray-500 mb-1.5">
          Confirm New Password
        </label>
        <input type="password" name="password_confirmation" required
               class="w-full bg-gray-50 dark:bg-gray-950 border border-gray-200
                      dark:border-gray-800 rounded-lg px-3 py-2.5 text-sm
                      text-gray-900 dark:text-gray-200 focus:outline-none
                      focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500"/>
      </div>

      <button type="submit"
              class="bg-indigo-600 hover:bg-indigo-500 text-white text-sm
                     font-medium px-5 py-2.5 rounded-lg transition-colors">
        Update Password
      </button>
    </form>
  </div>

  <!-- Danger Zone — Admin only -->
  @if(auth()->user()->hasRole('admin'))
  <div class="bg-white dark:bg-gray-900 border border-rose-200 dark:border-rose-900/50
              rounded-xl p-6">
    <h3 class="text-sm font-medium text-rose-500 dark:text-rose-400 mb-1">
      Danger Zone
    </h3>
    <p class="text-xs text-gray-400 dark:text-gray-600 mb-4">
      Once deleted, your account cannot be recovered.
    </p>
    <form method="POST" action="{{ route('profile.destroy') }}"
          onsubmit="return confirm('Are you sure? This cannot be undone.')">
      @csrf @method('DELETE')
      <div class="mb-3">
        <label class="block text-xs text-gray-500 dark:text-gray-500 mb-1.5">
          Enter Password to Confirm
        </label>
        <input type="password" name="password" required
               class="w-full bg-gray-50 dark:bg-gray-950 border border-gray-200
                      dark:border-gray-800 rounded-lg px-3 py-2.5 text-sm
                      text-gray-900 dark:text-gray-200 focus:outline-none
                      focus:ring-1 focus:ring-rose-500 focus:border-rose-500"/>
        @error('password')
          <p class="text-xs text-rose-400 mt-1">{{ $message }}</p>
        @enderror
      </div>
      <button type="submit"
              class="bg-rose-600 hover:bg-rose-500 text-white text-sm
                     font-medium px-5 py-2.5 rounded-lg transition-colors">
        Delete My Account
      </button>
    </form>
  </div>
  @endif

</div>
@endsection