<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(Request $request): JsonResponse
    {
        $perPage=$request->query('per_page',15);
        $search=$request->query('search');
        $products = $this->productService->getAllProducts((int) $perPage, $search);

        return response()->json([
            'status' => true,
            'message' => 'Products retrieved successfully',
            'data' => ProductResource::collection($products)->response()->getData(true),
        ], 200);
    }

    public function store(ProductRequest $request): JsonResponse
    {
        $product = $this->productService->store($request->validated());

        return response()->json([
            'status' => true,
            'message' => 'Product created successfully',
            'data' => new ProductResource($product),
        ], 201);
    }

    public function update(Product $product, ProductRequest $request): JsonResponse
    {
        $product = $this->productService->update($product, $request->validated());

        return response()->json([
            'status' => true,
            'message' => 'Product updated successfully',
            'data' => new ProductResource($product),
        ], 200);
    }

    public function show(Product $product): JsonResponse
    {
        $product=$product->load('category');
        return response()->json([
            'status' => true,
            'message' => 'Product retrieved successfully',
            'data' => new ProductResource($product),
        ], 200);
    }


    public function delete(Product $product): JsonResponse
    {
        $this->productService->delete($product);

        return response()->json([
            'status' => true,
            'message' => 'Product deleted successfully',
        ], 200);
    }
}
