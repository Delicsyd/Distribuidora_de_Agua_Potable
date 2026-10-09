<?php

namespace App\Services;

use Cloudinary\Cloudinary;
use Illuminate\Http\UploadedFile;
use RuntimeException;

class CloudinaryImageService
{
    public function subir(UploadedFile $imagen): string
    {
        if (!$imagen->isValid()) {
            throw new RuntimeException('La imagen no es válida.');
        }

        $cloudinary = new Cloudinary([
            'cloud' => [
                'cloud_name' => config('services.cloudinary.cloud_name'),
                'api_key' => config('services.cloudinary.api_key'),
                'api_secret' => config('services.cloudinary.api_secret'),
            ],
            'url' => [
                'secure' => true,
            ],
        ]);

        $resultado = $cloudinary->uploadApi()->upload(
            $imagen->getRealPath(),
            [
                'folder' => 'distribuidora_agua_potable',
                'resource_type' => 'image',
            ]
        );

        $url = $resultado['secure_url'] ?? null;

        if (!$url || !filter_var($url, FILTER_VALIDATE_URL)) {
            throw new RuntimeException('Cloudinary no devolvió una URL válida.');
        }

        return $url;
    }
}