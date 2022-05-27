<?php

namespace App\Http\Requests\ShortenUrl;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'id_link' => 'required|integer',
            'title' => 'required|string',
            'shorten_url' => 'required|string|max:100|regex:/^\S*$/u|unique:short_links,shorten_url,' . $this->id_link,
            'destination_url' => 'required|active_url|max:500',
        ];
    }

    public function messages()
    {
        return [
            'shorten_url.regex' => 'the shorten url cannot contain whitespace',
        ];
    }
}
