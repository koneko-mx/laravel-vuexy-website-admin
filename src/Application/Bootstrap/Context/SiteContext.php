<?php

namespace Koneko\VuexyWebsiteAdmin\Application\Bootstrap\Context;

use Illuminate\Http\Request;
use Koneko\VuexyWebsiteAdmin\Models\{WebsiteContent, WebsiteSite, WebsiteTemplate, WebsiteSeoProfile};

/**
 * 🧠 Resolve contexto de sitio activo en modo multisite
 */
class SiteContext
{
    public ?WebsiteSite $website = null;
    public ?WebsiteContent $content = null;
    public ?WebsiteTemplate $template = null;
    public ?WebsiteSeoProfile $seo_profile = null;

    public function __construct(Request $request)
    {
        $host = ltrim($request->getHost(), 'www.');
        $this->website = WebsiteSite::where('domain', $host)->first();

        if (!$this->website) {
            return;
        }

        $slug = (string) $request->route('slug');

        $this->content = WebsiteContent::where('site_id', $this->website->id)
            ->bySlug($slug)
            ->first();

        $this->template    = $this->content->template ?? $this->website->template;
        $this->seo_profile = $this->content->seo_profile;
    }

    /*
    public function getTemplate(): ?WebsiteTemplate
    {
        return $this->template;
    }

    public function getContent(): ?WebsiteContent
    {
        return $this->content;
    }

    public function getWebsite(): ?WebsiteSite
    {
        return $this->website;
    }
    */

    public function getLayout(): array
    {
        return [
            'package'     => $this->template->package,
            'template'    => $this->template->layout,
            'theme-color' => $this->template->theme_color,
        ];
    }

    public function getSeo(): array
    {
        return [
            'title'       => $this->getTitle(),
            'description' => $this->content->description ?? $this->website->description,
            'keywords'    => $this->content->keywords,
            'author'      => $this->getAuthor(),
            'copyright'   => $this->getCopyright(),
            'robots'      => $this->getRobots(),
            'language'    => $this->content->locale ?? $this->seo_profile->locale,
            'canonical'   => $this->content->canonical,
            'hreflangs'   => $this->getHreflangs(),
            'og'          => $this->getOg(),
            'twitter'     => $this->getTwitter(),
            'favicon'     => $this->getFavicon(),
            'theme-color' => $this->template->theme_color,
            'manifest'    => $this->getManifest(),
            'ld+json'     => $this->getLdJson(),
        ];
    }

    public function getSocial(): array
    {
        return [];
    }

    public function getContact(): array
    {
        return [];
    }

    public function getContent(): string
    {
        return '';
    }

    public function getHeaderBlocks(): array
    {
        return $this->content->header_blocks ?? [];
    }

    public function getContentBlocks(): array
    {
        return $this->content->content_blocks ?? [];
    }

    public function getFooterBlocks(): array
    {
        return $this->content->footer_blocks ?? [];
    }


    private function getFavicon(): array
    {
        return [];
    }

    private function getManifest(): array
    {
        return [];
    }

    private function getOg(): array
    {
        return [];
    }

    private function getTwitter(): array
    {
        return [];
    }

    private function getHreflangs(): array
    {
        return [];
    }

    private function getLdJson(): array
    {
        return [];
    }

    private function getRobots(): string
    {
        $index  = !$this->website->noindex;
        $follow = !$this->website->nofollow;

        if ($this->website->allow_overwrite_robots) {
            $index  = !$this->content->noindex;
            $follow = !$this->content->nofollow;
        }

        return $index ? 'index' : 'noindex' . ', ' . ($follow ? 'follow' : 'nofollow');
    }

    private function getTitle(): string
    {
        $title = trim($this->content->title);

        return $this->website->title . ($title ? ' | ' . $title : '');
    }

    private function getAuthor(): string
    {
        return $this->content->author ?? $this->website->author;
    }

    private function getCopyright(): string
    {
        return $this->content->copyright ?? $this->website->copyright;
    }

    /**
     * Devuelve el sitio actual (usando cache interna si ya fue resuelto)
     */
    /*
    public function resolve(): ?WebsiteContent
    {
        return static::$resolved;
    }
    */

    /**
     * Resuelve el sitio activo desde el request actual (dominio o path)
     */
    /*
    public function resolveFromRequest(Request $request): bool
    {
        $host = ltrim($request->getHost(), 'www.');
        $site = WebsiteSite::where('domain', $host)->first();

        if (!$site) {
            return false;
        }

        $slug    = (string) $request->route('slug');
        $content = WebsiteContent::where('site_id', $site->id)
            ->bySlug($slug)
            ->first();

        if (!$content) {
            return false;
        }

        // Establece contexto (null si no hay match)
        $this->resolved = $content;

        return true;
    }
    */

}
