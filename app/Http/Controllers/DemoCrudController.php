<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

abstract class DemoCrudController extends Controller
{
    protected string $modulo;
    protected string $ruta;
    protected string $vista;
    protected string $modelo;
    protected array $campos = [];

    protected function datosVista(array $adicionales = []): array
    {
        return array_merge([
            'modulo' => $this->modulo,
            'ruta' => $this->ruta,
            'modelo' => class_basename($this->modelo),
            'campos' => $this->campos,
        ], $adicionales);
    }

    protected function ver(string $pagina, array $adicionales = [])
    {
        return view($this->vista.'.'.$pagina, $this->datosVista($adicionales));
    }

    protected function registroDePrueba($id = 1): array
    {
        $registro = ['id' => $id];

        foreach ($this->campos as $nombre => $campo) {
            $registro[$nombre] = $campo['tipo'] === 'select'
                ? 'Opción de prueba'
                : 'Dato de prueba';
        }

        return $registro;
    }

    protected function registrosDePrueba(): array
    {
        return [$this->registroDePrueba()];
    }

    protected function respuestaDemo(string $accion): string
    {
        return strtoupper($this->modulo).' '.$accion.' (DEMOSTRACIÓN: NO SE GUARDARON CAMBIOS)';
    }
}
