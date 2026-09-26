<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __call($method, $parameters)
    {
        $aliases = [
            'registar' => 'registrar',
            'vistaMostrar' => 'vistaMostarr',
        ];

        if (isset($aliases[$method]) && method_exists($this, $aliases[$method])) {
            return $this->{$aliases[$method]}(...$parameters);
        }

        return parent::__call($method, $parameters);
    }
}
