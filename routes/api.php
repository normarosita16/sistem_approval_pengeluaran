use App\Http\Controllers\Api\ApproverController;
use App\Http\Controllers\Api\ApprovalStageController;
use App\Http\Controllers\Api\ExpenseController;

Route::post('/approvers', [ApproverController::class, 'store']);
Route::post('/approval-stages', [ApprovalStageController::class, 'store']);
Route::put('/approval-stages/{id}', [ApprovalStageController::class, 'update']);
Route::post('/expense', [ExpenseController::class, 'store']);
Route::put('/expense/{id}/approve', [ExpenseController::class, 'approve']);
Route::get('/expense/{id}', [ExpenseController::class, 'show']);

