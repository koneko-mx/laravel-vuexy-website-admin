<?php

declare(strict_types=1);

namespace Koneko\VuexyWebsiteAdmin\Application\Enums\WebsiteSeoProfile;

enum MetaMode: string
{
    case Inherit  = 'inherit';
    case Override = 'override';
    case Disable  = 'disable';
}
