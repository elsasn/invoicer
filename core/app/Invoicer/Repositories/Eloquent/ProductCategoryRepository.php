<?php namespace App\Invoicer\Repositories\Eloquent;
use App\Invoicer\Repositories\Contracts\ProductCategoryInterface;
class ProductCategoryRepository extends BaseRepository implements ProductCategoryInterface{
    public function model() {
        return 'App\Models\ProductCategory';
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