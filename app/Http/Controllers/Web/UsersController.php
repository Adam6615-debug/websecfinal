<?php

namespace App\Http\Controllers\Web;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Validation\Rules\Password;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Mail\VerificationEmail;
use App\Mail\ResetPasswordMail;
use Artisan;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Controller;
use App\Models\User;

class UsersController extends Controller
{

    use ValidatesRequests;

    public function list(Request $request)
    {
        if (!auth()->user()->hasAnyRole(['Admin', 'Employee', 'Manager'])) abort(401);


        $query = User::select('id', 'name', 'email', 'credit');


        if (auth()->user()->hasRole('Employee')) {
            $query->whereHas('roles', function ($q) {
                $q->where('name', 'Customer');
            });
        }

        $query->when(
            $request->keywords,
            fn($q) => $q->where("name", "like", "%$request->keywords%")
        );

        $users = $query->get();

        return view('users.list', compact('users'));
    }
    public function addCredit(Request $request, User $user)
    {
        if (!auth()->user()->hasAnyRole(['Admin', 'Employee'])) {
            abort(401);
        }

        $request->validate([
            'credit' => ['required', 'numeric', 'min:0'],
        ]);

        $user->credit += $request->credit;
        $user->save();

        return redirect()->back()->with('success', 'Credit added successfully.');
    }

    public function register(Request $request)
    {
        return view('users.register');
    }

    public function doRegister(Request $request)
    {

        try {
            $this->validate($request, [
                'name' => ['required', 'string', 'min:5'],
                'email' => ['required', 'email', 'unique:users'],
                'password' => ['required', 'confirmed', Password::min(8)->numbers()->letters()->mixedCase()->symbols()],
            ]);
        } catch (\Exception $e) {

            return redirect()->back()->withInput($request->input())->withErrors('Invalid registration information.');
        }
        

        $user =  new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password); //Secure

        $user->save();
        $user->assignRole('Customer');
        try {

        $title = "Verification Link";
        $token = Crypt::encryptString(json_encode(['id' => $user->id, 'email' => $user->email]));
        $link = route("verify", ['token' => $token]);
        Mail::to($user->email)->send(new VerificationEmail($link, $user->name));
        } catch (\Exception $e) {
            return redirect('/')->with('warning', 'Registered, but email verification failed. Please try again.');
        }

        return redirect('/')>with('message', 'Registered! Please check your email to verify.');;
    }
    
    public function addEmployee(Request $request)
    {
        // Check if the logged-in user is an admin
        if (!auth()->user()->hasRole('Admin')) {
            return redirect()->back()->withErrors('You are not authorized to add employees.');
        }

        try {
            // Validate the input
            $this->validate($request, [
                'name' => ['required', 'string', 'min:5'],
                'email' => ['required', 'email', 'unique:users'],
                'password' => ['required', 'confirmed', Password::min(8)->numbers()->letters()->mixedCase()->symbols()],
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withInput($request->input())->withErrors('Invalid registration information.');
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password); // Secure the password
        $user->save();

        $user->assignRole('employee');

        return redirect('/');
    }

    public function login(Request $request)
    {

        return view('users.login');
    }

    public function doLogin(Request $request)
    {

        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password]))
            return redirect()->back()->withInput($request->input())->withErrors('Invalid login information.');

            $user = User::where('email', $request->email)->first();

            // Check if email is verified
            if (!$user->email_verified_at) {
                Auth::logout(); // Ensure no session persists
                return redirect()->back()
                    ->withInput($request->input())
                    ->withErrors('Your email is not verified.');
            }
        
        Auth::setUser($user);

        return redirect('/');
    }

    public function verify(Request $request) {
    try{
        $decryptedData = json_decode(Crypt::decryptString($request->token), true);
    } catch (\Exception $e) {
        abort(400, 'Invalid or expired token.');
    }
        $user = User::find($decryptedData['id']);
        if(!$user) abort(401);
        $user->email_verified_at = Carbon::now();
        $user->save();
        return view('users.verified', compact('user'));
       }
    public function doLogout(Request $request)
    {

        Auth::logout();

        return redirect('/');
    }

    public function profile(Request $request, User $user = null)
    {

        $user = $user ?? auth()->user();
        if (auth()->id() != $user->id) {
            if (!auth()->user()->hasPermissionTo('show_users')) abort(401);
        }

        $permissions = [];
        foreach ($user->permissions as $permission) {
            $permissions[] = $permission;
        }
        foreach ($user->roles as $role) {
            foreach ($role->permissions as $permission) {
                $permissions[] = $permission;
            }
        }

        return view('users.profile', compact('user', 'permissions'));
    }

    public function edit(Request $request, User $user = null)
    {

        $user = $user ?? auth()->user();
        if (auth()->id() != $user?->id) {
            if (!auth()->user()->hasPermissionTo('edit_users')) abort(401);
        }

        $roles = [];
        foreach (Role::all() as $role) {
            $role->taken = ($user->hasRole($role->name));
            $roles[] = $role;
        }

        $permissions = [];
        $directPermissionsIds = $user->permissions()->pluck('id')->toArray();
        foreach (Permission::all() as $permission) {
            $permission->taken = in_array($permission->id, $directPermissionsIds);
            $permissions[] = $permission;
        }

        return view('users.edit', compact('user', 'roles', 'permissions'));
    }

    public function save(Request $request, User $user)
    {

        if (auth()->id() != $user->id) {
            if (!auth()->user()->hasPermissionTo('show_users')) abort(401);
        }

        $user->name = $request->name;
        $user->save();

        if (auth()->user()->hasPermissionTo('admin_users')) {

            $user->syncRoles($request->roles);
            $user->syncPermissions($request->permissions);

            Artisan::call('cache:clear');
        }

        //$user->syncRoles([1]);
        //Artisan::call('cache:clear');

        return redirect(route('profile', ['user' => $user->id]));
    }

    public function delete(Request $request, User $user)
    {

        if (!auth()->user()->hasPermissionTo('delete_users')) abort(401);

        $user->delete();

        return redirect()->route('users');
    }

    public function editPassword(Request $request, User $user = null)
    {

        $user = $user ?? auth()->user();
        if (auth()->id() != $user?->id) {
            if (!auth()->user()->hasPermissionTo('edit_users')) abort(401);
        }

        return view('users.edit_password', compact('user'));
    }

    public function savePassword(Request $request, User $user)
    {

        if (auth()->id() == $user?->id) {

            $this->validate($request, [
                'password' => ['required', 'confirmed', Password::min(8)->numbers()->letters()->mixedCase()->symbols()],
            ]);

            if (!Auth::attempt(['email' => $user->email, 'password' => $request->old_password])) {

                Auth::logout();
                return redirect('/');
            }
        } else if (!auth()->user()->hasPermissionTo('edit_users')) {

            abort(401);
        }

        $user->password = bcrypt($request->password); 
        $user->save();

        return redirect(route('profile', ['user' => $user->id]));
    }
    public function showAddEmployeePage()
    {
        if (!auth()->user()->hasPermissionTo('add_employee')) {
            abort(401);
        }
        return view('users.addemployee');
    }

public function redirectToGitHub()
{
    return Socialite::driver('github')->redirect();
}
public function handleGitHubCallback()
{
    $githubUser = Socialite::driver('github')->stateless()->user();

    // Check if user exists
    $user = User::where('email', $githubUser->getEmail())->first();

    if (!$user) {
        return redirect()->route('login')->withErrors([
            'email' => 'No account found with this email. Please sign up.',
        ]);
    }

    Auth::login($user);

    return redirect('/'); // or your intended home/dashboard page
}

    public function redirectToFacebook()
    {
    return Socialite::driver('facebook')->stateless()->redirect();
    }

    public function handleFacebookCallback()
    {
        $userfacebook = Socialite::driver('facebook')->stateless()->user();


        $user = User::firstOrCreate(
            ['facebook_id' => $userfacebook->getId()],
        ['facebook_name' => $userfacebook->getName(),
                'facebook_email' => $userfacebook->getEmail(),]
            );
            Auth::login($user)  ;
    }
    


 public function redirectToTwitter()
{
    return Socialite::driver('twitter')->redirect();
}

public function handleTwitterCallback()
{
    $twitterUser = Socialite::driver('twitter')->user();

    // Twitter might not provide email; handle that
    $email = $twitterUser->getEmail();

    if (!$email) {
        return redirect()->route('login')->withErrors([
            'email' => 'Twitter account does not provide an email. Please use another login method or register manually.',
        ]);
    }

    // Find user by email
    $user = User::where('email', $email)->first();

    if (!$user) {
        return redirect()->route('login')->withErrors([
            'email' => 'No account found with this email. Please sign up.',
        ]);
    }

    Auth::login($user);

    return redirect('/');
}

    public function rolesEditor(Request $request)
    {
        if (!auth()->user()->hasRole('Admin')) abort(401);
        $roles = \Spatie\Permission\Models\Role::with('permissions')->get();
        $permissions = \Spatie\Permission\Models\Permission::all();
        return view('users.roles_editor', compact('roles', 'permissions'));
    }

    public function saveRole(Request $request)
    {
        if (!auth()->user()->hasRole('Admin')) abort(401);
        $request->validate([
            'name' => 'required|string|max:255',
            'permissions' => 'array',
        ]);
        // Check for duplicate role name (case-insensitive)
        $existingRole = \Spatie\Permission\Models\Role::whereRaw('LOWER(name) = ?', [strtolower($request->name)])
            ->where('guard_name', 'web')
            ->when($request->id, function($q) use ($request) { return $q->where('id', '!=', $request->id); })
            ->first();
        if ($existingRole) {
            return redirect()->back()->withInput()->withErrors(['name' => 'Role name already exists.']);
        }
        $role = $request->id ? \Spatie\Permission\Models\Role::findOrFail($request->id) : new \Spatie\Permission\Models\Role();
        $role->name = $request->name;
        $role->guard_name = 'web';
        $role->save();
        $role->syncPermissions($request->permissions ?? []);
        return redirect()->route('roles_editor')->with('success', 'Role saved successfully.');
    }

    public function deleteRole($id)
    {
        if (!auth()->user()->hasRole('Admin')) abort(401);
        $role = \Spatie\Permission\Models\Role::findOrFail($id);
        // Prevent deleting protected roles if needed (optional)
        // if (in_array($role->name, ['Admin', 'Employee', 'Manager'])) {
        //     return redirect()->back()->withErrors(['name' => 'Cannot delete protected role.']);
        // }
        $role->delete();
        return redirect()->route('roles_editor')->with('success', 'Role deleted successfully.');
    }

    public function showForgotPasswordForm()
    {
        return view('users.forgot_password');
    }

    public function sendResetPassword(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);
        $user = User::where('email', $request->email)->first();
        $newPassword = bin2hex(random_bytes(4)); // 8-char random password
        $user->password = bcrypt($newPassword);
        $user->force_change_password = true;
        $user->save();
        try {
            Mail::to($user->email)->send(new ResetPasswordMail($user->name, $newPassword));
        } catch (\Exception $e) {
            \Log::error('Failed to send reset password email: ' . $e->getMessage());
            return back()->withErrors('Failed to send reset password email.');
        }
        return redirect()->route('login')->with('success', 'A new password has been sent to your email.');
    }

}

