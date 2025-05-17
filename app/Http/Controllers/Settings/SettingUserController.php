<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\UserRequest;
use App\Models\User;
use App\UserRole;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Validation\ValidationException;

class SettingUserController extends Controller
{
    public function index(Request $request): Response
    {
        return Inertia::render('settings/SettingUser', []);
    }

    public function tambah(Request $request): Response
    {
        $user = new User;

        $user->encrypted_id = Crypt::encrypt($user->id);

        $roles = collect(UserRole::cases())->map(function ($role) {
            return [
                'label' => $role->value,
                'value' => $role->value,
            ];
        });

        return Inertia::render('settings/SettingUser/TambahUser', [
            'user' => $user,
            'roles' => $roles,
        ]);
    }

    public function edit($idUser): Response
    {
        $id = Crypt::decrypt($idUser);
        $user = User::findOrFail($id);

        $user->encrypted_id = Crypt::encrypt($user->id);

        $roles = collect(UserRole::cases())->map(function ($role) {
            return [
                'label' => ucfirst($role->value),
                'value' => $role->value,
            ];
        });

        return Inertia::render('settings/SettingUser/EditUser', [
            'user' => $user,
            'roles' => $roles,
        ]);
    }

    public function datauser(Request $request)
    {
        $order = ['name', 'username', 'role'];
        $orderBy = in_array($request->input('orderBy'), $order) ? $request->input('orderBy') : 'name';
        $orderDir = $request->input('orderDirection') === 'desc' ? 'desc' : 'asc';

        $query = User::query();

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }
        if ($request->filled('username')) {
            $query->where('username', 'like', '%' . $request->input('username') . '%');
        }
        if ($request->filled('role')) {
            $query->where('role', 'like', '%' . $request->input('role') . '%');
        }

        $query->orderBy($orderBy, $orderDir);

        $users = $query->paginate($request->input('per_page', 10));

        $users->getCollection()->transform(function ($user) {
            $user->user_id = Crypt::encrypt($user->id);
            unset($user->id);
            return $user;
        });

        return response()->json($users);
    }

    public function save(UserRequest $request): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $user = new User();

            $user->name = $request->name;
            $user->email = $request->email;
            $user->role = UserRole::from($request->role);;
            $user->phone = $request->phone ?? null;
            $user->username = $request->phone ?? null; // fixed: assign username, not phone again

            if (!empty($request->password)) {
                $user->password = Hash::make($request->password);
            }
            $user->save();

            DB::commit();
        } catch (\Throwable $th) {
            dd($th);
            DB::rollBack();
            abort(500, 'Internal Server Error');
        }

        return to_route('setting-user');
    }

    public function update(UserRequest $request): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $id = Crypt::decrypt($request->id);
            $user = User::findOrFail($id);

            $user->name = $request->name;
            $user->email = $request->email;
            $user->role = $request->role;
            $user->phone = $request->phone ?? null;
            $user->username = $request->phone ?? null;

            if (!empty($request->password)) {
                $user->password = Hash::make($request->password);
            }

            $user->save();

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            abort(500, 'Internal Server Error');
        }

        return to_route('setting-user');
    }


    public function destroy($id): RedirectResponse
    {
        $user_id = Crypt::decrypt($id);
        User::whereId($user_id)->delete();

        return to_route('setting-user');
    }
}
