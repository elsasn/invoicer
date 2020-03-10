<?php namespace App\Invoicer\Repositories\Eloquent;
use App\Invoicer\Repositories\Contracts\ExpenseCategoryInterface;
class ExpenseCategoryRepository extends BaseRepository implements ExpenseCategoryInterface{
    public function model() {
        return 'App\Models\ExpenseCategory';
    }
    public function categorySelect(){
        $categories = $this->all();
        $categoryList = array();
        foreach($categories as $category)
        {
            $categoryList[$category->uuid] = $category->name;
        }
        return $categoryList;
    }
}