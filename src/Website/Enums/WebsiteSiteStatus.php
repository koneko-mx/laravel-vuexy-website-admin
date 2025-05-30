<?php

namespace Koneko\VuexyWebsiteAdmin\Website\Enums;

enum WebsiteSiteStatus: string
{
    case Active = 'active';
    case ComingSoon = 'coming_soon';
    case Maintenance = 'maintenance';
}
