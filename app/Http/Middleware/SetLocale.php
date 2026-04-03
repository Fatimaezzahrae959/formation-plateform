<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        // 1. Vérifier si la langue est dans l'URL (ex: /fr/formations)
        if ($request->segment(1) && in_array($request->segment(1), ['fr', 'en'])) {
            $locale = $request->segment(1);
            Session::put('locale', $locale);
            App::setLocale($locale);

            // Stocker la langue dans le request pour les routes
            $request->attributes->set('locale', $locale);
        }
        // 2. Sinon, prendre de la session ou défaut
        else {
            $locale = Session::get('locale', 'fr');
            App::setLocale($locale);
        }

        return $next($request);
    }
}