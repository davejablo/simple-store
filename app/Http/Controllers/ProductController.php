<?php

namespace App\Http\Controllers;

use App\Http\Repositories\ProductRepository;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Product;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Contracts\Providers\Auth;

class ProductController extends Controller
{
    protected $productRepo;
    protected $auth;

    public function __construct(ProductRepository $productRepo, Auth $auth)
    {
        $this->productRepo = $productRepo;
        $this->auth = $auth;
    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return ProductResource::collection($this->productRepo->getAllCategories());
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
     * @param StoreProductRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreProductRequest $request)
    {
        $this->authorize('create',Product::class);
        $newProduct = $this->productRepo->createAndReturnProduct($request);

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'message' => 'Product added',
            'data' => [
                'item' => $newProduct
            ]
        ], 200);
    }

    /**
     * @param Product $product
     * @return ProductResource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Product $product)
    {
        $this->authorize('view',Product::class);
        return new ProductResource($this->productRepo->getProduct($product)->load('supplier', 'category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * @param UpdateProductRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateProductRequest $request, $id)
    {
        $this->authorize('update',Product::class);
        $updatedProduct = new ProductResource($this->productRepo->updateAndReturnProduct($request, $id));

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'message' => 'Product updated',
            'data' => [
                'item' => $updatedProduct,
            ]
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
