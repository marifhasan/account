<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Http\Resources\User as ResourcesUser;
use App\Models\Role;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the users list page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $params = [
            'users' => ResourcesUser::collection(User::latest()->get()),
        ];

        return Inertia::render('Manage/User/Index', $params);
    }

    /**
     * Show the user create.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create()
    {
        $params = [
            'roles' => Role::orderBy('name', 'ASC')->get(),
        ];

        return Inertia::render('Manage/User/Create', $params);
    }

    /**
     * Create new resource in storage.
     *
     * @param  Request  $request
     * @param  User  $user
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'role' => ['nullable', 'exists:roles,id'],
            'name' => ['required', 'string', 'max:191'],
            'email' => ['required', 'string', 'email', 'max:191', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'mobile' => ['nullable', 'string', 'max:191'],
            'address' => ['nullable', 'string', 'max:500'],
        ]);

        DB::beginTransaction();
        $user = new User;
        $user->role_id = $request->role;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->password = bcrypt($request->password);
        $user->save();

        $user->address = $request->address;
        $user->history = 'User Created';

        DB::commit();

        return back()->with('success', 'User created successfully.');
    }

    /**
     * Show the user detail page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function show(User $user)
    {
        $params = [
            'user' => $user,
        ];

        return Inertia::render('Manage/User/Show', $params);
    }

    /**
     * Show the user edit page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit(User $user)
    {
        $params = [
            'user' => $user,
            'roles' => Role::orderBy('name', 'ASC')->get(),
        ];

        return Inertia::render('Manage/User/Edit', $params);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  User  $user
     * @return Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'role' => ['nullable', 'exists:roles,id'],
            'name' => ['required', 'string', 'max:191'],
            'email' => ['required', 'string', 'email', 'max:191', Rule::unique('users')->ignore($user)],
            'password' => ['nullable', 'string', 'min:8'],
            'mobile' => ['nullable', 'string', 'max:191'],
            'address' => ['nullable', 'string', 'max:500'],
        ]);

        DB::beginTransaction();
        $user->role_id = $request->role;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->password = $request->password ? bcrypt($request->password) : $user->password;
        $user->update();

        $user->address = $request->address;
        $user->history = 'User Updated';

        DB::commit();

        return back()->with('success', 'User updated successfully.');
    }

    /**
     * Delete the specified resource from storage.
     *
     * @param  User  $user
     * @return Response
     */
    public function destroy(User $user)
    {
        DB::beginTransaction();
        $user->delete();

        $user->history = 'User Deleted';
        DB::commit();

        return redirect()->route('user.index')->with('success', __('User removed successfully'));
    }

    /**
     * Change status the specified resource in storage.
     *
     * @param  Request  $request
     * @param  User  $user
     * @return Response
     */
    public function updateStatus(Request $request, User $user)
    {
        if (! array_key_exists($request->status, $user->statuses)) {
            return back()->with('fail', 'Status changing request failed! Invalid status!');
        }

        DB::beginTransaction();

        $user->status = $request->status;
        $user->history = 'Status Changed to '.$user->statuses[$request->status];

        DB::commit();

        return back()->with('success', 'Status changed to "'.$user->statuses[$request->status].'" successfully');
    }
}
