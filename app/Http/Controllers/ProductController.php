<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Supplier;
use App\Models\ProductSerial;
use App\Models\ProductImage;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * 1. បង្ហាញបញ្ជី Products (Search, Category Filter, Brand Filter, Status Filter & Pagination)
     */
    public function index(Request $request)
    {
        $query = Product::with(['category', 'brand', 'supplier', 'serials', 'images']);

        // Search តាម Name, SKU, ឬ Barcode
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhere('barcode', 'like', "%{$search}%");
            });
        }

        // Filter តាម Category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter តាម Brand
        if ($request->filled('brand_id')) {
            $query->where('brand_id', $request->brand_id);
        }

        // Filter តាម Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $products = $query->latest()->paginate(10)->withQueryString();

        // គណនាស្ថិតិសម្រាប់ Stat Cards ទាំង ៤
        $totalProducts   = Product::count();
        $inStockCount    = Product::where('status', 'In Stock')->count();
        $lowStockCount   = Product::where('status', 'Low Stock')->count();
        $outOfStockCount = Product::where('status', 'Out of Stock')->count();

        // Data សម្រាប់ Dropdown Filters & Forms
        $categories = Category::where('status', 'Active')->get();
        $brands     = Brand::where('status', 'Active')->get();
        $suppliers  = Supplier::where('status', 'Active')->get();

        // Support JSON សម្រាប់ Postman
        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json(['status' => true, 'data' => $products], 200);
        }

        return view('products', compact(
            'products',
            'categories',
            'brands',
            'suppliers',
            'totalProducts',
            'inStockCount',
            'lowStockCount',
            'outOfStockCount'
        ));
    }

    /**
     * 2. បង្កើត Product ថ្មី ព្រមទាំង Upload រូបភាព និងបញ្ចូល Serial Numbers
     */
    public function store(StoreProductRequest $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->validated();

            // Handle Thumbnail Upload
            if ($request->hasFile('thumbnail')) {
                $data['thumbnail'] = $request->file('thumbnail')->store('products/thumbnails', 'public');
            }

            // បង្កើត Product Record
            $product = Product::create($data);

            // Handle Gallery Images Upload (រូបភាពច្រើនសន្លឹក)
            if ($request->hasFile('gallery_images')) {
                foreach ($request->file('gallery_images') as $image) {
                    $path = $image->store('products/gallery', 'public');
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $path,
                    ]);
                }
            }

            // Handle Serial Numbers (មួយជួរ = មួយលេខ Serial)
            if ($request->filled('serial_numbers')) {
                $serials = array_filter(array_map('trim', explode("\n", $request->serial_numbers)));
                foreach ($serials as $serial) {
                    if (!empty($serial)) {
                        ProductSerial::firstOrCreate([
                            'product_id'    => $product->id,
                            'serial_number' => $serial,
                        ], [
                            'status' => 'In Stock',
                        ]);
                    }
                }
            }

            DB::commit();

            if ($request->wantsJson() || $request->is('api/*')) {
                return response()->json(['status' => true, 'message' => 'Product created successfully', 'data' => $product->load(['serials', 'images'])], 201);
            }

            return redirect()->route('products.index')->with('success', 'Product created successfully with Serials and Images');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error creating product: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * 3. មើលព័ត៌មានលម្អិត Product មួយ
     */
    public function show(Request $request, Product $product)
    {
        $product->load(['category', 'brand', 'supplier', 'serials', 'images']);

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json(['status' => true, 'data' => $product], 200);
        }

        return view('products', compact('product'));
    }

    /**
     * 4. កែប្រែទិន្នន័យ Product
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = $request->validated();

        // Handle Thumbnail Update
        if ($request->hasFile('thumbnail')) {
            if ($product->thumbnail && Storage::disk('public')->exists($product->thumbnail)) {
                Storage::disk('public')->delete($product->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('products/thumbnails', 'public');
        }

        $product->update($data);

        // Handle Additional Gallery Images Upload
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $image) {
                $path = $image->store('products/gallery', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                ]);
            }
        }

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json(['status' => true, 'message' => 'Product updated successfully', 'data' => $product], 200);
        }

        return redirect()->route('products.index')->with('success', 'Product updated successfully');
    }

    /**
     * 5. លុប Product
     */
    public function destroy(Request $request, Product $product)
    {
        // លុបរូបភាព Thumbnail
        if ($product->thumbnail && Storage::disk('public')->exists($product->thumbnail)) {
            Storage::disk('public')->delete($product->thumbnail);
        }

        // លុបរូបភាព Gallery
        foreach ($product->images as $img) {
            if (Storage::disk('public')->exists($img->image_path)) {
                Storage::disk('public')->delete($img->image_path);
            }
        }

        $product->delete();

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json(['status' => true, 'message' => 'Product deleted successfully'], 200);
        }

        return redirect()->route('products.index')->with('success', 'Product deleted successfully');
    }
}
