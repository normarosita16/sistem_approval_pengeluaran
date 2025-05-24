namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Expense\StoreExpenseRequest;
use App\Services\ExpenseService;
use App\Http\Requests\Expense\ApproveExpenseRequest;


class ExpenseController extends Controller
{
    public function __construct(private ExpenseService $expenseService) {}

    /**
     * @OA\Post(
     *     path="/api/expense",
     *     tags={"Expense"},
     *     summary="Tambah pengeluaran",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"amount"},
     *             @OA\Property(property="amount", type="integer", example=100000)
     *         )
     *     ),
     *     @OA\Response(response=201, description="Berhasil"),
     *     @OA\Response(response=422, description="Validasi gagal")
     * )
     */
    public function store(StoreExpenseRequest $request)
    {
        $expense = $this->expenseService->store($request->validated());
        return response()->json($expense, 201);
    },

/**
 * @OA\Patch(
 *     path="/api/expense/{id}/approve",
 *     tags={"Expense"},
 *     summary="Approver menyetujui pengeluaran",
 *     @OA\Parameter(
 *         name="id", in="path", required=true, @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"approver_id"},
 *             @OA\Property(property="approver_id", type="integer", example=1)
 *         )
 *     ),
 *     @OA\Response(response=200, description="Berhasil"),
 *     @OA\Response(response=400, description="Tahapan belum terpenuhi"),
 *     @OA\Response(response=404, description="Data tidak ditemukan")
 * )
 */
public function approve(ApproveExpenseRequest $request, int $id)
{
    try {
        $expense = $this->expenseService->approve($id, $request->validated()['approver_id']);
        return response()->json($expense);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 400);
    }
}

}
