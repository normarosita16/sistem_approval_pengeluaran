<?php 
namespace App\Http\Requests\Expense;

use Illuminate\Foundation\Http\FormRequest;

class StoreExpenseRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'amount' => 'required|integer|min:1'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
