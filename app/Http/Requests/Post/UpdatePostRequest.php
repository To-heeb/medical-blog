<?php

namespace App\Http\Requests\Post;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }


    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'slug' => Str::slug($this->input('title'))
        ]);

        $this->merge([
            'user_id' => Auth::user()->id ?? null
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|unique:posts,title,' . (optional($this->post)->id ?: 'NULL'),
            'content' => 'required',
            'category_id' =>  'required|exists:categories,id',
            'user_id' => 'required|exists:users,id',
            'slug' => 'unique:posts,slug,' . (optional($this->post)->id ?: 'NULL'),
        ];
    }
}
