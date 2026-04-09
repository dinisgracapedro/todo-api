<?php

namespace App\Swagger;

use OpenApi\Attributes as OA;

#[OA\Info(
    version: "1.0.0",
    title: "API de Autenticação",
    description: "Documentação da API com Laravel 12 + Swagger"
)]
#[OA\Server(
    url: "http://localhost:8000",
    description: "Servidor Local"
)]
#[OA\SecurityScheme(
    securityScheme: "sanctum",
    type: "http",
    scheme: "bearer",
    bearerFormat: "JWT"
)]
class OpenApi {}