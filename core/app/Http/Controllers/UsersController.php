<?php namespace App\Http\Controllers;
use App\Http\Requests\UserFormRequest;
use App\Invoicer\Repositories\Contracts\UserInterface as User;
use App\Invoicer\Repositories\Contracts\RoleInterface as Role;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Laracasts\Flash\Flash;
use Yajra\Datatables\Facades\Datatables;

class UsersController extends Controller {
    private $user, $role;
    public function __construct(User $user, Role $role){
        $this->user = $user;
        $this->role = $role;
    }
	/**
	 * Display a listing of the resource.
	 * @return Response
	 */
	public function index()
	{
        if (Request::ajax()){
            $model = $this->user->model();
            $users = $model::with('role')->select('name','username','email','photo','phone','role_id','uuid')->ordered();
            return Datatables::of($users)
                ->editColumn('photo', '<img src="{{ asset($photo != "" ? "assets/img/uploads/".$photo : "assets/img/uploads/no-image.jpg" ) }}" class="img-circle" width="36px"/>')
                ->addColumn('role', function($data){ return $data->role->name; })
                ->addColumn('action', '
                      @if(hasPermission("edit_user")){!! edit_btn("users.edit", $uuid) !!}@endif
                        @if(auth()->guard("admin")->user()->uuid != $uuid)@if(hasPermission("delete_user")){!! delete_btn("users.destroy", $uuid) !!}@endif
                      @endif
                ')->make(true);
        }else {
            return view('users.index');
        }
	}
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(){
        if(!hasPermission('add_user', true)) return redirect('users');
        $roles = $this->role->all();
        $roles_select = array();
        foreach($roles as $role){
            $roles_select[$role->uuid] = $role->name;
        }
		return view('users.create', compact('roles_select'));
	}
    /**
     * Store a newly created resource in storage.
     * @param UserFormRequest $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function store(UserFormRequest $request)
	{
        $data = array('username' => $request->username,
                      'name' => $request->name,
                      'email' => $request->email,
                      'phone' => $request->phone,
                      'role_id' => $request->role_id,
                      'password' => bcrypt($request->password)
        );
        $user = $this->user->create($data);
        if($user){
            Flash::success(trans('application.record_created'));
            return Response::json(array('success' => true, 'msg' => trans('application.record_created')), 201);
        }
        return Response::json(array('success' => false, 'msg' => trans('application.create_failed')), 400);
	}
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        if(!hasPermission('edit_user', true)) return redirect('users');
        $roles = $this->role->all();
        $roles_select = array();
        foreach($roles as $role){
            $roles_select[$role->uuid] = $role->name;
        }
		$user = $this->user->getById($id);
        return view('users.edit', compact('user','roles_select'));
	}
    /**
     * Update the specified resource in storage.
     * @param UserFormRequest $request
     * @param $uuid
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function update(UserFormRequest $request, $uuid)
	{
        $data = array('username' => $request->username,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role_id' => $request->role_id
        );
        if($request->password != ''){
            $data['password'] = bcrypt($request->password);
        }
        if($this->user->updateById($uuid, $data)){
            Flash::success('User details updated ');
            return Response::json(array('success' => true, 'msg' => trans('application.record_updated')), 200);
        }
        return Response::json(array('success' => false, 'msg' => trans('application.record_update_failed')), 411);
	}
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        if(!hasPermission('delete_user', true)) return redirect('users');
        $user = $this->user->getById($id);
        if($this->user->deleteById($id)){
            \File::delete(public_path().'/assets/img/uploads/'.$user->photo);
        }
        flash()->success('User Record Deleted  ');
        return redirect('users');
	}
}
