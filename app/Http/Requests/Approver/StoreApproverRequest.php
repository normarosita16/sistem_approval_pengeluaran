<?php 
namespace App\Http\Requests\Approver;

use Illuminate\Foundation\Http\FormRequest;

class StoreApproverRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|unique:approvers,name'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
