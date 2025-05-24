<?php 
namespace App\Services;

use App\Models\Approval;
use App\Models\ApprovalStage;
use App\Models\Expense;
use App\Models\Status;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class ExpenseService
{
    public function store(array $data): Expense
    {
        return DB::transaction(function () use ($data) {
            // ambil status "menunggu persetujuan"
            $waitingStatus = Status::where('name', 'menunggu persetujuan')->firstOrFail();

            // buat pengeluaran
            $expense = Expense::create([
                'amount' => $data['amount'],
                'status_id' => $waitingStatus->id,
            ]);

            // buat approval untuk tiap stage
            $stages = ApprovalStage::orderBy('id')->get();

            foreach ($stages as $stage) {
                Approval::create([
                    'expense_id' => $expense->id,
                    'approver_id' => $stage->approver_id,
                    'status_id' => $waitingStatus->id,
                ]);
            }

            return $expense;
        });
    }

    public function approve(int $expenseId, int $approverId): Expense
    {
        return DB::transaction(function () use ($expenseId, $approverId) {
            $approvedStatus = Status::where('name', 'disetujui')->firstOrFail();
            $waitingStatus = Status::where('name', 'menunggu persetujuan')->firstOrFail();

            $expense = Expense::with(['approvals'])->findOrFail($expenseId);

            $approval = $expense->approvals()
                ->where('approver_id', $approverId)
                ->first();

            if (!$approval) {
                throw new ModelNotFoundException("Approver not assigned to this expense.");
            }

            // Cek apakah semua approval sebelum ini sudah disetujui
            $approvalStages = Approval::where('expense_id', $expenseId)
                ->orderBy('id')
                ->get();

            foreach ($approvalStages as $stage) {
                if ($stage->id == $approval->id) break;
                if ($stage->status_id != $approvedStatus->id) {
                    throw new \Exception("Approval cannot proceed. Previous stage not approved.");
                }
            }

            // Setujui approval ini
            $approval->update(['status_id' => $approvedStatus->id]);

            // Jika semua disetujui, ubah status expense
            $allApproved = $expense->approvals()->where('status_id', $waitingStatus->id)->count() === 0;
            if ($allApproved) {
                $expense->update(['status_id' => $approvedStatus->id]);
            }

            return $expense->fresh();
        });
    }

    public function show(int $id): Expense
    {
        return Expense::with([
            'status',
            'approvals' => function ($q) {
                $q->orderBy('id');
            },
            'approvals.approver',
            'approvals.status'
        ])->findOrFail($id);
    }


}
