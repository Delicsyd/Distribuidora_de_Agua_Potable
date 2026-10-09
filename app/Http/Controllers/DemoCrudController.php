<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CloudinaryImageService;

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
            'campos' => $this->camposConOpciones(),
        ], $adicionales);
    }

    protected function ver(string $pagina, array $adicionales = [])
    {
        $vista = $this->vista.'.'.$pagina;

        return view()->exists($vista)
            ? view($vista, $this->datosVista($adicionales))
            : view('crud.'.$pagina, $this->datosVista($adicionales));
    }

    protected function subirImagenes(Request $request, array $campos): array
    {
        $reglas = array_fill_keys($campos, 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120');
        $request->validate($reglas);

        $imagenes = [];
        $servicio = app(CloudinaryImageService::class);

        foreach ($campos as $campo) {
            if ($request->hasFile($campo)) {
                $imagenes[$campo] = $servicio->subir(
                    $request->file($campo),
                    'distribuidora/'.$this->modulo
                );
            }
        }

        return $imagenes;
    }

    protected function respuestaConImagenes(string $accion, array $imagenes)
    {
        $estado = $this->respuestaDemo($accion);

        if ($imagenes !== []) {
            $estado .= ' Las imágenes sí se cargaron correctamente a Cloudinary.';
        }

        return redirect()->back()
            ->with('status', $estado)
            ->with('uploadedImages', $imagenes);
    }

    protected function registroDePrueba($id = 1): array
    {
        $registro = ['id' => $id];

        foreach ($this->camposConOpciones() as $nombre => $campo) {
            if ($campo['tipo'] === 'select') {
                $registro[$nombre] = array_key_first($campo['opciones']);
            } elseif ($campo['tipo'] === 'image') {
                $registro[$nombre] = null;
            } else {
                $registro[$nombre] = 'Dato de prueba';
            }
        }

        return $registro;
    }

    protected function camposConOpciones(): array
    {
        $campos = $this->campos;

        foreach ($campos as $nombre => &$campo) {
            if ($campo['tipo'] !== 'select' || isset($campo['opciones'])) {
                continue;
            }

            $campo['opciones'] = $this->opcionesPara($nombre);

            if ($campo['opciones'] === []) {
                throw new \LogicException("No hay opciones configuradas para el campo {$nombre}.");
            }
        }

        return $campos;
    }

    protected function opcionesPara(string $nombre): array
    {
        if ($nombre === 'estado') {
            return match ($this->modulo) {
                'pedidos' => [
                    'pendiente' => 'Pendiente de pago',
                    'confirmado' => 'Confirmado',
                    'preparando' => 'En preparación',
                    'enviado' => 'Enviado',
                    'entregado' => 'Entregado',
                    'cancelado' => 'Cancelado',
                ],
                'entregas' => [
                    'pendiente' => 'Pendiente',
                    'en_camino' => 'En camino',
                    'entregada' => 'Entregada',
                    'incidencia' => 'Incidencia reportada',
                ],
                'productos de pedidos' => [
                    'pendiente' => 'Pendiente de surtir',
                    'surtido' => 'Surtido',
                    'cancelado' => 'Cancelado',
                ],
                default => [
                    'activo' => 'Activo',
                    'inactivo' => 'Inactivo',
                ],
            };
        }

        return match ($nombre) {
            'categoria_id' => [
                1 => 'Agua purificada',
                2 => 'Agua mineral',
                3 => 'Accesorios para agua',
            ],
            'presentacion_id' => [
                1 => 'Garrafón de 20 litros',
                2 => 'Botella de 1 litro',
                3 => 'Paquete de botellas de 600 ml',
            ],
            'marca_id' => [
                1 => 'Agua Clara',
                2 => 'Manantial',
                3 => 'Pura Vida',
            ],
            'cliente_id' => [
                1 => 'María López',
                2 => 'Carlos Hernández',
                3 => 'Ana García',
            ],
            'metodo_pago_id' => [
                1 => 'Efectivo al recibir',
                2 => 'Tarjeta bancaria',
                3 => 'Transferencia bancaria',
            ],
            'pedido_id' => [
                1001 => 'Pedido #1001',
                1002 => 'Pedido #1002',
                1003 => 'Pedido #1003',
            ],
            'repartidor_id' => [
                1 => 'Juan Pérez',
                2 => 'Luis Hernández',
                3 => 'Pedro Ramírez',
            ],
            'direccion_id' => [
                1 => 'Casa - Zona Centro',
                2 => 'Oficina - Zona Norte',
                3 => 'Casa - Zona Sur',
            ],
            'producto_id' => [
                1 => 'Garrafón de agua de 20 litros',
                2 => 'Botella de agua de 1 litro',
                3 => 'Paquete de botellas de 600 ml',
            ],
            default => [],
        };
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
