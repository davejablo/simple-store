<?php


namespace App\Http\Repositories;


use App\Category;
use App\Http\Resources\CategoryResource;

class CategoryRepository
{
    public function createAndReturnCategory($request){
        $category = Category::create($request->validated());
        if ($category->save()){
            return new CategoryResource($category);
        }
    }

    public function getAllCategories(){
        return $categories = Category::paginate(5);
    }

    public function getCategory($category){
        return $categoryToReturn = Category::findOrFail($category->id);
    }

    public function updateAndReturnCategory($request, $id){

        $categoryFromDb = Category::findOrFail($id);
        $categoryFromDb->update($request->validated());
        $updatedCategoryFromDb = Category::findOrFail($id);

        return new CategoryResource($updatedCategoryFromDb);
    }
}