<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRequest;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use App\services\CustomerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    protected CustomerService $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }


    public function index(Request $request): JsonResponse
    {
        $perPage = $request->query('per_page', 15);
        $search = $request->query('search');
        $customers = $this->customerService->getAllCustomers((int)$perPage, $search);

        return response()->json([
            'status' => true,
            'message' => 'Customers retrieved successfully',
            'data' => CustomerResource::collection($customers)->response()->getData(true),
        ], 200);
    }

    public function store(Request $request): JsonResponse
    {
        $customer = $this->customerService->store($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Customer created successfully',
            'data' => new CustomerResource($customer),
        ], 201);
    }

    public function show(Customer $customer): JsonResponse{
        return response()->json([
            'status' => true,
            'message' => 'Customer retrieved successfully',
            'data' => new CustomerResource($customer),
        ], 200);
    }

    public function update(Customer $customer, CustomerRequest $request): JsonResponse
    {
        $customer = $this->customerService->update($customer, $request->validated());

        return response()->json([
            'status' => true,
            'message' => 'Customer updated successfully',
            'data' => new CustomerResource($customer),
        ], 200);
    }

    public function delete(Customer $customer): JsonResponse
    {
        $this->customerService->delete($customer);

        return response()->json([
            'status' => true,
            'message' => 'Customer deleted successfully',
        ], 200);
    }
}
