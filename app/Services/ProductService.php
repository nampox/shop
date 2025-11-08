<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class ProductService
{
    /**
     * Get paginated products with optional filters
     *
     * @param array $filters
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getProducts(array $filters = [], int $perPage = 20): LengthAwarePaginator
    {
        $query = Product::with(['categories', 'images', 'variants', 'inventory']);

        // Search filter
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('slug', 'like', '%' . $search . '%');
            });
        }

        // Status filter - support multiple statuses
        if (!empty($filters['status']) && is_array($filters['status'])) {
            $statuses = array_filter($filters['status']); // Remove empty values
            if (!empty($statuses)) {
                $query->whereIn('status', $statuses);
            }
        } elseif (!empty($filters['status'])) {
            // Support single status for backward compatibility
            $query->where('status', $filters['status']);
        }

        // Category filter - support multiple categories
        if (!empty($filters['categories']) && is_array($filters['categories'])) {
            $categoryIds = array_filter($filters['categories']); // Remove empty values
            if (!empty($categoryIds)) {
                $query->whereHas('categories', function($q) use ($categoryIds) {
                    $q->whereIn('categories.id', $categoryIds);
                });
            }
        }

        return $query->latest()->paginate($perPage)->withQueryString();
    }

    /**
     * Get all active categories
     *
     * @return Collection
     */
    public function getActiveCategories(): Collection
    {
        return Category::where('is_active', true)->get();
    }

    /**
     * Get all products for autocomplete search
     *
     * @return Collection
     */
    public function getAllProductsForSearch(): Collection
    {
        return Product::select('id', 'name', 'slug')
            ->orderBy('name')
            ->get();
    }

    /**
     * Get product statistics
     *
     * @return array
     */
    public function getStatistics(): array
    {
        return [
            'total' => Product::count(),
            'active' => Product::where('status', 'active')->count(),
            'draft' => Product::where('status', 'draft')->count(),
            'inactive' => Product::where('status', 'inactive')->count(),
            'archived' => Product::where('status', 'archived')->count(),
        ];
    }

    /**
     * Get product by ID with relationships
     *
     * @param int $id
     * @return Product|null
     */
    public function getProductById(int $id): ?Product
    {
        return Product::with(['categories', 'images', 'variants', 'inventory'])->find($id);
    }

    /**
     * Create a new product
     *
     * @param array $data
     * @param array|null $categoryIds
     * @return Product
     */
    public function createProduct(array $data, ?array $categoryIds = null): Product
    {
        $product = Product::create($data);

        if ($categoryIds) {
            $product->categories()->attach($categoryIds);
        }

        return $product->load(['categories', 'images', 'variants', 'inventory']);
    }

    /**
     * Update product
     *
     * @param int $id
     * @param array $data
     * @return Product|null
     */
    public function updateProduct(int $id, array $data): ?Product
    {
        $product = Product::find($id);
        
        if (!$product) {
            return null;
        }

        $product->update($data);
        
        return $product->load(['categories', 'images', 'variants', 'inventory']);
    }

    /**
     * Update product categories
     *
     * @param int $id
     * @param array $categoryIds
     * @return Product|null
     */
    public function updateProductCategories(int $id, array $categoryIds): ?Product
    {
        $product = Product::find($id);
        
        if (!$product) {
            return null;
        }

        $product->categories()->sync($categoryIds);
        
        return $product->load(['categories', 'images', 'variants', 'inventory']);
    }

    /**
     * Delete product
     *
     * @param int $id
     * @return bool
     */
    public function deleteProduct(int $id): bool
    {
        $product = Product::find($id);
        
        if (!$product) {
            return false;
        }

        return $product->delete();
    }
}

