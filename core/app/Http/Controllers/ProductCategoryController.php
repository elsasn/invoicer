<?php
namespace App\Http\Controllers;
use App\Http\Requests\ProductCategoryRequest;
use App\Invoicer\Repositories\Contracts\ProductCategoryInterface as Category;
use Illuminate\Support\Facades\Response;
use Laracasts\Flash\Flash;

class ProductCategoryController extends Controller
{
    private $category;
    public function __construct(Category $category){
        $this->category = $category;
    }
    public function index()
    {
        $categories = $this->category->all();
        return view('products.categories.index', compact('categories'));
    }
    public function create()
    {
        return view('products.categories.create');
    }
    public function store(ProductCategoryRequest $request)
    {
        $data = array(
            'name' => $request->get('name')
        );
        if($this->category->create($data)){
            Flash::success(trans('application.record_created'));
            return Response::json(array('success'=>true, 'msg' => trans('application.record_created')), 200);
        }
        return Response::json(array('success'=>false, 'msg' => trans('application.record_creation_failed')), 422);
    }
    public function edit($id)
    {
        $category = $this->category->getById($id);
        return view('products.categories.edit', compact('category'));
    }
    public function update(ProductCategoryRequest $request, $id)
    {
        $data = array(
            'name' => $request->get('name')
        );
        if($this->category->updateById($id,$data)){
            Flash::success(trans('application.record_updated'));
            return Response::json(array('success'=>true, 'msg' => trans('application.record_updated')), 200);
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
        return redirect('product_category');
    }
}
