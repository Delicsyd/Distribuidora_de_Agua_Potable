<?php

namespace App\Services;

use Cloudinary\Cloudinary;
use Illuminate\Http\UploadedFile;
use RuntimeException;

class CloudinaryImageService
{
    public function subir(UploadedFile $imagen, string $carpeta = 'distribuidora'): string
    {
        $cloudName = config('services.cloudinary.cloud_name');
        $apiKey = config('services.cloudinary.api_key');
        $apiSecret = config('services.cloudinary.api_secret');

        if (!$cloudName || !$apiKey || !$apiSecret) {
            throw new RuntimeException(
                'Configura CLOUDINARY_CLOUD_NAME, CLOUDINARY_API_KEY y CLOUDINARY_API_SECRET en .env.'
            );
        }

        $cloudinary = new Cloudinary([
            'cloud' => [
                'cloud_name' => $cloudName,
                'api_key' => $apiKey,
                'api_secret' => $apiSecret,
            ],
            'url' => [
                'secure' => true,
            ],
        ]);

        $respuesta = $cloudinary->uploadApi()->upload($imagen->getRealPath(), [
            'folder' => $carpeta,
        ]);

        $url = $respuesta['secure_url'] ?? null;

        if (!is_string($url) || $url === '') {
            throw new RuntimeException('Cloudinary no devolvió la URL segura de la imagen.');
        }

        return $url;
    }
}
