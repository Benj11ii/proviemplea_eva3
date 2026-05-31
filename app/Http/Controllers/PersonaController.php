<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PersonaController extends Controller
{
    /**
     * @OA\Get(
     *     path="/personas",
     *     operationId="getPersonas",
     *     tags={"Personas"},
     *     summary="Listar personas (CV ciego)",
     *     @OA\Parameter(name="validado", in="query", required=false, @OA\Schema(type="boolean")),
     *     @OA\Response(
     *         response=200,
     *         description="Listado exitoso",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/PersonaCVCiego")
     *         )
     *     )
     * )
     */
    public function index(Request $request): JsonResponse
    {
        $query = Persona::where('activo', true);
        if ($request->has('validado')) {
            $query->where('validado', $request->boolean('validado'));
        }
        return $this->successResponse($query->get()->map(fn($p) => $p->getCvCiego()));
    }

    /**
     * @OA\Post(
     *     path="/personas",
     *     operationId="createPersona",
     *     tags={"Personas"},
     *     summary="Registrar nueva persona/talento",
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/PersonaInput")),
     *     @OA\Response(response=201, description="Creado", @OA\JsonContent(ref="#/components/schemas/Persona")),
     *     @OA\Response(response=422, description="Error de validación")
     * )
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email'             => 'required|email|unique:personas,email',
            'telefono'          => 'nullable|string|max:15',
            'nivel_educacional' => 'nullable|in:basica,media,tecnica,universitaria,postgrado',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Los datos enviados no son válidos.', 422, $validator->errors()->toArray());
        }

        $data = $validator->validated();
        $data['codigo_talento'] = 'PROV-2026-' . strtoupper(Str::random(4));
        $data['porcentaje_completitud'] = 50;

        return $this->successResponse(Persona::create($data), 201);
    }

    /**
     * @OA\Get(
     *     path="/personas/{id}",
     *     operationId="getPersona",
     *     tags={"Personas"},
     *     summary="Obtener perfil completo por ID",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="string", format="uuid")),
     *     @OA\Response(response=200, description="Encontrado", @OA\JsonContent(ref="#/components/schemas/Persona")),
     *     @OA\Response(response=404, description="No encontrado")
     * )
     */
    public function show(string $persona): JsonResponse
    {
        $model = Persona::find($persona);
        if (!$model) return $this->errorResponse('Persona no encontrada.', 404);
        return $this->successResponse($model);
    }

    /**
     * @OA\Put(
     *     path="/personas/{id}",
     *     operationId="updatePersona",
     *     tags={"Personas"},
     *     summary="Actualizar perfil",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="string", format="uuid")),
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/PersonaInput")),
     *     @OA\Response(response=200, description="Actualizado")
     * )
     */
    public function update(Request $request, string $persona): JsonResponse
    {
        $model = Persona::find($persona);
        if (!$model) return $this->errorResponse('Persona no encontrada.', 404);

        $validator = Validator::make($request->all(), [
            'email' => 'sometimes|email|unique:personas,email,' . $model->id,
            'telefono' => 'nullable|string|max:15',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validación fallida.', 422, $validator->errors()->toArray());
        }

        $model->update($validator->validated());
        return $this->successResponse($model->fresh());
    }

    /**
     * @OA\Patch(
     *     path="/personas/{id}/validar",
     *     operationId="validarPersona",
     *     tags={"Personas"},
     *     summary="Validar talento",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="string", format="uuid")),
     *     @OA\Response(response=200, description="Validado")
     * )
     */
    public function validar(string $persona): JsonResponse
    {
        $model = Persona::find($persona);
        if (!$model) return $this->errorResponse('Persona no encontrada.', 404);
        $model->update(['validado' => true]);
        return $this->successResponse($model->fresh());
    }

    /**
     * @OA\Delete(
     *     path="/personas/{id}",
     *     operationId="deletePersona",
     *     tags={"Personas"},
     *     summary="Desactivar perfil",
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="string", format="uuid")),
     *     @OA\Response(response=200, description="Desactivado")
     * )
     */
    public function destroy(string $persona): JsonResponse
    {
        $model = Persona::find($persona);
        if (!$model) return $this->errorResponse('Persona no encontrada.', 404);
        $model->update(['activo' => false]);
        return $this->successResponse(['message' => 'Persona desactivada exitosamente.']);
    }
}