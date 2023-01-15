<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProjectRequest extends FormRequest
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
            'title' => ['required', 'max:150', Rule::unique('projects')->ignore($this->project)],
            'content' => ['nullable'],
            'cover_image' => ['nullable', 'image', 'max:1000'],
            'type_id' => 'nullable|exists:types,id',
            'tags' => 'nullable|exists:tags,id'

        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Il titolo è obbligatorio',
            'title.max' => 'Il titolo può avere massimo 150 caratteri',
            'title.unique' => 'Esiste già un progetto con questo titolo',
            'content.max' => 'La descrizione può avere massimo 300 caratteri'
        ];
    }
}
