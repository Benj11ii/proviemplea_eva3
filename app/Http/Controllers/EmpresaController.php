<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmpresaController extends Controller
{
    /**
     * @OA\Get(
     *     path="/empresas",
     *     operationId="getEmpresas",
     *     tags={"Empresas"},
     *     summary="Listar empresas",
     *     @OA\Response(
     *         response=200,
     *         description="Listado exitoso",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Empresa")
     *         )
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        return $this->successResponse(Empresa::where('activo', true)->get());
    }

    /**
     * @OA\Post(
     *     path="/empresas",
     *     operationId="createEmpresa",
     *     tags={"Empresas"},
     *     summary="Registrar nueva empresa",
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/EmpresaInput")),
     *     @OA\Response(response=201, description="Creado", @OA\JsonContent(ref="#/components/schemas/Empresa"))
     * )
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'nombre_empresa'  => 'required|string|max:255',
            'rut_empresa'     => 'required|string|unique:empresas,rut_empresa',
            'email'           => 'required|email|unique:empresas,email',
            'tipo_empresa'    => 'required|in:contratacion-directa,est,outsourcing',
            'contacto_nombre' => 'required|string',
            'contacto_email'  => 'required|email',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validación fallida.', 422, $validator->errors()->toArray());
        }

        return $this->successResponse(Empresa::create($validator->validated()), 201);
    }

    /**
     * @OA\Get(
     *     path="/empresas/{id}",
     *     operationId="getEmpresa",
     *     tags={"Empresas"},
     *     summary="Obtener empresa por ID",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="string", format="uuid")),
     *     @OA\Response(response=200, description="Encontrado")
     * )
     */
    public function show(string $empresa): JsonResponse
    {
        $model = Empresa::find($empresa);
        if (!$model) return $this->errorResponse('Empresa no encontrada.', 404);
        return $this->successResponse($model);
    }

    /**
     * @OA\Put(
     *     path="/empresas/{id}",
     *     operationId="updateEmpresa",
     *     tags={"Empresas"},
     *     summary="Actualizar empresa",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="string", format="uuid")),
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/EmpresaInput")),
     *     @OA\Response(response=200, description="Actualizado")
     * )
     */
    public function update(Request $request, string $empresa): JsonResponse
    {
        $model = Empresa::find($empresa);
        if (!$model) return $this->errorResponse('Empresa no encontrada.', 404);

        $validator = Validator::make($request->all(), [
            'nombre_empresa' => 'sometimes|string',
            'rut_empresa' => 'sometimes|string|unique:empresas,rut_empresa,' . $model->id,
            'email' => 'sometimes|email|unique:empresas,email,' . $model->id,
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validación fallida.', 422, $validator->errors()->toArray());
        }

        $model->update($validator->validated());
        return $this->successResponse($model->fresh());
    }

    /**
     * @OA\Patch(
     *     path="/empresas/{id}/validar",
     *     operationId="validarEmpresa",
     *     tags={"Empresas"},
     *     summary="Validar empresa",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="string", format="uuid")),
     *     @OA\Response(response=200, description="Validado")
     * )
     */
    public function validar(string $empresa): JsonResponse
    {
        $model = Empresa::find($empresa);
        if (!$model) return $this->errorResponse('Empresa no encontrada.', 404);
        $model->update(['validado' => true]);
        return $this->successResponse($model->fresh());
    }

    /**
     * @OA\Delete(
     *     path="/empresas/{id}",
     *     operationId="deleteEmpresa",
     *     tags={"Empresas"},
     *     summary="Desactivar empresa",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="string", format="uuid")),
     *     @OA\Response(response=200, description="Desactivada")
     * )
     */
    public function destroy(string $empresa): JsonResponse
    {
        $model = Empresa::find($empresa);
        if (!$model) return $this->errorResponse('Empresa no encontrada.', 404);
        $model->update(['activo' => false]);
        return $this->successResponse(['message' => 'Empresa desactivada exitosamente.']);
    }
}