namespace App\Http\Requests\Expense;

use Illuminate\Foundation\Http\FormRequest;

class ApproveExpenseRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'approver_id' => 'required|exists:approvers,id',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
