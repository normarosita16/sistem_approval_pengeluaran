namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApprovalStage\StoreApprovalStageRequest;
use App\Services\ApprovalStageService;

class ApprovalStageController extends Controller
{
    public function __construct(private ApprovalStageService $approvalStageService) {}

    /**
     * @OA\Post(
     *     path="/api/approval-stages",
     *     tags={"Approval Stage"},
     *     summary="Tambah tahap approval",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"approver_id"},
     *             @OA\Property(property="approver_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(response=201, description="Berhasil"),
     *     @OA\Response(response=422, description="Validasi gagal")
     * )
     */
    public function store(StoreApprovalStageRequest $request)
    {
        $stage = $this->approvalStageService->store($request->validated());
        return response()->json($stage, 201);
    }
}
