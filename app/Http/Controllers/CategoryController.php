<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * 1. បង្ហាញបញ្ជី Categories (Search + Status Filter + Pagination)
     */
    public function index(Request $request)
    {
        $query = Category::withCount('products');

        // Search តាម Name, Slug, ឬ Description
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter តាម Status (Active / Inactive)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $categories = $query->latest()->paginate(10)->withQueryString();

        // គណនាស្ថិតិសម្រាប់ Stat Cards ទាំង ៤
        $totalCategories    = Category::count();
        $activeCategories   = Category::where('status', 'Active')->count();
        $inactiveCategories = Category::where('status', 'Inactive')->count();
        $totalProductsCount = Product::count();

        // Support JSON API សម្រាប់ Postman
        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json(['status' => true, 'data' => $categories], 200);
        }

        return view('categories', compact(
            'categories',
            'totalCategories',
            'activeCategories',
            'inactiveCategories',
            'totalProductsCount'
        ));
    }

    /**
     * 2. បង្កើត Category ថ្មី
     */
    public function store(StoreCategoryRequest $request)
    {
        $data = $request->validated();

        // បើមិនបានវាយ Slug ទេ គឺបង្កើតស្វ័យប្រវត្តិតាម Name
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $category = Category::create($data);

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'status'  => true,
                'message' => 'Category created successfully',
                'data'    => $category
            ], 201);
        }

        return redirect()->route('categories.index')->with('success', 'Category created successfully');
    }

    /**
     * 3. មើលព័ត៌មានលម្អិត Category ម្នាក់
     */
    public function show(Request $request, Category $category)
    {
        $category->load('products');

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json(['status' => true, 'data' => $category], 200);
        }

        return view('categories', compact('category'));
    }

    /**
     * 4. កែប្រែទិន្នន័យ Category
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $data = $request->validated();

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $category->update($data);

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'status'  => true,
                'message' => 'Category updated successfully',
                'data'    => $category
            ], 200);
        }

        return redirect()->route('categories.index')->with('success', 'Category updated successfully');
    }

    /**
     * 5. លុប Category
     */
    public function destroy(Request $request, Category $category)
    {
        // ពិនិត្យមើលថាតើ Category នេះមាន Product កំពុងប្រើប្រាស់ឬទេ
        if ($category->products()->count() > 0) {
            $msg = 'Cannot delete category because it contains ' . $category->products()->count() . ' products. Please reassign or delete the products first.';
            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json(['status' => false, 'message' => $msg], 400);
            }
            return redirect()->route('categories.index')->with('error', $msg);
        }

        $category->delete();

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'status'  => true,
                'message' => 'Category deleted successfully'
            ], 200);
        }

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully');
    }
}
