namespace App\Http\Requests\ApprovalStage;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateApprovalStageRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'approver_id' => [
                'required',
                'exists:approvers,id',
                Rule::unique('approval_stages', 'approver_id')->ignore($this->route('id'))
            ]
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
