<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\InvoiceRequest;
use App\services\InvoiceService;
use Exception;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    protected InvoiceService $invoiceService;

    public function __construct(InvoiceService $invoiceService)
    {
        $this->invoiceService = $invoiceService;
    }

    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 15);
        $search = $request->query('search');
        return $this->invoiceService->getAllInvoices((int)$perPage, $search);
    }

    public function store(InvoiceRequest $request)
    {
        try {
            $this->invoiceService->createInvoice($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Invoice created successfully',
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
