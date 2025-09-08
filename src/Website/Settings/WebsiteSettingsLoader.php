<?php

declare(strict_types=1);

namespace Koneko\VuexyWebsiteAdmin\Website\Settings;

use Illuminate\Support\Facades\Storage;
use Koneko\VuexyAdmin\Application\Cache\Manager\KonekoCacheManager;
use Koneko\VuexyAdmin\Application\Settings\Manager\KonekoSettingManager;
use Koneko\VuexyWebsiteAdmin\Application\Template\WebsiteImageHandler;
use Koneko\VuexyWebsiteAdmin\Models\WebsiteSite;

/**
 * Carga y cachea TODOS los settings del sitio agrupados por subgrupos.
 * - Lee de KonekoSettingManager (component: website-admin)
 * - Cachea un bloque agregado por sitio (clave estable)
 */
final class WebsiteSettingsLoader
{
    private WebsiteSite $site;

    private $namespace;
    private CONST COMPONENT = 'website-admin';
    private CONST GROUP     = 'layout';

    private function __construct(WebsiteSite $site)
    {
        $this->site      = $site;
        $this->namespace = config('koneko.namespace', 'koneko');
    }

    public static function forSite(WebsiteSite $site): self
    {
        return new self($site);
    }

    /**
     * Devuelve arreglo normalizado y cacheado.
     * Estructura:
     *   [
     *     'contact' => ['info'=>[], 'form'=>[], 'location'=>[], 'branches'=>[]],
     *     'social'  => ['links'=>[]],
     *     'chat'    => ['default'=>[], 'whatsapp'=>[], 'crisp'=>[], 'tawkto'=>[], 'tidio'=>[], 'livechat'=>[]],
     *     'api'     => ['google'=>[], 'meta'=>[], 'twitter'=>[]],
     *   ]
     */
    public function load(bool $forceReload = false): array
    {
        $cache = $this->cacheRepo();
        if ($forceReload) {
            $cache->forget();
        }

        return $cache->remember(function (): array {

            return [
                'contact' => [
                    'info'     => $this->read('contact', 'info'),
                    'form'     => $this->read('contact', 'form'),
                    'location' => $this->read('contact', 'location'),
                    'branches' => $this->read('contact', 'branches') + ['items' => []],
                ],
                'social' => [
                    'links' => $this->read('social', 'links'),
                ],
                'chat' => [
                    'default'  => $this->read('chat', 'default'),
                    'whatsapp' => $this->read('chat', 'whatsapp'),
                    'crisp'    => $this->read('chat', 'crisp'),
                    'tawkto'   => $this->read('chat', 'tawkto'),
                    'tidio'    => $this->read('chat', 'tidio'),
                    'livechat' => $this->read('chat', 'livechat'),
                ],
                'api' => [
                    'google'  => $this->read('api', 'google'),
                    'meta'    => $this->read('api', 'meta'),
                    'twitter' => $this->read('api', 'twitter'),
                ],
                'img' => $this->getImgs(),
            ];
        });
    }

    private function read(string $section, string $subgroup): array
    {
        return KonekoSettingManager::make()
            ->namespace($this->namespace)
            ->environment()
            ->component(self::COMPONENT)
            ->context(self::GROUP, $section, $subgroup)
            ->scope($this->site)
            ->asArray()
            ->all();
    }

    private function getImgs(): array
    {
        $variants = [
            'logo'        => 'default',
            'logo_h'      => 'h_default',
            'logo_dark'   => 'dark',
            'logo_h_dark' => 'h_dark',
        ];

        $imgs = [];

        foreach($variants as $variant => $keyName ){
            foreach($this->read('logo', $keyName) as $size => $img){
                if($size !== 'base64')
                    $imgs[$variant][$size] = Storage::url(WebsiteImageHandler::LOGO_BASE_PATH . $img);
            }
        }

        return $imgs;
    }

    private function cacheRepo(): KonekoCacheManager
    {
        // Clave de bloque de settings por sitio (estable y versionable)
        return KonekoCacheManager::make([
            'namespace'   => $this->namespace,
            'environment' => app()->environment(),
            'component'   => self::COMPONENT,
            'group'       => self::GROUP,
            'section'     => 'settings',
            'sub_group'   => 'aggregate',
            'key_name'    => 'v1', // bump si cambias estructura de retorno
            'scope'       => $this->site,
        ]);
    }
}
