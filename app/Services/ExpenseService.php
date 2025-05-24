namespace App\Services;

use App\Models\Approval;
use App\Models\ApprovalStage;
use App\Models\Expense;
use App\Models\Status;
use Illuminate\Support\Facades\DB;

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
}
