<?php

declare(strict_types=1);

namespace Koneko\VuexyWebsiteAdmin\Models;

use Illuminate\Database\Eloquent\Model;
use Koneko\VuexyWebsiteAdmin\Application\Enums\WebsiteSeoProfile\WebsiteSeoProfileScope;
use Koneko\VuexyWebsiteAdmin\Application\Enums\WebsiteSeoProfile\MetaMode;

class WebsiteSeoProfile extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'scope',
        'schema_mode','schema_org',
        'favicon_mode','favicon',
        'locale_mode','locale',
        'og_mode','og_type','og_title','og_description','og_image','og_url','og_site_name',
        'twitter_mode','twitter_card','twitter_title','twitter_description','twitter_image','twitter_site','twitter_creator',
        'seoable_type','seoable_id',
    ];

    protected $casts = [
        'scope'      => WebsiteSeoProfileScope::class,
        'schema_mode'  => MetaMode::class,
        'favicon_mode' => MetaMode::class,
        'locale_mode'  => MetaMode::class,
        'og_mode'      => MetaMode::class,
        'twitter_mode' => MetaMode::class,
        'schema_org' => 'array',
        'favicon'    => 'array',
    ];



    public function seoable() {
        return $this->morphTo();
    }

}
