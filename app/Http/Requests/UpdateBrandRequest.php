<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBrandRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()

    
    {
        // $this->brand->id គឺយក ID បច្ចុប្បន្ន ដើម្បីកុំឱ្យវាច្រឡំថាជាន់ឈ្មោះខ្លួនឯងពេល Update
        $brandId= $this->route('brand')->id ?? $this->route('brand');
        return [
            'brand_name'  => 'required|string|max:50|unique:brands,brand_name,' . $brandId,
            'country'     => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'status'      => 'required|in:Active,Inactive',
            
        ];
    }
    public function messages(){
        return [
            
        //required (ត្រូវតែបញ្ចូល / ហាមទុកទទេ)
        //unique (ហាមជាន់គ្នា / ត្រូវតែប្លែកពីគេ)
            'brand_name.required' => 'Please enter brand name',
            'brand_name.unique'   => 'Brand name already exists',
            'status.required'     => 'Please select status',
        ];
    }
}
