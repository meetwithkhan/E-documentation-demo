<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Department;
use App\Models\Designation;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles', 'department', 'function', 'designation')
                    ->latest()->paginate(10);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $roles        = Role::all();
        $departments  = Department::with('functions')->get();
        $designations = Designation::orderBy('name')->get();
        return view('users.create', compact('roles', 'departments', 'designations'));
    }



    public function edit(User $user)
    {
        $roles        = Role::all();
        $departments  = Department::with('functions')->get();
        $designations = Designation::orderBy('name')->get();
        $userRole     = $user->roles->first()?->name;
        return view('users.edit', compact('user', 'roles', 'departments', 'designations', 'userRole'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id'    => 'required|string|max:20|unique:users,employee_id',
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|unique:users',
            'password'       => 'required|min:8|confirmed',
            'role'           => 'required|exists:roles,name',
            'department_id'  => 'required|exists:departments,id',
            'function_id'    => 'required|exists:functions,id',
            'designation_id' => 'required|exists:designations,id',
        ]);

        $user = User::create([
            'employee_id'    => $request->employee_id,
            'name'           => $request->name,
            'email'          => $request->email,
            'password'       => bcrypt($request->password),
            'department_id'  => $request->department_id,
            'function_id'    => $request->function_id,
            'designation_id' => $request->designation_id,
        ]);

        $user->assignRole($request->role);

        // Admin/Manager skip verification, regular users must verify
        if (in_array($request->role, ['admin', 'manager'])) {
            $user->markEmailAsVerified();
            return redirect()->route('users.index')
                ->with('success', 'User created successfully.');
        } else {
            $user->sendEmailVerificationNotification();
            return redirect()->route('users.index')
                ->with('success', "User created. Verification email sent to {$user->email}");
        }
    }

    public function resendVerification(User $user)
    {
        if ($user->hasVerifiedEmail()) {
            return back()->with('info', 'This user is already verified.');
        }

        $user->sendEmailVerificationNotification();

        return back()->with('success', "Verification email resent to {$user->email}");
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'employee_id'    => 'required|string|max:20|unique:users,employee_id,' . $user->id,
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|unique:users,email,' . $user->id,
            'role'           => 'required|exists:roles,name',
            'department_id'  => 'required|exists:departments,id',
            'function_id'    => 'required|exists:functions,id',
            'designation_id' => 'required|exists:designations,id',
        ]);

        $user->update([
            'employee_id'    => $request->employee_id,
            'name'           => $request->name,
            'email'          => $request->email,
            'department_id'  => $request->department_id,
            'function_id'    => $request->function_id,
            'designation_id' => $request->designation_id,
        ]);

        if ($request->password) {
            $request->validate(['password' => 'min:8|confirmed']);
            $user->update(['password' => bcrypt($request->password)]);
        }

        $user->syncRoles([$request->role]);

        return redirect()->route('users.index')
            ->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        // Cannot delete yourself
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        // Manager trying to delete another manager — needs admin approval
        if (auth()->user()->hasRole('manager') && $user->hasRole('manager')) {
            return back()->with('error', 'To delete a manager account, please submit a deletion request for admin approval.');
        }

        // Manager cannot delete admin
        if (auth()->user()->hasRole('manager') && $user->hasRole('admin')) {
            return back()->with('error', 'You are not authorized to delete admin accounts.');
        }

        $user->delete();
        return back()->with('success', 'User deleted successfully.');
    }
}