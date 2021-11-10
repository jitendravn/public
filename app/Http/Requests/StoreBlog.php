<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBlog extends FormRequest
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
        return [
            'title' => 'required',
            'description' => 'required',
            'author' => 'required',
            'status' => 'required',
            'image' => 'required|mimes:png,jpg,jpeg',
        ];
    }
    // public function messages()
    // {
    //     return [
    //         'title.required' => 'Title is required!',
    //         'description.required' => 'Description is required!',
    //         'author.required' => 'Author is required!',
    //         'status.required' => 'Status is required!',
    //         'image.required' => 'author is required!',
    //         'image.mimes' => 'You can upload only jpg,png,jpeg ',
    //     ];
    // }
}
