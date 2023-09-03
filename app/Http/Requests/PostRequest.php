<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules()
    {
        switch($this->method())
        {
            case 'POST':
            {
                return $this->createRules();
            }
            case 'PUT':
            case 'PATCH':
            {
                return $this->updateRules();
            }
            default:break;
        }         
        return $this->createRules();
    }

    public function createRules(): array
    {
        return [
            'title' => 'required|unique:posts,title',
            'description' => 'required',
        ];
    }

    public function updateRules(): array
    { 
        return [
            'title' => 'required|unique:posts,title,'.$this->post,
            'description' => 'required',
        ];
    }
    
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ]));
    }

    /* public function messages()
    {
        return [
            'title.required' => 'The title field is required.',
            'description.required' => 'The description field is required.',
            // Add more custom error messages here...
        ];
    } 
        $out = new \Symfony\Component\Console\Output\ConsoleOutput();
        $out->writeln('METHOD');
        $out->writeln($this->method());
        $out->writeln($this->post);    
    */
    
}
