<?php

declare(strict_types=1);

namespace Koneko\VuexyWebsiteAdmin\Application\UI\Livewire\Sites\Social;

use Livewire\Component;
use Livewire\Attributes\Rule;
use Koneko\VuexyAdmin\Application\Settings\Manager\KonekoSettingManager;
use Koneko\VuexyWebsiteAdmin\Application\LocalModule as WebsiteModule;
use Koneko\VuexyWebsiteAdmin\Models\WebsiteSite;

final class SocialCard extends Component
{
    public WebsiteSite $site;

    public string $targetNotify = '#website-social-settings-card .notification-container';

    private const GROUP   = 'social';
    private const SECTION = 'website';
    private const SUBGROUP = 'links';

    // WhatsApp
    #[Rule('nullable|string|min:8|max:20')]
    public string $whatsapp_phone = '';

    #[Rule('nullable|string|max:500')]
    public string $whatsapp_message = '';

    // Almacena URL lista para templates (se genera en save)
    public string $whatsapp = '';

    // Otros links (URLs completas normalizadas)
    #[Rule('nullable|string|max:300')]
    public string $facebook = '';

    #[Rule('nullable|string|max:300')]
    public string $instagram = '';

    #[Rule('nullable|string|max:300')]
    public string $linkedin = '';

    #[Rule('nullable|string|max:300')]
    public string $tiktok = '';

    #[Rule('nullable|string|max:300')]
    public string $x_twitter = '';

    #[Rule('nullable|string|max:300')]
    public string $google = '';

    #[Rule('nullable|string|max:300')]
    public string $pinterest = '';

    #[Rule('nullable|string|max:300')]
    public string $youtube = '';

    #[Rule('nullable|string|max:300')]
    public string $vimeo = '';

    public function mount(WebsiteSite $site): void
    {
        $this->site = $site;
        $this->loadForm();
    }

    private function settings(): KonekoSettingManager
    {
        return settings(WebsiteModule::class)
            ->context(self::GROUP, self::SECTION, self::SUBGROUP)
            ->scope($this->site);
    }

    public function loadForm(): void
    {
        $data = $this->settings()->asArray()->all();

        // WhatsApp (intentamos compatibilidad si ya hay URL guardada)
        $this->whatsapp          = (string)($data['whatsapp'] ?? '');
        $this->whatsapp_phone    = (string)($data['whatsapp_phone'] ?? '');
        $this->whatsapp_message  = (string)($data['whatsapp_message'] ?? '');

        if ($this->whatsapp && (!$this->whatsapp_phone || !$this->whatsapp_message)) {
            $parsed = $this->parseWaLink($this->whatsapp);
            if ($parsed) {
                [$phone, $msg] = $parsed;
                $this->whatsapp_phone = $this->whatsapp_phone ?: $phone;
                $this->whatsapp_message = $this->whatsapp_message ?: $msg;
            }
        }

        // Otros
        $this->facebook  = (string)($data['facebook'] ?? '');
        $this->instagram = (string)($data['instagram'] ?? '');
        $this->linkedin  = (string)($data['linkedin'] ?? '');
        $this->tiktok    = (string)($data['tiktok'] ?? '');
        $this->x_twitter = (string)($data['x_twitter'] ?? '');
        $this->google    = (string)($data['google'] ?? '');
        $this->pinterest = (string)($data['pinterest'] ?? '');
        $this->youtube   = (string)($data['youtube'] ?? '');
        $this->vimeo     = (string)($data['vimeo'] ?? '');

        if ($this->whatsapp_message === '') {
            $this->whatsapp_message = 'Hola 👋, vengo de {site}. Estoy viendo “{title}”. ¿Podrías ayudarme?';
        }
    }

    public function save(): void
    {
        // Normaliza WhatsApp
        $phone = $this->normalizePhone($this->whatsapp_phone);
        $msg   = trim($this->whatsapp_message);
        $this->whatsapp_phone   = $phone;
        $this->whatsapp_message = $msg;
        $this->whatsapp         = $phone ? $this->buildWaLink($phone, $msg) : '';

        // Normaliza URLs/handles
        $this->facebook  = $this->normalizeSocial($this->facebook, 'facebook');
        $this->instagram = $this->normalizeSocial($this->instagram, 'instagram');
        $this->linkedin  = $this->normalizeSocial($this->linkedin, 'linkedin');
        $this->tiktok    = $this->normalizeSocial($this->tiktok, 'tiktok');
        $this->x_twitter = $this->normalizeSocial($this->x_twitter, 'x');
        $this->google    = $this->normalizeUrl($this->google);
        $this->pinterest = $this->normalizeSocial($this->pinterest, 'pinterest');
        $this->youtube   = $this->normalizeSocial($this->youtube, 'youtube');
        $this->vimeo     = $this->normalizeSocial($this->vimeo, 'vimeo');

        // Validación condicional (solo si hay contenido)
        $rules = [
            'whatsapp_phone'   => ['nullable','string','regex:/^[+]?[1-9][0-9]{7,14}$/'],
            'whatsapp_message' => ['nullable','string','max:500'],
            'whatsapp'         => ['nullable','url'],
            'facebook'         => ['nullable','url'],
            'instagram'        => ['nullable','url'],
            'linkedin'         => ['nullable','url'],
            'tiktok'           => ['nullable','url'],
            'x_twitter'        => ['nullable','url'],
            'google'           => ['nullable','url'],
            'pinterest'        => ['nullable','url'],
            'youtube'          => ['nullable','url'],
            'vimeo'            => ['nullable','url'],
        ];
        $messages = [
            'whatsapp_phone.regex' => 'Usa formato internacional E.164, ej. +525512345678.',
        ];
        $this->validate($rules, $messages);

        // Persistencia
        $s = $this->settings();
        $s->set('whatsapp_phone', $this->whatsapp_phone);
        $s->set('whatsapp_message', $this->whatsapp_message);
        $s->set('whatsapp', $this->whatsapp);
        $s->set('facebook', $this->facebook);
        $s->set('instagram', $this->instagram);
        $s->set('linkedin', $this->linkedin);
        $s->set('tiktok', $this->tiktok);
        $s->set('x_twitter', $this->x_twitter);
        $s->set('google', $this->google);
        $s->set('pinterest', $this->pinterest);
        $s->set('youtube', $this->youtube);
        $s->set('vimeo', $this->vimeo);

        $this->dispatch('notification', target: $this->targetNotify, type: 'success', message: 'Se han guardado los cambios.');
        $this->dispatch('site-social-updated', id: $this->site->id);
    }

    public function resetForm(): void
    {
        $this->resetValidation();
        $this->loadForm();
        $this->dispatch('notification', target: $this->targetNotify, type: 'info', message: 'Cambios descartados.');
    }

    public function render()
    {
        return view('vuexy-website-admin::livewire.sites.social.social-card');
    }

    /* ---------------- Helpers ---------------- */

    private function normalizePhone(string $raw): string
    {
        $v = preg_replace('/[^0-9+]/', '', trim($raw));
        // quita 00 inicial → +
        if (str_starts_with($v, '00')) $v = '+' . substr($v, 2);
        return $v;
    }

    private function buildWaLink(string $phone, string $message): string
    {
        $p = preg_replace('/[^0-9]/', '', $phone); // wa.me no acepta +
        $msg = rawurlencode($message ?: ''); // deja macros encoded (%7Bsite%7D...)
        return $p ? "https://wa.me/{$p}" . ($msg ? "?text={$msg}" : '') : '';
    }

    private function parseWaLink(string $url): ?array
    {
        if (!str_contains($url, 'wa.me')) return null;
        $parts = parse_url($url);
        $phone = '';
        if (!empty($parts['path'])) $phone = ltrim($parts['path'], '/');
        $msg = '';
        if (!empty($parts['query'])) {
            parse_str($parts['query'], $q);
            $msg = isset($q['text']) ? (string)urldecode($q['text']) : '';
        }
        return [$phone, $msg];
    }

    private function normalizeUrl(?string $raw): string
    {
        $u = trim((string)$raw);
        if ($u === '') return '';
        if (!preg_match('~^https?://~i', $u)) $u = 'https://' . $u;
        return $u;
    }

    private function normalizeSocial(?string $raw, string $provider): string
    {
        $v = trim((string)$raw);
        if ($v === '') return '';
        // Si viene como @handle o solo handle → a URL canónica
        $handle = ltrim($v, '@');
        // Si ya parece URL, devuelve normalizada
        if (preg_match('~^https?://~i', $v)) return $this->normalizeUrl($v);

        return match ($provider) {
            'facebook'  => $this->normalizeUrl('facebook.com/' . $handle),
            'instagram' => $this->normalizeUrl('instagram.com/' . $handle),
            'linkedin'  => $this->normalizeUrl('linkedin.com/in/' . $handle), // ajusta a /company/ si usas páginas
            'tiktok'    => $this->normalizeUrl('tiktok.com/@' . $handle),
            'x'         => $this->normalizeUrl('x.com/' . $handle),
            'pinterest' => $this->normalizeUrl('pinterest.com/' . $handle),
            'youtube'   => $this->normalizeUrl('youtube.com/@' . $handle), // o /c/ o /channel/
            'vimeo'     => $this->normalizeUrl('vimeo.com/' . $handle),
            default     => $this->normalizeUrl($v),
        };
    }
}
