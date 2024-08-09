<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateRoleRequest;
use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    public function fetch (Request $request)
    {
        $id = $request->input('id');
        $name = $request->input('name');
        $limit = $request->input('limit', 8);

        // * /api/role?id=1 *
        if($id) {
            $role = Role::find($id);

            if($role) {
                return ResponseFormatter::success($role);
            }

            return ResponseFormatter::error('Role Not Found', 404);
        }

        $roles = Role::with(['user']);

        // * /api/role?name=Admin *
        if($name) {
            $roles->where('name', 'like', '%' . $name . '%');
        }

        return ResponseFormatter::success($roles->paginate($limit));
    }

    public function create(CreateRoleRequest $request)
    {
        try {
            // create role
            $role = Role::create([
                'name' => $request->name,
            ]);

            if(!$role) {
                throw new Exception('Role Not Created');
            }

            return ResponseFormatter::success($role, 'Role Created');
        } catch (Exception $e) {
            return ResponseFormatter::error('Failed Create Role', 500);
        }
    }

    public function update(CreateRoleRequest $request, $id)
    {
        try {
            // find role id
            $role = Role::find($id);

            if(!$role) {
                throw new Exception('Role Not Found');
            }

            // update role
            $role->update([
                'name' => $request->name,
            ]);

            return ResponseFormatter::success($role, 'Role Updated');
        } catch (Exception $e) {
            return ResponseFormatter::error('Failed Update role', 500);
        }
    }

    public function destroy($id)
    {
        try {
            // get role
            $role = Role::find($id);

            if(!$role) {
                throw New Exception('Role Not Found');
            }

            // delete role
            $role->delete();

            return ResponseFormatter::success('Role Deleted');
        }
        catch (Exception $e) {
            return ResponseFormatter::error('Failed Delet Role', 500);
        }
    }
}
