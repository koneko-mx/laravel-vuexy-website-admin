<?php

namespace Koneko\VuexyWebsiteAdmin\Application\Enums\WebsiteContents;

enum WebsiteContentStatus: string {
    case Draft     = 'draft';
    case Published = 'published';
    case Hidden    = 'hidden';
    case Deleted   = 'deleted';

    public function label(): string
    {
        return match($this) {
            self::Draft     => 'Borrador',
            self::Published => 'Publicado',
            self::Hidden    => 'Oculto',
            self::Deleted   => 'Eliminado',
        };
    }
}
