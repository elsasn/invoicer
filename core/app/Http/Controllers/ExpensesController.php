<?php namespace App\Http\Controllers;
use App\Http\Requests\ExpenseFormRequest;
use App\Invoicer\Repositories\Contracts\ExpenseInterface as Expense;
use App\Invoicer\Repositories\Contracts\ExpenseCategoryInterface as Category;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Laracasts\Flash\Flash;
use Yajra\Datatables\Facades\Datatables;
use App\Invoicer\Repositories\Contracts\CurrencyInterface as Currency;

class ExpensesController extends Controller {
    private $expense,$category,$currency;
    public function __construct(Expense $expense,Category $category,Currency $currency){
        $this->expense = $expense;
        $this->category = $category;
        $this->currency  = $currency;
    }
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        if (Request::ajax()){
            $model = $this->expense->model();
            $expenses = $model::with('category')->select('uuid','name','category_id','expense_date','amount','currency')->ordered();
            return Datatables::of($expenses)
                ->editColumn('expense_date', function($data){ return format_date($data->expense_date); })
                ->editColumn('category', function($data){ return $data->category ? $data->category->name : ''; })
                ->editColumn('amount', function($data){ return $data->currency.' '.format_amount($data->amount); })
                ->addColumn('action', '
                      @if(hasPermission(\'edit_expense\')){!! edit_btn(\'expenses.edit\', $uuid) !!}@endif
                      @if(hasPermission(\'delete_expense\')){!! delete_btn(\'expenses.destroy\', $uuid) !!}@endif
                ')->make(true);
        }else {
            return view('expenses.index');
        }
	}
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        if(!hasPermission('add_expense', true)) return redirect('expenses');
        $categories = $this->category->categorySelect();
        $currencies = $this->currency->currencySelect();
        $default_currency = $this->currency->defaultCurrency();
		return view('expenses.create',compact('categories','currencies','default_currency'));
	}
    /**
     * Store a newly created resource in storage.
     * @param ExpenseFormRequest $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function store(ExpenseFormRequest $request)
	{
        if($this->expense->create($request->all())){
            Flash::success(trans('application.record_created'));
            return Response::json(array('success'=>true, 'msg' => trans('application.record_created')), 201);
        }
        return Response::json(array('success'=>false, 'msg' => trans('application.record_creation_failed')), 422);
	}
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        if(!hasPermission('edit_expense', true)) return redirect('expenses');
        $expense = $this->expense->getById($id);
        $categories = $this->category->categorySelect();
        $currencies = $this->currency->currencySelect();
        $default_currency = $this->currency->defaultCurrency();
        return view('expenses.edit', compact('expense','categories','currencies','default_currency'));
	}
    /**
     *  Update the specified resource in storage.
     * @param ExpenseFormRequest $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function update(ExpenseFormRequest $request, $id)
	{
        if($this->expense->updateById($id,$request->all())){
            Flash::success(trans('application.record_updated'));
            return Response::json(array('success'=>true, 'msg' => trans('application.record_updated')), 201);
        }
        return Response::json(array('success'=>false, 'msg' => trans('application.record_update_failed')), 422);
	}
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        if(!hasPermission('delete_expense', true)) return redirect('expenses');
        if($this->expense->deleteById($id))
            Flash::success(trans('application.record_deleted'));
        else
            Flash::error(trans('application.record_deletion_failed'));
        return redirect('expenses');
	}
}
