<?php

namespace App\Http\Controllers;

use App\Http\Repositories\SupplierRepository;
use App\Http\Requests\Supplier\StoreSupplierRequest;
use App\Http\Requests\Supplier\UpdateSupplierRequest;
use App\Http\Resources\SupplierResource;
use App\Supplier;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Contracts\Providers\Auth;

class SupplierController extends Controller
{
    protected $supplierRepo;
    protected $auth;

    public function __construct(SupplierRepository $supplierRepo, Auth $auth)
    {
        $this->supplierRepo = $supplierRepo;
        $this->auth = $auth;
    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return SupplierResource::collection($this->supplierRepo->getAllSuppliers());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSupplierRequest $request)
    {
//        $authUser = $this->auth->user();
//        $this->authorize('create', $authUser, Project::class);
        $newSupplier = $this->supplierRepo->createAndReturnSupplier($request);

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'message' => 'Supplier added',
            'data' => [
                'item' => $newSupplier
            ]
        ], 200);
    }

    /**
     * @param Supplier $supplier
     * @return SupplierResource
     */
    public function show(Supplier $supplier)
    {
        //        $authUser = $this->auth->user();
        //        $this->authorize('view', $category, Project::class);
        return new SupplierResource($this->supplierRepo->getSupplier($supplier));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * @param UpdateSupplierRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateSupplierRequest $request, $id)
    {
//        $authUser = $this->auth->user();
//        $this->authorize('update', $authUser->project, Project::class);
        $updatedSupplier = new SupplierResource($this->supplierRepo->updateAndReturnSupplier($request, $id));

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'message' => 'Supplier updated',
            'data' => [
                'item' => $updatedSupplier,
            ]
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
