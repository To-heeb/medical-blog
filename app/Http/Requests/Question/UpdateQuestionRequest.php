<?php

namespace App\Http\Requests\Question;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class UpdateQuestionRequest extends FormRequest
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
            'title' => 'required|unique:questions,title,' . (optional($this->question)->id ?: 'NULL'),
            'content' => 'required',
            'user_id' => 'required|exists:users,id',
            'slug' => 'unique:questions,slug,' . (optional($this->question)->id ?: 'NULL'),
        ];
    }
}
