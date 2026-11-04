<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\services\CategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index(Request $request): JsonResponse
    {
        $perPage = $request->query('per_page', 15);
        $search = $request->query('search');
        $categories = $this->categoryService->getAllCategories((int)$perPage, $search);

        return response()->json([
            'status' => true,
            'message' => 'Categories retrieved successfully',
            'data' => CategoryResource::collection($categories)->response()->getData(true),
        ], 200);
    }

    public function store(CategoryRequest $request):JsonResponse
    {
        $category = $this->categoryService->store($request->validated());

        return response()->json([
            'status' => true,
            'message' => 'Category created successfully',
            'data' => new CategoryResource($category),
        ], 201);
    }

    public function update(CategoryRequest $request, $id):JsonResponse
    {
        $category = $this->categoryService->update($id, $request->validated());

        return response()->json([
            'status' => true,
            'message' => 'Category updated successfully',
            'data' => new CategoryResource($category),
        ], 200);
    }

    public function delete(Category $category):JsonResponse
    {
        $this->categoryService->delete($category);
        return response()->json([
            'status' => true,
            'message' => 'Category deleted successfully',
        ], 200);
    }


}
