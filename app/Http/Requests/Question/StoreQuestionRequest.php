<?php

namespace App\Http\Requests\Question;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class StoreQuestionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /*
    * Prepare the data for validation.
    */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'slug' => Str::slug($this->input('title'))
        ]);

        // $this->merge([
        //     'published_at' => Carbon::parse($this->input('published_at'))->timestamp
        // ]);

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
            'title' => 'required|unique:questions',
            'content' => 'required',
            'published_at' => 'required|date|date_format:Y-m-d H:i:s',
            'user_id' => 'required|exists:users,id',
            'slug' => 'unique:questions,slug,',
        ];
    }
}
