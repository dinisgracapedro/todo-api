<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

use OpenApi\Attributes as OA;

#[OA\Tag(name: "Auth", description: "Autenticação de usuários")]
class AuthController extends Controller
{
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    #[OA\Post(
        path: "/api/v1/register",
        summary: "Registrar usuário",
        tags: ["Auth"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["name", "email", "password", "password_confirmation"],
                properties: [
                    new OA\Property(property: "name", type: "string", example: "João Silva"),
                    new OA\Property(property: "email", type: "string", format: "email", example: "joao@email.com"),
                    new OA\Property(property: "password", type: "string", format: "password", example: "12345678"),
                    new OA\Property(property: "password_confirmation", type: "string", format: "password", example: "12345678"),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: "Usuário registrado com sucesso"
            ),
            new OA\Response(
                response: 422,
                description: "Erro de validação"
            )
        ]
    )]
    public function register(RegisterRequest $request)
    {
        $user = $this->authService->register($request->validated());

        return response()->json([
            'message' => 'Usuário registrado com sucesso!',
            'user' => new UserResource($user)
        ], 201);
    }

    #[OA\Post(
        path: "/api/v1/login",
        summary: "Login do usuário",
        tags: ["Auth"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["email", "password"],
                properties: [
                    new OA\Property(property: "email", type: "string", format: "email", example: "joao@email.com"),
                    new OA\Property(property: "password", type: "string", format: "password", example: "12345678"),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: "Login realizado com sucesso"
            ),
            new OA\Response(
                response: 401,
                description: "Credenciais inválidas"
            )
        ]
    )]
    public function login(LoginRequest $request)
    {
        try {
            $data = $this->authService->login($request->validated());

            return response()->json([
                'access_token' => $data['token'],
                'token_type' => 'Bearer',
                'user' => new UserResource($data['user'])
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'As credenciais fornecidas estão incorretas.'
            ], 401);
        }
    }

    #[OA\Post(
        path: "/api/v1/logout",
        summary: "Logout do usuário",
        security: [["sanctum" => []]],
        tags: ["Auth"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Logout realizado com sucesso"
            ),
            new OA\Response(
                response: 401,
                description: "Não autenticado"
            )
        ]
    )]
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout realizado com sucesso.'
        ]);
    }

    public function t(Request $request)
    {
        return "Docs";
    }
}