<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Repositories\CategoryRepository;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Contracts\Providers\Auth;

class CategoryController extends Controller
{
    protected $categoryRepo;
    protected $auth;

    public function __construct(CategoryRepository $categoryRepo, Auth $auth)
    {
        $this->categoryRepo = $categoryRepo;
        $this->auth = $auth;
    }

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return CategoryResource::collection($this->categoryRepo->getAllCategories());
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
    public function store(StoreCategoryRequest $request)
    {
//        $authUser = $this->auth->user();
//        $this->authorize('create', $authUser, Project::class);
        $newCategory = $this->categoryRepo->createAndReturnCategory($request);

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'message' => 'Category added',
            'data' => [
                'item' => $newCategory
            ]
        ], 200);
    }

    /**
     * @param Category $category
     * @return CategoryResource
     */
    public function show(Category $category)
    {
//        $authUser = $this->auth->user();
//        $this->authorize('view', $category, Project::class);
        return new CategoryResource($this->categoryRepo->getCategory($category));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request, $id)
    {
//        $authUser = $this->auth->user();
//        $this->authorize('update', $authUser->project, Project::class);
        $updatedCategory = new CategoryResource($this->categoryRepo->updateAndReturnCategory($request, $id));

        return response()->json([
            'code' => 200,
            'status' => 'success',
            'message' => 'Category updated',
            'data' => [
                'item' => $updatedCategory,
            ]
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
    }
}
