<?php


namespace App\Http\Repositories;


use App\Http\Resources\ProductResource;
use App\Product;

class ProductRepository
{
    public function createAndReturnProduct($request){
        $product = Product::create($request->validated());
        if ($product->save()){
            return new ProductResource($product);
        }
    }

    public function getAllCategories(){
        return $categories = Product::paginate(5);
    }

    public function getProduct($product){
        return $productToReturn = Product::findOrFail($product->id);
    }

    public function updateAndReturnProduct($request, $id){

        $productFromDb = Product::findOrFail($id);
        $productFromDb->update($request->validated());
        $updatedProductFromDb = Product::findOrFail($id);

        return new ProductResource($updatedProductFromDb);
    }
}