<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        $productId = is_object($this->route('product')) ? $this->route('product')->id : ($this->route('product') ?? $this->product);

        return [
            'name'                   => 'required|string|max:255',
            'sku'                    => 'required|string|max:100|unique:products,sku,' . $productId,
            'barcode'                => 'nullable|string|max:100|unique:products,barcode,' . $productId,
            'category_id'            => 'required|exists:categories,id',
            'brand_id'               => 'required|exists:brands,id',
            'supplier_id'            => 'nullable|exists:suppliers,id',
            'cost_price'             => 'required|numeric|min:0',
            'selling_price'          => 'required|numeric|min:0',
            'stock_quantity'         => 'required|integer|min:0',
            'min_stock_alert'        => 'nullable|integer|min:0',
            'warranty_period_months' => 'nullable|integer|min:0',
            'specifications'         => 'nullable|string',
            'description'            => 'nullable|string',
            'thumbnail'              => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'gallery_images.*'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'status'                 => 'required|in:In Stock,Low Stock,Out of Stock,Discontinued',
        ];
    }
}
