<?php

declare(strict_types=1);

namespace Koneko\VuexyWebsiteAdmin\Application\Enums\WebsiteSeoProfile;

enum WebsiteSeoProfileType: string
{
    case Page      = 'page';
    case Landing   = 'landing';
    case Product   = 'product';
    case Category  = 'category';
    case Blog      = 'blog';
}
