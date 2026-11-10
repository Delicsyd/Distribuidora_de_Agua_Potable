<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Marca;
use App\Models\Presentacion;
use App\Services\CloudinaryImageService;
use Cloudinary\Api\Exception\ApiError;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use RuntimeException;

abstract class DemoCrudController extends Controller
{
    protected string $modulo;

    protected string $ruta;

    protected string $vista;

    protected string $modelo;

    protected array $campos = [];

    protected function validar(Request $request, array $reglas, array $mensajes = []): array
    {
        return Validator::make($request->all(), $reglas, $mensajes)->validate();
    }

    protected function datosVista(array $adicionales = []): array
    {
        $campos = $this->camposConOpciones();
        $opcionesFaltantes = collect($campos)
            ->filter(fn (array $campo) => $campo['tipo'] === 'select'
                && ! empty($campo['obligatorio'])
                && empty($campo['opciones']))
            ->pluck('etiqueta')
            ->values()
            ->all();

        return array_merge([
            'modulo' => $this->modulo,
            'ruta' => $this->ruta,
            'modelo' => class_basename($this->modelo),
            'campos' => $campos,
            'opcionesFaltantes' => $opcionesFaltantes,
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
        $mensajes = [];
        foreach ($campos as $campo) {
            $mensajes[$campo.'.image'] = 'El archivo debe ser una imagen válida.';
            $mensajes[$campo.'.mimes'] = 'La imagen debe estar en formato JPG, JPEG, PNG o WEBP.';
            $mensajes[$campo.'.max'] = 'La imagen no debe superar los 5 MB.';
        }
        $this->validar($request, $reglas, $mensajes);

        $imagenes = [];
        $servicio = app(CloudinaryImageService::class);

        foreach ($campos as $campo) {
            if ($request->hasFile($campo)) {
                try {
                    $imagenes[$campo] = $servicio->subir(
                        $request->file($campo),
                        'distribuidora/'.$this->modulo
                    );
                } catch (RuntimeException|ApiError|GuzzleException $exception) {
                    report($exception);

                    throw ValidationException::withMessages([
                        $campo => 'No fue posible subir la imagen. Inténtalo de nuevo o elige otro archivo.',
                    ]);
                }
            }
        }

        return $imagenes;
    }

    protected function normalizarEstado(mixed $estado, int $predeterminado = 1): int
    {
        if ($estado === null || $estado === '') {
            return $predeterminado;
        }

        return in_array(strtolower((string) $estado), ['1', 'activo', 'true', 'on'], true) ? 1 : 0;
    }

    protected function actualizarImagenes(Request $request, array $datos, array $campos): array
    {
        $imagenes = $this->subirImagenes($request, $campos);

        foreach ($campos as $campo) {
            if (! array_key_exists($campo, $imagenes)) {
                unset($datos[$campo]);
            }
        }

        return array_merge($datos, $imagenes);
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
                'clientes', 'categorias', 'marcas', 'presentaciones', 'productos' => [
                    1 => 'Activo',
                    0 => 'Inactivo',
                ],
                default => [
                    'activo' => 'Activo',
                    'inactivo' => 'Inactivo',
                ],
            };
        }

        return match ($nombre) {
            'categoria_id' => Categoria::query()->orderBy('nombre')->pluck('nombre', 'id')->all(),
            'presentacion_id' => Presentacion::query()->orderBy('nombre')->pluck('nombre', 'id')->all(),
            'marca_id' => Marca::query()->orderBy('nombre')->pluck('nombre', 'id')->all(),
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
