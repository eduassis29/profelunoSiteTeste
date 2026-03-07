<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Serviço para integração com API .NET
 * Centraliza todas as chamadas HTTP para o backend C#
 */
class DotNetService
{
    private $baseUrl;
    private $timeout;

    public function __construct()
    {
        $this->baseUrl = env('DOTNET_API_URL', 'http://dotnet:5000/api');
        $this->timeout = env('DOTNET_API_TIMEOUT', 30);
    }

    // ============ AUTENTICAÇÃO ============
    
    public function login($email, $password)
    {
        try {
            $response = Http::timeout($this->timeout)->post(
                "{$this->baseUrl}/auth/login",
                ['email' => $email, 'password' => $password]
            );

            if ($response->successful()) {
                return [
                    'success' => true,
                    'token' => $response->json()['token'],
                    'user' => $response->json()['user'],
                ];
            }

            return $this->errorResponse($response);
        } catch (\Exception $e) {
            return $this->exceptionResponse($e, 'Erro ao fazer login');
        }
    }

    // ============ SALAS DE AULA ============
    
    public function getClassrooms()
    {
        try {
            $response = Http::withHeaders($this->getAuthHeaders())
                ->timeout($this->timeout)
                ->get("{$this->baseUrl}/classrooms");

            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $response->json()['data'] ?? [],
                ];
            }

            return $this->errorResponse($response);
        } catch (\Exception $e) {
            return $this->exceptionResponse($e, 'Erro ao listar salas');
        }
    }

    public function getClassroom($classroomId)
    {
        try {
            $response = Http::withHeaders($this->getAuthHeaders())
                ->timeout($this->timeout)
                ->get("{$this->baseUrl}/classrooms/{$classroomId}");

            if ($response->successful()) {
                return [
                    'success' => true,
                    'data' => $response->json()['data'],
                ];
            }

            return $this->errorResponse($response);
        } catch (\Exception $e) {
            return $this->exceptionResponse($e, 'Erro ao obter sala');
        }
    }

    public function createClassroom($data)
    {
        try {
            $response = Http::withHeaders($this->getAuthHeaders())
                ->timeout($this->timeout)
                ->post("{$this->baseUrl}/classrooms", $data);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'message' => 'Sala criada com sucesso',
                    'data' => $response->json()['data'],
                ];
            }

            return $this->errorResponse($response);
        } catch (\Exception $e) {
            return $this->exceptionResponse($e, 'Erro ao criar sala');
        }
    }

    // ============ MÉTODOS AUXILIARES ============
    
    private function getAuthHeaders()
    {
        $token = session('auth_token');
        return [
            'Authorization' => $token ? "Bearer {$token}" : '',
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
    }

    private function errorResponse($response)
    {
        $data = $response->json();
        Log::warning('Erro na API .NET', [
            'status' => $response->status(),
            'error' => $data['message'] ?? 'Erro desconhecido',
        ]);

        return [
            'success' => false,
            'error' => $data['message'] ?? 'Erro ao processar requisição',
            'status' => $response->status(),
        ];
    }

    private function exceptionResponse(\Exception $e, $message)
    {
        Log::error($message, [
            'exception' => $e->getMessage(),
        ]);

        return [
            'success' => false,
            'error' => $message,
        ];
    }

    public function healthCheck()
    {
        try {
            $response = Http::timeout(5)->get("{$this->baseUrl}/health");
            return $response->successful();
        } catch (\Exception $e) {
            return false;
        }
    }
}
