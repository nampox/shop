<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class CategoryService
{
    /**
     * Get paginated categories with optional filters
     *
     * @param array $filters
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getCategories(array $filters = [], int $perPage = 20): LengthAwarePaginator
    {
        $query = Category::with(['parent', 'children', 'products']);

        // Search filter
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('slug', 'like', '%' . $search . '%');
            });
        }

        // Status filter
        if (isset($filters['is_active']) && $filters['is_active'] !== '') {
            $query->where('is_active', $filters['is_active']);
        }

        // Parent filter
        if (isset($filters['parent'])) {
            if ($filters['parent'] === 'null') {
                $query->whereNull('parent_id');
            } else {
                $query->where('parent_id', $filters['parent']);
            }
        }

        return $query->orderBy('sort_order')->orderBy('name')->paginate($perPage)->withQueryString();
    }

    /**
     * Get all categories for select (excluding current category and its descendants)
     *
     * @param int|null $excludeId
     * @return Collection
     */
    public function getCategoriesForSelect(?int $excludeId = null): Collection
    {
        $query = Category::where('is_active', true)->orderBy('sort_order')->orderBy('name');
        
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }
        
        return $query->get();
    }

    /**
     * Get category statistics
     *
     * @return array
     */
    public function getStatistics(): array
    {
        return [
            'total' => Category::count(),
            'active' => Category::where('is_active', true)->count(),
            'inactive' => Category::where('is_active', false)->count(),
            'with_parent' => Category::whereNotNull('parent_id')->count(),
            'without_parent' => Category::whereNull('parent_id')->count(),
        ];
    }

    /**
     * Get category by ID with relationships
     *
     * @param int $id
     * @return Category|null
     */
    public function getCategoryById(int $id): ?Category
    {
        return Category::with(['parent', 'children', 'products'])->find($id);
    }

    /**
     * Create a new category
     *
     * @param array $data
     * @return Category
     */
    public function createCategory(array $data): Category
    {
        return Category::create($data);
    }

    /**
     * Update category
     *
     * @param int $id
     * @param array $data
     * @return Category|null
     */
    public function updateCategory(int $id, array $data): ?Category
    {
        $category = Category::find($id);
        
        if (!$category) {
            return null;
        }

        $category->update($data);
        
        return $category->load(['parent', 'children', 'products']);
    }

    /**
     * Delete category
     *
     * @param int $id
     * @return bool
     */
    public function deleteCategory(int $id): bool
    {
        $category = Category::find($id);
        
        if (!$category) {
            return false;
        }

        return $category->delete();
    }
}

