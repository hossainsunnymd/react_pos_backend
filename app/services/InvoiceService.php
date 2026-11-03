<?php

namespace App\services;

use App\Models\Invoice;
use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class InvoiceService
{

  public function getAllInvoices(int $perPage = 15, ?string $search = null): LengthAwarePaginator
  {
    return Invoice::with(['customer', 'invoiceProducts.product'])
      ->when($search, function ($query) use ($search) {
        $query->where('id',$search);
        $query->whereHas('customer', function ($query) use ($search) {
          $query->where('name', 'like', "%$search%");
        });
      })
        ->latest()
      ->paginate($perPage);
  }

  public function createInvoice(array $data)
  {
    DB::transaction(function () use ($data) {
      $invoice = Invoice::create([
        'customer_id' => $data['customer_id'],
        'total' => $data['total'],
        'discount' => $data['discount'],
        'vat' => $data['vat'],
        'payable' => $data['payable'],

      ]);

      foreach ($data['products'] as $product) {
        $invoice->invoiceProducts()->create([
          'product_id' => $product['product_id'],
          'qty' => $product['qty'],
          'sale_price' => $product['sale_price'],
        ]);
        Product::find($product['product_id'])->decrement('qty', $product['qty']);
      }
    });
  }
}
