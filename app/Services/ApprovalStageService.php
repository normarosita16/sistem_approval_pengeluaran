namespace App\Services;

use App\Models\ApprovalStage;

class ApprovalStageService
{
    public function store(array $data): ApprovalStage
    {
        return ApprovalStage::create($data);
    },
    public function update(int $id, array $data): ApprovalStage
{
    $stage = ApprovalStage::findOrFail($id);
    $stage->update($data);
    return $stage;
}

}
