use App\Http\Controllers\Api\ApproverController;
use App\Http\Controllers\Api\ApprovalStageController;

Route::post('/approvers', [ApproverController::class, 'store']);
Route::post('/approval-stages', [ApprovalStageController::class, 'store']);
Route::put('/approval-stages/{id}', [ApprovalStageController::class, 'update']);
