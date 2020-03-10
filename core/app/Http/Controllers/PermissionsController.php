<?php

namespace App\Http\Controllers;

use App\Http\Requests\PermissionFormRequest;
use App\Invoicer\Repositories\Contracts\PermissionInterface as Permission;
use Illuminate\Support\Facades\Response;
use Laracasts\Flash\Flash;

use App\Http\Requests;

class PermissionsController extends Controller
{
    private $permission;

    public function __construct(Permission $permission){
        $this->middleware('permission:edit_setting');
        $this->permission = $permission;
    }

    public function index(){
        $permissions = $this->permission->all();
        return view('settings.permissions.index', compact('permissions'));
    }

    public function store(PermissionFormRequest $request){
        $permission_details = ['name'=>$request->get('name'), 'description'=>$request->get('description')];
        if($this->permission->create($permission_details))
            Flash::success(trans('application.record_created'));
        else
            Flash::error(trans('application.create_failed'));
        return redirect('settings/permissions');
    }

    public function edit($id){
        $permission = $this->permission->getById($id);
        return view('settings.permissions.edit', compact('permission'));
    }

    public function update(PermissionFormRequest $request, $id)
    {
        $permission = ['description' => $request->get('description')];
        if($this->permission->updateById($id, $permission)){
            Flash::success(trans('application.record_updated'));
            return Response::json(array('success' => true, 'msg' => trans('application.record_updated')), 200);
        }
        return Response::json(array('success' => false, 'msg' => trans('application.record_update_failed')), 400);
    }
    public function destroy($id)
    {
        if($this->permission->deleteById($id)){
            flash()->success('permission Record Deleted  ');
            return redirect('settings/permissions');
        }

    }
}
