namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Approver\StoreApproverRequest;
use App\Services\ApproverService;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="Loker Approval API",
 *     description="Dokumentasi REST API untuk sistem approval pengeluaran"
 * )
 * @OA\Server(
 *     url=L5_SWAGGER_CONST_HOST,
 *     description="API Server"
 * )
 * @OA\Tag(
 *     name="Approver",
 *     description="Endpoint untuk approver"
 * )
 */
class ApproverController extends Controller
{
    public function __construct(private ApproverService $approverService) {}

    /**
     * @OA\Post(
     *     path="/api/approvers",
     *     tags={"Approver"},
     *     summary="Tambah approver",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name"},
     *             @OA\Property(property="name", type="string", example="Ana")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Berhasil"),
     *     @OA\Response(response=422, description="Validasi gagal")
     * )
     */
    public function store(StoreApproverRequest $request)
    {
        $approver = $this->approverService->store($request->validated());
        return response()->json($approver, 201);
    }
}
