<?php

declare(strict_types=1);

namespace Koneko\VuexyWebsiteAdmin\Application\UI\Livewire\Sites\General;

use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\Validation\Rule as VRule;
use Koneko\VuexyWebsiteAdmin\Application\Enums\WebsiteContents\WebsiteContentStatus;
use Koneko\VuexyWebsiteAdmin\Application\Enums\Websites\WebsiteSiteStatus;
use Koneko\VuexyWebsiteAdmin\Models\WebsiteContent;
use Koneko\VuexyWebsiteAdmin\Models\WebsiteSite;
use Livewire\Attributes\Rule;
use Livewire\Component;

final class VisibilitySecurityCard extends Component
{
    /** Mantén solo el ID del modelo */
    public int $siteId;

    /** Notificaciones (público para poder usarlo en la vista/JS si lo deseas) */
    public string $targetNotify = '#website-visibility-security-card .notification-container';

    /** Campos del form */
    #[Rule('boolean')]
    public bool $prevent_indexed = false;

    #[Rule('boolean')]
    public bool $www_redirect = false;

    #[Rule('boolean')]
    public bool $force_https = false;

    #[Rule('integer|nullable')]
    public ?int $coming_soon_content_id = null;

    #[Rule('integer|nullable')]
    public ?int $maintenance_content_id = null;

    /** Usamos string (backed enum value) para facilitar el <select> */
    public string $status = '';

    public $status_options = [],
        $contents_options = [];

    public function mount(WebsiteSite $site) : void
    {
        $this->siteId = (int) $site->id;

        // Opciones (asumiendo que options() retorna [['label'=>..., 'value'=>...], ...])
        $this->status_options = WebsiteSiteStatus::options();

        // Carga inicial (si $site->status es enum, tomar ->value)
        $this->prevent_indexed = (bool) $site->prevent_indexed;
        $this->www_redirect    = (bool) $site->www_redirect;
        $this->force_https     = (bool) $site->force_https;

        $this->coming_soon_content_id = $site->coming_soon_content_id;
        $this->maintenance_content_id = $site->maintenance_content_id;
        $this->status          = $site->status instanceof WebsiteSiteStatus
            ? $site->status->value
            : (string) $site->status;

        $this->contents_options = WebsiteContent::where('site_id', $site->id)
            ->where(function ($query) {
                $query->where('status', WebsiteContentStatus::Published)
                    ->orWhere('status', WebsiteContentStatus::Hidden);
            })
            ->orderBy('title', 'asc')
            ->pluck('title', 'id')->toArray();
    }

    public function save() : void
    {
        // Valida booleans por atributos; status con in: dinámico
        $this->validate();
        $this->validate([
            'status' => [ 'required', 'string', VRule::in($this->statusValues()) ],
        ]);

        // Carga fresca
        $site = WebsiteSite::query()->findOrFail($this->siteId);

        $site->update([
            'prevent_indexed' => $this->prevent_indexed,
            'www_redirect'    => $this->www_redirect,
            'force_https'     => $this->force_https,
            'coming_soon_content_id' => $this->coming_soon_content_id ?? null,
            'maintenance_content_id' => $this->maintenance_content_id ?? null,
            'status'          => WebsiteSiteStatus::from($this->status),
        ]);

        $this->dispatch(
            'notification',
            target: $this->targetNotify,
            type: 'success',
            message: 'Se han guardado los cambios en las configuraciones.'
        );

        // Opcional: limpiar errores si mostrabas mensajes debajo de inputs
        // $this->resetValidation();
    }

    public function resetForm(): void
    {
        $site = WebsiteSite::query()->findOrFail($this->siteId);

        $this->prevent_indexed = (bool) $site->prevent_indexed;
        $this->www_redirect    = (bool) $site->www_redirect;
        $this->force_https     = (bool) $site->force_https;
        $this->status          = $site->status instanceof WebsiteSiteStatus
            ? $site->status->value
            : (string) $site->status;

        $this->resetValidation();
    }

    public function render() : ViewContract
    {
        return view('vuexy-website-admin::livewire.sites.general.visibility-security-card');
    }

    /** Valores válidos del enum para la regla in: */
    private function statusValues(): array
    {
        // Si tu enum es backed, esto retorna ['draft','published',...]
        return array_map(fn ($case) => $case->value, WebsiteSiteStatus::cases());
    }
}
