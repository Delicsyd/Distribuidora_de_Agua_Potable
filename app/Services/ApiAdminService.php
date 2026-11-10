<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

class ApiAdminService
{
    private function cliente()
    {
        return Http::acceptJson()
            ->withToken(session('api_admin_token'));
    }

    public function get(string $recurso, ?int $id = null)
    {
        $url = config('services.api_admin.url') . '/' . $recurso;

        if ($id !== null) {
            $url .= '/' . $id;
        }

        return $this->cliente()->get($url);
    }

    public function post(string $recurso, array $datos)
    {
        $url = config('services.api_admin.url') . '/' . $recurso;

        return $this->cliente()->post($url, $datos);
    }
    public function postConImagenes(string $recurso, array $datos)
    {
        $url = config('services.api_admin.url') . '/' . $recurso;

        return $this->enviarFormData($url, $datos);
    }

    public function put(string $recurso, int $id, array $datos)
    {
        $url = config('services.api_admin.url') . '/' . $recurso . '/' . $id;

        return $this->cliente()->put($url, $datos);
    }

    public function putConImagenes(string $recurso, int $id, array $datos)
    {
        $url = config('services.api_admin.url') . '/' . $recurso . '/' . $id;

        return $this->enviarFormData($url, $datos, true);
    }

    private function enviarFormData(string $url, array $datos, bool $actualizar = false)
    {
        $peticion = $this->cliente();
        $campos = [];

        foreach ($datos as $campo => $valor) {
            if ($valor instanceof \Illuminate\Http\UploadedFile) {
                if (!$valor->isValid()) {
                    throw ValidationException::withMessages([
                        $campo => 'No fue posible cargar la imagen seleccionada.',
                    ]);
                }

                $peticion->attach(
                    $campo,
                    $valor->get(),
                    $valor->getClientOriginalName()
                );

                continue;
            }

            $campos[$campo] = $valor;
        }

        if ($actualizar) {
            $campos['_method'] = 'PUT';
        }

        return $peticion->post($url, $campos);
    }

    public function delete(string $recurso, int $id)
    {
        $url = config('services.api_admin.url') . '/' . $recurso . '/' . $id;

        return $this->cliente()->delete($url);
    }
}
