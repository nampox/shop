<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Services\ProductService;
use App\Services\DashboardService;
use App\Services\CategoryService;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\StoreCategoryRequest;
use App\Helpers\ResponseHelper;
use App\Constants\Message;
use App\Constants\HttpStatusCode;

class CmsController extends Controller
{
    protected UserService $userService;
    protected ProductService $productService;
    protected DashboardService $dashboardService;
    protected CategoryService $categoryService;

    public function __construct(
        UserService $userService, 
        ProductService $productService,
        DashboardService $dashboardService,
        CategoryService $categoryService
    ) {
        $this->userService = $userService;
        $this->productService = $productService;
        $this->dashboardService = $dashboardService;
        $this->categoryService = $categoryService;
    }

    /**
     * Display the CMS dashboard
     */
    public function dashboard()
    {
        $stats = $this->dashboardService->getStatistics();

        return view('cms.dashboard', compact('stats'));
    }

    /**
     * Display products management page
     */
    public function products(Request $request)
    {
        $filters = [
            'search' => $request->input('search'),
            'status' => $request->input('status'),
            'category' => $request->input('category'),
        ];

        $products = $this->productService->getProducts($filters, 20);
        $categories = $this->productService->getActiveCategories();
        
        return view('cms.products', compact('products', 'categories'));
    }

    /**
     * Store a new product
     */
    public function storeProduct(StoreProductRequest $request)
    {
        try {
            $validated = $request->validated();
            $categoryIds = $request->input('category_ids', []);
            
            $productData = [
                'name' => $validated['name'],
                'slug' => $validated['slug'],
                'description' => $validated['description'] ?? null,
                'short_description' => $validated['short_description'] ?? null,
                'base_price' => $validated['base_price'],
                'status' => $validated['status'],
                'sort_order' => $validated['sort_order'] ?? 0,
            ];

            $product = $this->productService->createProduct($productData, $categoryIds);

            if ($request->expectsJson()) {
                return ResponseHelper::success(
                    ['product' => $product],
                    'Đã tạo sản phẩm thành công!',
                    HttpStatusCode::CREATED
                );
            }

            return ResponseHelper::redirectWithMessage('cms.products', 'Đã tạo sản phẩm thành công!');
        } catch (\Exception $e) {
            return $this->handleException($e, $request, Message::ERROR);
        }
    }

    /**
     * Show product details
     */
    public function showProduct(int $id)
    {
        try {
            $product = $this->productService->getProductById($id);

            if (!$product) {
                return ResponseHelper::error(
                    'Không tìm thấy sản phẩm',
                    null,
                    HttpStatusCode::NOT_FOUND
                );
            }

            return ResponseHelper::success(
                ['product' => $product],
                'Lấy thông tin sản phẩm thành công!'
            );
        } catch (\Exception $e) {
            return ResponseHelper::error(
                'Có lỗi xảy ra khi lấy thông tin sản phẩm',
                null,
                HttpStatusCode::INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Display categories management page
     */
    public function categories(Request $request)
    {
        $filters = [
            'search' => $request->input('search'),
            'is_active' => $request->input('is_active'),
            'parent' => $request->input('parent'),
        ];

        $categories = $this->categoryService->getCategories($filters, 20);
        $parentCategories = $this->categoryService->getCategoriesForSelect();
        $stats = $this->categoryService->getStatistics();
        
        return view('cms.categories', compact('categories', 'parentCategories', 'stats'));
    }

    /**
     * Store a new category
     */
    public function storeCategory(StoreCategoryRequest $request)
    {
        try {
            $validated = $request->validated();
            
            $categoryData = [
                'name' => $validated['name'],
                'slug' => $validated['slug'],
                'description' => $validated['description'] ?? null,
                'parent_id' => $validated['parent_id'] ?? null,
                'is_active' => $validated['is_active'],
                'sort_order' => $validated['sort_order'] ?? 0,
            ];

            $category = $this->categoryService->createCategory($categoryData);

            if ($request->expectsJson()) {
                return ResponseHelper::success(
                    ['category' => $category],
                    'Đã tạo danh mục thành công!',
                    HttpStatusCode::CREATED
                );
            }

            return ResponseHelper::redirectWithMessage('cms.categories', 'Đã tạo danh mục thành công!');
        } catch (\Exception $e) {
            return $this->handleException($e, $request, Message::ERROR);
        }
    }

    /**
     * Display users management page (users with roles)
     */
    public function users(Request $request)
    {
        $filters = [
            'search' => $request->input('search'),
            'role' => $request->input('role'),
            'status' => $request->input('status'),
        ];

        $users = $this->userService->getUsers($filters, 15);
        $roles = $this->userService->getActiveRoles();
        
        return view('cms.users', compact('users', 'roles'));
    }
}

