<?php

namespace Aen233\IUSDK;

use Aen233\IUSDK\Http\Handlers\DocHandler;
use Aen233\IUSDK\Http\Handlers\LogHandler;
use Illuminate\Contracts\Routing\Registrar as Router;

class RouteRegistrar
{
    /**
     * The router implementation.
     *
     * @var \Illuminate\Contracts\Routing\Registrar
     */
    protected $router;

    /**
     * Create a new route registrar instance.
     *
     * @param  \Illuminate\Contracts\Routing\Registrar  $router
     * @return void
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * Register routes for transient tokens, clients, and personal access tokens.
     *
     * @return void
     */
    public function all()
    {
        $this->router->get('{modules}/doc/{name}', ['uses' => DocHandler::class]);
        $this->router->get('{modules}/log', ['uses' => LogHandler::class]);
    }
}
