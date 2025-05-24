namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Expense\StoreExpenseRequest;
use App\Services\ExpenseService;

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
    }
}
