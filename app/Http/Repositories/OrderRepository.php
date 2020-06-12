<?php

namespace App\Http\Repositories;

use App\Http\Resources\OrderResource;
use App\Order;

class OrderRepository
{
    public function getOrders($results)
    {
        return $results;
    }

    public function getAllOrders()
    {
        return null;
    }

    public function updateAndReturnOrder($request, $id){

        $orderFromDb = Order::findOrFail($id);
        $orderFromDb->update($request->validated());
        $updatedOrderFromDb = Order::findOrFail($id);

        return new OrderResource($updatedOrderFromDb);
    }

    public function destroyOrder($order){

        return null;
    }

}