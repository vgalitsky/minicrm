<?php
namespace Mtr\MiniCrm\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class StoreTicketRequest extends FormRequest
{
    /**
     * @inheritDoc
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'email' => Str::lower($this->email),
            'phone' => preg_replace('/\D+/', '', $this->phone),
            'name' => Str::title(strip_tags($this->name)),

            'subject' => strip_tags($this->subject),
            'description' => strip_tags($this->description),
        ]);
    }

    /**
     * @inheritDoc
     */
    public function rules(): array
    {
        return [
            'name'=> 'required|string|max:255',
            'phone' => 'required|digits_between:7,15',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'description' => 'required|string|max:5000',
        ];
    }

    /**
     * @inheritDoc
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Name is required.',
            'name.string' => 'Name must be a string.',
            'name.max' => 'Name must not exceed 255 characters.',

            'phone.required' => 'Phone number is required.',
            'phone.digits_between' => 'Phone number must be between 7 and 15 digits.',

            'email.required' => 'Email is required.',
            'email.email' => 'Email must be a valid email address.',
            'email.max' => 'Email must not exceed 255 characters.',

            'subject.required' => 'Subject is required.',
            'subject.string' => 'Subject must be a string.',
            'subject.max' => 'Subject must not exceed 255 characters.',

            'description.required' => 'Description is required.',
            'description.string' => 'Description must be a string.',
            'description.max' => 'Description must not exceed 5000 characters.',
        ];
    }
}