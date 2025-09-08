<?php

declare(strict_types=1);

namespace Koneko\VuexyWebsiteAdmin\Application\Enums\WebsiteSeoProfile;

enum WebsiteSeoProfileMetaMode: string
{
    case Site    = 'site';
    case Content = 'content';
    case Disable = 'disable';
}
