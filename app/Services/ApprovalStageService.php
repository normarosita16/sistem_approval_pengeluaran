namespace App\Services;

use App\Models\ApprovalStage;

class ApprovalStageService
{
    public function store(array $data): ApprovalStage
    {
        return ApprovalStage::create($data);
    }
}
