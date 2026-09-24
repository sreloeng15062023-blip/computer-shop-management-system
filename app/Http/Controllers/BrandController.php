<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Http\Requests\StoreBrandRequest;   // បន្ថែមពេលចង់តេស្ដលើPostman
use App\Http\Requests\UpdateBrandRequest;  // បន្ថែមពេលចង់តេស្ដលើPostman
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * 1. បង្ហាញបញ្ជី Brands ទាំងអស់ (ជាមួយ Search & Pagination)
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Brand::query();
        //មុខងារ Search រកឈ្មោះ Brand ឬ ប្រទេស
        if($request->filled('search')){
            $search=$request->search;
            $query->where(function($q) use($search){
                $q->where('brand_name','like',"%{$search}%")
                  ->orWhere('country','like',"%{$search}%");
            });
        }

        // មុខងារ Filter តាម Status (Active / Inactive)
        if($request->filled('status')){
            $query->where('status',$request->status);
        }

        //ទាញទិន្នន័យចុងក្រោយគេបង្អស់ និងចែកទំព័រ (10 ក្នុងមួយទំព័រ)
        $brands = $query->latest()->paginate(10)->withQueryString();

        // ថែមសម្រាប់ Postman
        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json(['status' => true, 'data' => $brands], 200);
        }

        return view('brands', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     * 2. បង្ហាញ Form បង្កើត Brand ថ្មី (ករណី Frontend ធ្វើជាទំព័រដាច់ដោយឡែក)
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('brands');
    }

    /**
     * Store a newly created resource in storage.
     * 3. រក្សាទុក Brand ថ្មីចូលក្នុង Database
     * @param  \App\Http\Requests\StoreBrandRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBrandRequest $request)
    {
        $brand = Brand::create($request->validated());

        // ថែមសម្រាប់ Postman
        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json(['status' => true, 'message' => 'Add Brand Successfully', 'data' => $brand], 201);
        }

        return redirect()->route('brands.index')
                         ->with('success','Add Brand Successfully');
    }

    /**
     * Display the specified resource.
     * 4. បង្ហាញព័ត៌មានលម្អិត Brand មួយ
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Brand $brand)
    {
        // ថែមសម្រាប់ Postman
        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json(['status' => true, 'data' => $brand], 200);
        }

        return view('brands', compact('brand'));
    }

    /**
     * Show the form for editing the specified resource.
     * 5. បង្ហាញ Form កែប្រែ Brand
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function edit(Brand $brand)
    {
        return view('brands', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     * 6. ធ្វើបច្ចុប្បន្នភាព (Update) Brand ក្នុង Database
     * @param  \App\Http\Requests\UpdateBrandRequest  $request
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBrandRequest $request, Brand $brand)
    {
        $brand->update($request->validated());

        // ថែមសម្រាប់ Postman
        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json(['status' => true, 'message' => 'Updated Brand Successfully', 'data' => $brand], 200);
        }

        return redirect()->route('brands.index')
                         ->with('success','Updated Brand Successfully');
    }

    /**
     * Remove the specified resource from storage.
     * 7. លុប Brand ចេញពី Database
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Brand $brand)
    {
        // ពិនិត្យការពារ៖ បើ Brand នេះមានកុំព្យូទ័រ/ផលិតផលកំពុងប្រើ មិនឱ្យលុបឡើយ

        // ធ្វើការលុប Brandសិន​ដើម្បីទៅតេស្ដpostman ចាំពេលធ្វើដល់phase2 ចាំបើកវិញ
        // if ($brand->products()->exists()) {
        //     if ($request->wantsJson() || $request->is('api/*')) {
        //         return response()->json(['status' => false, 'message' => 'Cannot Delete Brand Because Product Is Using'], 400);
        //     }
        //     return redirect()->route('brands.index')
        //                      ->with('error', 'Cannot Delete Brand Because Product Is Using');
        // }

        $brand->delete();

        // ថែមសម្រាប់ Postman
        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json(['status' => true, 'message' => 'Deleted Brand Successfully'], 200);
        }

        return redirect()->route('brands.index')
                         ->with('success', 'Deleted Brand Successfully');
    }
}
