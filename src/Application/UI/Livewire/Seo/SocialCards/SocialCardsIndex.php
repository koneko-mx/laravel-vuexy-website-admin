<?php

declare(strict_types=1);

namespace Koneko\VuexyWebsiteAdmin\Application\UI\Livewire\Seo\SocialCards;

use Livewire\Component;
use Koneko\VuexyWebsiteAdmin\Models\SitemapUrl;

class SocialCardsIndex extends Component
{
    public $urls, $newUrl, $changefreq = 'weekly', $priority = 0.5;

    public function mount()
    {
        $this->urls = SitemapUrl::all();
    }

    public function addUrl()
    {
        SitemapUrl::create([
            'url' => $this->newUrl,
            'changefreq' => $this->changefreq,
            'priority' => $this->priority,
            'lastmod' => now()
        ]);
        $this->reset(['newUrl', 'changefreq', 'priority']);
        $this->mount();
    }

    public function deleteUrl($id)
    {
        SitemapUrl::find($id)->delete();
        $this->mount();
    }

    public function render()
    {
        return view('vuexy-website-admin::livewire.seo.social-cards.index', ['urls' => $this->urls]);
    }}
