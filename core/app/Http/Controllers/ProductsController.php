<?php namespace App\Http\Controllers;
use App\Http\Requests\ProductFormRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Request;
use App\Invoicer\Repositories\Contracts\ProductInterface as Product;
use App\Invoicer\Repositories\Contracts\ProductCategoryInterface as Category;
use Illuminate\Support\Facades\Response;
use Intervention\Image\Facades\Image;
use Laracasts\Flash\Flash;
use Yajra\Datatables\Facades\Datatables;

class ProductsController extends Controller {
    private $product,$category;
    public function __construct(Product $product,Category $category){
        $this->product = $product;
        $this->category = $category;
    }
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        if (Request::ajax()){
            $model = $this->product->model();
            $payments = $model::with('category')->select('uuid','name','category_id','code','image','price')->ordered();
            return Datatables::of($payments)
                ->editColumn('category', function($data){ return $data->category ? $data->category->name : ''; })
                ->editColumn('amount', function($data){ return format_amount($data->amount); })
                ->editColumn('image',
                    '@if($image != \'\')
                        <a href="#" data-toggle="popover" data-trigger="hover" title="{{ $name }}" data-html="true" data-content="{{HTML::image(asset(\'assets/img/uploads/product_images/\'.$image), \'image\') }}">{!! HTML::image(asset(\'assets/img/uploads/product_images/\'.$image), \'image\', array(\'style\'=>\'width:50px\')) !!}</a>
                    @else
                        {!! HTML::image(asset(\'assets/img/uploads/product_images/no-product-image.png\'), \'image\', array(\'style\'=>\'width:50px\')) !!}
                    @endif')
                ->addColumn('action', '
                      @if(hasPermission(\'edit_product\')){!! edit_btn(\'products.edit\', $uuid) !!}@endif
                      @if(hasPermission(\'delete_product\')){!! delete_btn(\'products.destroy\', $uuid) !!}@endif
                ')->make(true);
        }else {
            return view('products.index');
        }
	}
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        if(!hasPermission('add_product', true)) return redirect('products');
        $categories = $this->category->categorySelect();
		return view('products.create',compact('categories'));
	}
    /**
     * Store a newly created resource in storage.
     * @param ProductFormRequest $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function store(ProductFormRequest $request)
	{
        $data = array(
                    'code'      => Request::get('code'),
                    'name'      => Request::get('name'),
                    'category_id'  => Request::get('category_id'),
                    'description'=> Request::get('description'),
                    'price'      => Request::get('price'),
        );
        if ($request->hasFile('product_image')){
            $file = $request->file('product_image');
            $filename = strtolower(str_random(50) . '.' . $file->getClientOriginalExtension());
            $file->move('assets/img/uploads/product_images', $filename);
            $canvas = Image::canvas(245, 245);
            $image = Image::make(sprintf('assets/img/uploads/product_images/%s', $filename))->resize(245, 245,
                function($constraint) {
                    $constraint->aspectRatio();
                });
            $canvas->insert($image, 'center');
            $canvas->save(sprintf('assets/img/uploads/product_images/%s', $filename));
            $data['image']= $filename;
        }

		if($this->product->create($data)){
            Flash::success(trans('application.record_created'));
            return Response::json(array('success'=>true, 'msg' => trans('application.record_created')), 201);
        }
        return Response::json(array('success'=>false, 'msg' => trans('application.record_creation_failed')), 422);
	}
	/**
	 * Show the form for editing the specified resource.
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        if(!hasPermission('edit_product', true)) return redirect('products');
        $product = $this->product->getById($id);
        $categories = $this->category->categorySelect();
		return view('products.edit', compact('product','categories'));
	}
    /**
     * Update the specified resource in storage.
     * @param ProductFormRequest $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function update(ProductFormRequest $request, $id)
	{
        $product = $this->product->getById($id);
        $data = array(
            'code'      => Request::get('code'),
            'name'      => Request::get('name'),
            'category_id'  => Request::get('category_id'),
            'description'=> Request::get('description'),
            'price'      => Request::get('price'),
        );
        if ($request->hasFile('product_image')){
            $file = $request->file('product_image');
            $filename = strtolower(str_random(50) . '.' . $file->getClientOriginalExtension());
            $file->move('assets/img/uploads/product_images', $filename);
            $canvas = Image::canvas(245, 245);
            $image = Image::make(sprintf('assets/img/uploads/product_images/%s', $filename))->resize(245, 245,
                function($constraint) {
                    $constraint->aspectRatio();
                });
            $canvas->insert($image, 'center');
            $canvas->save(sprintf('assets/img/uploads/product_images/%s', $filename));
            File::delete('assets/img/uploads/product_images/'.$product->image);
            $data['image']= $filename;
        }
		if($this->product->updateById($id,$data)){
            Flash::success(trans('application.record_updated'));
            return Response::json(array('success'=>true, 'msg' => trans('application.record_updated')), 201);
        }
        return Response::json(array('success'=>false, 'msg' =>  trans('application.record_update_failed')), 422);
	}
	/**
	 * Remove the specified resource from storage.
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        if(!hasPermission('delete_product', true)) return redirect('products');
		if($this->product->deleteById($id))
            Flash::success(trans('application.record_deleted'));
        else
            Flash::error(trans('application.record_deletion_failed'));

        return redirect('products');
	}
    /**
     * @return \Illuminate\View\View
     */
    public function products_modal(){
        $products = $this->product->all();
        return view('products.products_modal', compact('products'));
    }
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function process_products_selections(){
        $selected = \Request::get('products_lookup_ids');
        $products = $this->product->whereIn('uuid', $selected)->get();
        return Response::json(array('success'=>true, 'products' => $products), 200);
    }
}
