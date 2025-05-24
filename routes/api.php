use App\Http\Controllers\Api\ApproverController;
use App\Http\Controllers\Api\ApprovalStageController;
use App\Http\Controllers\Api\ExpenseController;

// untuk menambahkan approver
Route::post('/approvers', [ApproverController::class, 'store']);
// untuk menambahkan tahapan approval
Route::post('/approval-stages', [ApprovalStageController::class, 'store']);
// untuk mengubah tahapan approval.
Route::put('/approval-stages/{id}', [ApprovalStageController::class, 'update']);
// untuk menambahkan pengeluaran
Route::post('/expense', [ExpenseController::class, 'store']);
// untuk approver bisa approve sesuai urutan
Route::put('/expense/{id}/approve', [ExpenseController::class, 'approve']);
// untuk melihat detail pengeluaran dan seluruh tahapan approval-nya.
Route::get('/expense/{id}', [ExpenseController::class, 'show']);

