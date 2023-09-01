<?php

namespace App\Http\Requests\PresenceRequest;

use App\Traits\PaginateRules;
use Illuminate\Foundation\Http\FormRequest;

class PresencePaginateRequest extends FormRequest
{
    use PaginateRules;
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            ...$this->getRules(),
            'type' => ['in:IN,OUT']
        ];
    }
}