<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Exception;

class BaserowService
{
    /**
     * Sube un archivo a Baserow y retorna la URL pública.
     *
     * @param UploadedFile $file
     * @return string URL de la imagen en Baserow
     * @throws Exception
     */
    public function uploadFile(UploadedFile $file): string
    {
        $apiUrl = env('BASEROW_API_URL', 'https://api.baserow.io/api');
        $token = env('BASEROW_TOKEN');

        if (!$token) {
            throw new Exception('Falta el token de Baserow en el archivo .env');
        }

        // Subir a Baserow
        $response = Http::withHeaders([
            'Authorization' => 'Token ' . $token
        ])->attach(
            'file', file_get_contents($file->getRealPath()), $file->getClientOriginalName()
        )->post("{$apiUrl}/user-files/upload-file/");

        if ($response->successful()) {
            return $response->json('url');
        }

        throw new Exception('Error al subir imagen a Baserow: ' . $response->body());
    }
}
