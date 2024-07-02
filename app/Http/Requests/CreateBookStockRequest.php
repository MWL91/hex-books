<?php

namespace App\Http\Requests;

use App\ValueObjects\Book;
use Illuminate\Foundation\Http\FormRequest;

class CreateBookStockRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return !!$this->user();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
        ];
    }

    public function getBook(): Book
    {
        return new Book(
            name: $this->input('name'),
            isbn: $this->input('isbn'),
            quantity: $this->input('quantity'),
        );
    }

    public function getQuantity(): int
    {
        return $this->input('quantity');
    }
}
