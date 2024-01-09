<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Categoria;
use App\Models\Factura;
use App\Models\User;
use App\Policies\CategoriaPolicy;
use App\Policies\FacturaPolicy;
use Illuminate\Auth\Access\Response;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Categoria::class => CategoriaPolicy::class,
        Factura::class => FacturaPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Gate::define('update-categoria', function (User $user) {
        //     return $user->name == 'admin'
        //         ? Response::allow()
        //         : Response::deny('Tienes que ser el usuario admin');
        // });
    }
}
