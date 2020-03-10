<?php

namespace App\Http\Controllers;
use App\Invoicer\Repositories\Contracts\ExpenseCategoryInterface as Category;
use App\Http\Requests\ExpenseCategoryRequest;
use Illuminate\Support\Facades\Response;
use Laracasts\Flash\Flash;

class ExpenseCategoryController extends Controller
{
    private $category;
    public function __construct(Category $category){
        $this->category = $category;
    }
    public function index()
    {
        $categories = $this->category->all();
        return view('expenses.categories.index', compact('categories'));
    }
    public function create()
    {
        return view('expenses.categories.create');
    }
    public function store(ExpenseCategoryRequest $request)
    {
        $data = array(
            'name' => $request->get('name')
        );
        if($this->category->create($data)){
            Flash::success(trans('application.record_created'));
            return Response::json(array('success'=>true, 'msg' => trans('application.record_created')), 201);
        }
        return Response::json(array('success'=>false, 'msg' => trans('application.record_creation_failed')), 422);
    }
    public function edit($id)
    {
        $category = $this->category->getById($id);
        return view('expenses.categories.edit', compact('category'));
    }
    public function update(ExpenseCategoryRequest $request, $id)
    {
        $data = array(
            'name' => $request->get('name')
        );
        if($this->category->updateById($id,$data)){
            Flash::success(trans('application.record_updated'));
            return Response::json(array('success'=>true, 'msg' => trans('application.record_updated')), 201);
        }
        return Response::json(array('success'=>false, 'msg' =>  trans('application.record_update_failed')), 422);
    }
    public function destroy($id)
    {
        if($this->category->deleteById($id)){
            Flash::success(trans('application.record_deleted'));
        }
        else {
            Flash::error(trans('application.record_deletion_failed'));
        }
        return redirect('expense_category');
    }
}
