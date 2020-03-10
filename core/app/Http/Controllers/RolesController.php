<?php

namespace App\Http\Controllers;
use App\Http\Requests\RoleFormRequest;
use App\Invoicer\Repositories\Contracts\RoleInterface as Role;
use App\Invoicer\Repositories\Contracts\PermissionInterface as Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Laracasts\Flash\Flash;

class RolesController extends Controller{
    private $role, $permission;

    public function __construct(Role $role, Permission $permission){
        $this->middleware('permission:edit_setting');
        $this->role = $role;
        $this->permission = $permission;
    }

    public function index(){
        $roles = $this->role->all();
        return view('settings.roles.index', compact('roles'));
    }

    public function store(RoleFormRequest $request){
        $role_details = ['name'=>$request->get('name'), 'description'=>$request->get('description')];
        if($this->role->create($role_details))
            Flash::success(trans('application.record_created'));
        else
            Flash::error(trans('application.create_failed'));

        return redirect('settings/roles');
    }

    public function edit($id){
        $role = $this->role->getById($id);
        return view('settings.roles.edit', compact('role'));
    }

    public function update(RoleFormRequest $request, $id)
    {
        $role = ['name' => $request->get('name'), 'description' => $request->get('description')];
        if($this->role->updateById($id, $role)){
            Flash::success(trans('application.record_updated'));
            return Response::json(array('success' => true, 'msg' => trans('application.record_updated')), 200);
        }
        return Response::json(array('success' => false, 'msg' => trans('application.record_update_failed')), 400);
    }

    public function show($id){
        $role = $this->role->getById($id);
        $permissions = $this->permission->all();
        return view('settings.roles.permissions', compact('role','permissions'));
    }

    public function assignPermission(Request $request){
        $role = $this->role->getById($request->input('role_id'));
        $permissions = $this->permission->all();
        $selected_permissions = array();
        foreach($permissions as $permission){
            if($request->has($permission->name)){
                $selected_permissions[] = $permission->uuid;
            }
        }
        if($role->assign($selected_permissions)){
            Flash::success(trans('application.record_updated'));
            return Response::json(array('success' => true, 'msg' => trans('application.record_updated')), 200);
        }
    }

    public function destroy($id)
    {
        if($this->role->deleteById($id)){
            Flash::success(trans('application.record_deleted'));
        }
        else {
            Flash::error(trans('application.record_deletion_failed'));
        }
        return redirect('settings/roles');
    }
}
