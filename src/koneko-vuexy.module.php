<?php

declare(strict_types=1);

use Koneko\VuexyWebsiteAdmin\Application\Http\Middleware\{WebsiteContentMiddleware, WebsiteContextMiddleware, WebsiteTemplateMiddleware};
use Koneko\VuexyWebsiteAdmin\Application\UI\Livewire\Analytics\GoogleAnalytics\GoogleAnalyticsCard;
use Koneko\VuexyWebsiteAdmin\Application\UI\Livewire\Analytics\GoogleSearchConsole\GoogleSearchConsoleCard;
use Koneko\VuexyWebsiteAdmin\Application\UI\Livewire\Analytics\GoogleTags\GoogleTagsCard;
use Koneko\VuexyWebsiteAdmin\Application\UI\Livewire\Analytics\PixelMeta\PixelMetaCard;
use Koneko\VuexyWebsiteAdmin\Application\UI\Livewire\Blog\Article\{BlogArticlesTable, BlogArticleOffcanvasForm};
use Koneko\VuexyWebsiteAdmin\Application\UI\Livewire\Blog\Category\{BlogCategoriesTable, BlogCategoryOffcanvasForm};
use Koneko\VuexyWebsiteAdmin\Application\UI\Livewire\Blog\Comment\{BlogCommentsTable, BlogCommentOffcanvasForm};
use Koneko\VuexyWebsiteAdmin\Application\UI\Livewire\Blog\Tag\{BlogTagsTable, BlogTagOffcanvasForm};
use Koneko\VuexyWebsiteAdmin\Application\UI\Livewire\Content\Faq\{FaqIndex, FaqOffcanvasForm};
use Koneko\VuexyWebsiteAdmin\Application\UI\Livewire\Contact\Form\ContactFormCard;
use Koneko\VuexyWebsiteAdmin\Application\UI\Livewire\Contact\Info\{ContactInfoCard, ContactLocationCard};
use Koneko\VuexyWebsiteAdmin\Application\UI\Livewire\Content\Gallery\GalleryIndex;
use Koneko\VuexyWebsiteAdmin\Application\UI\Livewire\Content\Legal\{LegalIndex, LegalOffCanvasForm};
use Koneko\VuexyWebsiteAdmin\Application\UI\Livewire\Comunication\Messenger\MessengerCard;
use Koneko\VuexyWebsiteAdmin\Application\UI\Livewire\Comunication\TawkTo\TawkToCard;
use Koneko\VuexyWebsiteAdmin\Application\UI\Livewire\Comunication\Twitter\TwitterCard;
use Koneko\VuexyWebsiteAdmin\Application\UI\Livewire\Comunication\Whatsapp\WhatsappCard;
use Koneko\VuexyWebsiteAdmin\Application\UI\Livewire\Seo\Canonical\CanonicalIndex;
use Koneko\VuexyWebsiteAdmin\Application\UI\Livewire\Seo\Jsonld\JsonldIndex;
use Koneko\VuexyWebsiteAdmin\Application\UI\Livewire\Seo\Manifest\ManifestCard;
use Koneko\VuexyWebsiteAdmin\Application\UI\Livewire\Seo\Sitemap\{SitemapIndex, SitemapUrlOffcanvasForm};
use Koneko\VuexyWebsiteAdmin\Application\UI\Livewire\Seo\SocialCards\SocialCardsIndex;
use Koneko\VuexyWebsiteAdmin\Application\UI\Livewire\Seo\Robots\RobotsCard;
use Koneko\VuexyWebsiteAdmin\Application\UI\Livewire\Settings\General\{WebsiteDescriptionCard, WebsiteFaviconCard, LogoOnDarkBgCard, LogoOnLightBgCard};
use Koneko\VuexyWebsiteAdmin\Application\UI\Livewire\Settings\Indexing\IndexingCard;
use Koneko\VuexyWebsiteAdmin\Application\UI\Livewire\Settings\Social\SocialCard;
use Koneko\VuexyWebsiteAdmin\Application\UI\Livewire\Translate\Google\GoogleTanslateCard;
use Koneko\VuexyWebsiteAdmin\Console\Commands\{SitemapGenerate, WebsiteCacheHelperCommand, WebsiteContentHelperCommand, WebsiteMenuHelperCommand, WebsiteSeoHelperCommand};

return [
    // 🌐 Identidad del Módulo
    'name' => 'Website admin',
    'description' => 'Gestión de contenido del sitio web.',
    'type' => 'plugin',
    'tags' => ['koneko-official', 'website', 'admin', 'website-admin', 'website-content', 'website-management'],

    // ⚙️ Namespace de configuraciones Koneko Vuexy Admin
    'componentNamespace' => 'website-admin',

    // 🧠 Metadatos visuales para UI del gestor
    'ui' => [
        'image'  => 'resources/img/module-cover.png',
        'readme' => 'README.md',
    ],

    // ⚙️ Archivos de configuración del módulo
    'configs' => [
        'koneko.website' => 'config/koneko-website.php',
    ],

    // 🏭 Proveedores de servicio, Middleware y Aliases (runtime)
    'middleware' => [
        'website-content' => WebsiteContentMiddleware::class,
    ],

    // 📦 migraciones
    'migrations' => [
        'database/migrations',
    ],

    // 🗺️ Rutas

    'routes' => [
        [
            'middleware' => ['web', 'auth', 'admin'],
            'paths' => [
                'routes/koneko_website_admin.php',
                'routes/koneko_website_cms.php',
                'routes/koneko_website_blog.php',
            ],
        ],
        [
            'middleware' => ['web', 'website-content'],
            'paths' => [
                'routes/koneko_website_sites.php',
            ],
        ],
    ],

    // 🗂️ Vistas, traducciones
    'views' => [
        'vuexy-website-admin' => 'resources/views',
    ],

    // 🧩 Componentes Blade y Livewire
    'livewire' => [
        'vuexy-website-admin' => [
            // ajustes generales
            'website-description-card' => WebsiteDescriptionCard::class,
            'website-favicon-card'     => WebsiteFaviconCard::class,
            'logo-on-light-bg-card'    => LogoOnLightBgCard::class,
            'logo-on-dark-bg-card'     => LogoOnDarkBgCard::class,

            // Enlaces Redes sociales
            'social-card' => SocialCard::class,

            // Visibilidad en buscadores
            'indexing-card' => IndexingCard::class,

            // Información de contacto
            'contact-info-card'     => ContactInfoCard::class,
            'contact-location-card' => ContactLocationCard::class,

            // Formulario de contacto
            'contact-form-card' => ContactFormCard::class,

            // Analítica y seguimiento
            'google-analytics-card'      => GoogleAnalyticsCard::class,
            'google-tags-card'           => GoogleTagsCard::class,
            'google-search-console-card' => GoogleSearchConsoleCard::class,
            'pixel-meta-card'            => PixelMetaCard::class,

            // Chat & Comunicación
            'messenger-card' => MessengerCard::class,
            'whatsapp-card'  => WhatsappCard::class,
            'tawk-to-card'   => TawkToCard::class,
            'twitter-card'   => TwitterCard::class,

            // Traducciones e internacional
            'google-tanslate-card' => GoogleTanslateCard::class,

            // Preguntas frecuentes
            'faq-index'          => FaqIndex::class,
            'faq-offcanvas-form' => FaqOffcanvasForm::class,

            // Galería de imágenes
            'gallery-index' => GalleryIndex::class,

            // Avisos legales
            'legal-index'          => LegalIndex::class,
            'legal-offcanvas-form' => LegalOffCanvasForm::class,

            // Herramientas SEO
            'sitemap-index'          => SitemapIndex::class,
            'sitemap-offcanvas-form' => SitemapUrlOffcanvasForm::class,
            'jsonld-index'           => JsonldIndex::class,
            'robots-card'            => RobotsCard::class,
            'manifest-card'          => ManifestCard::class,
            'canonical-index'        => CanonicalIndex::class,
            'social-cards-index'     => SocialCardsIndex::class,

            // Blog
            'blog-articles-table'          => BlogArticlesTable::class,
            'blog-article-offcanvas-form'  => BlogArticleOffcanvasForm::class,
            'blog-categories-table'        => BlogCategoriesTable::class,
            'blog-category-offcanvas-form' => BlogCategoryOffcanvasForm::class,
            'blog-tags-table'              => BlogTagsTable::class,
            'blog-tag-offcanvas-form'      => BlogTagOffcanvasForm::class,
            'blog-comments-table'          => BlogCommentsTable::class,
            'blog-comment-offcanvas-form'  => BlogCommentOffcanvasForm::class,
        ]
    ],

    // 🛠 Comandos Artisan
    'commands' => [
        SitemapGenerate::class,
        WebsiteMenuHelperCommand::class,
        WebsiteContentHelperCommand::class,
        WebsiteCacheHelperCommand::class,
        WebsiteSeoHelperCommand::class,
    ],

    // 🛡️ Configuración de roles y permisos (RBAC)
    'rbac' => [
        'permissions_path' => 'database/rbac/permissions.json',
        'roles_path'       => 'database/rbac/roles.json',
    ],

    // 🔗 Registro de APIs disponibles en el módulo
    'apis' => [
        'catalog_path' => 'config/vuexy_apis_catalog.php',
    ],

    // 🧠 Extensiones
    'extensions' => [
        'menu' => [
            'path' => 'config/vuexy_website_admin_menu.php',
        ],
    ],
];
