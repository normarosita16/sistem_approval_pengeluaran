<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApprovalStage\StoreApprovalStageRequest;
use App\Http\Requests\ApprovalStage\UpdateApprovalStageRequest;
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

    /**
     * @OA\Put(
     *     path="/api/approval-stages/{id}",
     *     tags={"Approval Stage"},
     *     summary="Ubah tahap approval",
     *     @OA\Parameter(
     *         name="id", in="path", required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"approver_id"},
     *             @OA\Property(property="approver_id", type="integer", example=2)
     *         )
     *     ),
     *     @OA\Response(response=200, description="Berhasil"),
     *     @OA\Response(response=422, description="Validasi gagal"),
     *     @OA\Response(response=404, description="Not found")
     * )
     */
    public function update(UpdateApprovalStageRequest $request, int $id)
    {
        $stage = $this->approvalStageService->update($id, $request->validated());
        return response()->json($stage);
    }
}
