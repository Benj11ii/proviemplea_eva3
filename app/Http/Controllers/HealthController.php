<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class HealthController extends Controller
{
    /**
     * @OA\Get(
     *     path="/health",
     *     operationId="healthCheck",
     *     tags={"Health"},
     *     summary="Verificar estado del servicio",
     *     @OA\Response(
     *         response=200,
     *         description="Servicio operativo",
     *         @OA\JsonContent(
     *             type="object",
     *             example={"status": "online", "service": "ProviEmplea API", "version": "1.0.0"}
     *         )
     *     )
     * )
     */
    public function __invoke(): JsonResponse
    {
        return response()->json([
            'status'    => 'online',
            'service'   => 'ProviEmplea API',
            'version'   => '1.0.0',
            'timestamp' => now()->toIso8601String(),
        ]);
    }
}