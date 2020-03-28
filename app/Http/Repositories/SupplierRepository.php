<?php


namespace App\Http\Repositories;


use App\Http\Resources\SupplierResource;
use App\Supplier;

class SupplierRepository
{
    public function createAndReturnSupplier($request){
        $supplier = Supplier::create($request->validated());
        if ($supplier->save()){
            return new SupplierResource($supplier);
        }
    }

    public function getAllSuppliers(){
        return $suppliers = Supplier::paginate(5);
    }

    public function getSupplier($supplier){
        return $supplierToReturn = Supplier::findOrFail($supplier->id);
    }

    public function updateAndReturnSupplier($request, $id){

        $supplierFromDb = Supplier::findOrFail($id);
        $supplierFromDb->update($request->validated());
        $updatedProjectFromDb = Supplier::findOrFail($id);

        return new SupplierResource($updatedProjectFromDb);
    }
}