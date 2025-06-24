<?php

declare(strict_types=1);

namespace Koneko\VuexyWebsiteAdmin\Application\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class WebsitePageController extends Controller
{
    /**
     * Renderiza la página pública principal.
     */
    public function __invoke(Request $request, ?string $slug = null)
    {
        $template = View::shared('_layout.template') ?? 'layout-simple-koneko-samuel-coming-soon';
        $view     = "{$template}::page";

        if (!View::exists($view)) {
            abort(404, "Plantilla no encontrada: {$view}");
        }

        return view($view);
    }

    /**
     * Vista previa segura firmada.
     */
    public function preview(Request $request, string $slug)
    {
        if (! $request->hasValidSignature()) {
            abort(403, 'Firma de vista previa no válida.');
        }

        $template = View::shared('_template') ?? 'anonymous_template';
        $type     = View::shared('_variant') ?? 'page';
        $view     = "{$template}::{$type}";

        if (!View::exists($view)) {
            abort(404, "Plantilla de vista previa no encontrada: {$view}");
        }

        return view($view);
    }
}
