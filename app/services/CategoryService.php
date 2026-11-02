<?php

namespace App\services;

use App\Models\Category;
use Illuminate\Pagination\LengthAwarePaginator;

class CategoryService
{
    public function getAllCategories(int $perPage = 10, ?string $search = null):LengthAwarePaginator
    {
        return Category::query()
            ->when($search,function($q) use ($search){
                $q->where('name','like',"%{$search}%");
            })
            ->latest()
            ->paginate($perPage)
        ;
    }

    public function store(array $data):Category
    {
        return Category::create($data);
    }

    public function update(Category $category, array $data):Category
    {
        $category->update($data);
        return $category->fresh();
    }

    public function delete(Category $category):void
    {
        $category->delete();
    }

}
