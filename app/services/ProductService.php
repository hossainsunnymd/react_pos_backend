<?php

namespace App\services;

use App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;

class ProductService
{
    public function getAllProducts(int $perPage = 15, ?string $search = null): LengthAwarePaginator
    {
        return Product::query()
            ->with('category')
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhereHas('category', function ($query) use ($search) {
                        $query->where('name', 'like', "%{$search}%");
                    });
            })
            ->latest()
            ->paginate($perPage);
    }

    public function store(array $data): Product
    {
        if (isset($data['image'])) {
            $file = $data['image'];
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('images', $fileName);
            $data['image'] = $fileName;
        }

        return Product::create($data);
    }

    public function update(Product $product, array $data): Product
    {
        if (isset($data['image'])) {
            if ($product->image) {
                Storage::delete('images/' . $product->image);
            }

            $file = $data['image'];
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('images', $fileName);
            $data['image'] = $fileName;
        }

        $product->update($data);

        return $product;
    }

    public function delete(Product $product): void
    {
        if ($product->image) {
            Storage::delete('images/' . $product->image);
        }

        $product->delete();
    }

}
