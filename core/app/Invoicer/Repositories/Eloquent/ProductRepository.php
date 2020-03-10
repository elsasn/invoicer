<?php namespace App\Invoicer\Repositories\Eloquent;

use App\Invoicer\Repositories\Contracts\ProductInterface;

class ProductRepository extends BaseRepository implements ProductInterface{

    public function model() {
        return 'App\Models\Product';
    }

    /**
     * @return array
     */

    public function productSelect(){
        $products = $this->all();

        $productList = array();
        $options[] = ['value' => '', 'display' => 'None', 'data-value' => '' ];
        foreach($products as $product){
            $option = ['value' => $product->uuid, 'display' => $product->name, 'data-value' => $product->price ];
            array_push($productList, $option);
        }
        return $productList;
    }
}