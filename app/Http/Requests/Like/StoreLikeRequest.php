<?php

namespace App\Http\Requests\Like;

use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class StoreLikeRequest extends FormRequest
{

    public $likeable_type;
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

        $this->likeable_type = $this->input('like_type');

        $this->merge([
            'user_id' => Auth::user()->id ?? null
        ]);

        $like_type = Str::singular($this->input('like_type'));

        $this->merge([
            'likeable_type' => Str::title("app\models\\$like_type")
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
            'like_type' => ["required", Rule::in(['posts', 'questions']),],
            'likeable_type' => ["required"],
            'likeable_id' => ["required", "exists:$this->likeable_type,id"],
            'user_id' => 'required|exists:users,id',
        ];
    }
}
