<?php

declare(strict_types=1);

use Koneko\VuexyWebsiteAdmin\Application\Http\Middleware\WebsiteContentMiddleware;
use Koneko\VuexyWebsiteAdmin\Application\UI\Livewire\Sites\Brand\{BrandCard, LogoOnDarkBgCard, LogoOnLightBgCard};
use Koneko\VuexyWebsiteAdmin\Application\UI\Livewire\Sites\Chat\{ChatCard, WhatsappCard, TawkToCard};
use Koneko\VuexyWebsiteAdmin\Application\UI\Livewire\Sites\Contact\{ContactInfoCard, ContactFormCard};
use Koneko\VuexyWebsiteAdmin\Application\UI\Livewire\Sites\General\{DescriptionCard, VisibilitySecurityCard, FaviconCard};
use Koneko\VuexyWebsiteAdmin\Application\UI\Livewire\Sites\Integrations\{GoogleAnalyticsCard, GoogleSearchConsoleCard, GoogleTagsCard, PixelMetaCard, TwitterApiCard};
use Koneko\VuexyWebsiteAdmin\Application\UI\Livewire\Sites\Locations\BranchesCard;
use Koneko\VuexyWebsiteAdmin\Application\UI\Livewire\Sites\Locations\LocationCard;
use Koneko\VuexyWebsiteAdmin\Application\UI\Livewire\Sites\Manager\SiteOffCanvasForm;
use Koneko\VuexyWebsiteAdmin\Application\UI\Livewire\Sites\Seo\{LocalLocationCard, OgCard, SchemaOrgCard, TwitterCard};
use Koneko\VuexyWebsiteAdmin\Application\UI\Livewire\Sites\Social\SocialCard;
use Koneko\VuexyWebsiteAdmin\Application\UI\Livewire\Sites\Template\{TemplateCard};
/*
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
use Koneko\VuexyWebsiteAdmin\Application\UI\Livewire\Contact\Info\{ContactInfoCard, LocationCard};
use Koneko\VuexyWebsiteAdmin\Application\UI\Livewire\Content\Gallery\GalleryIndex;
use Koneko\VuexyWebsiteAdmin\Application\UI\Livewire\Content\Legal\{LegalIndex, LegalOffCanvasForm};
use Koneko\VuexyWebsiteAdmin\Application\UI\Livewire\Comunication\Messenger\MessengerCard;
use Koneko\VuexyWebsiteAdmin\Application\UI\Livewire\Comunication\TawkTo\TawkToCard;
use Koneko\VuexyWebsiteAdmin\Application\UI\Livewire\Comunication\Twitter\TwitterCard;
use Koneko\VuexyWebsiteAdmin\Application\UI\Livewire\Comunication\Whatsapp\WhatsappCard;
use Koneko\VuexyWebsiteAdmin\Application\UI\Livewire\Seo\Canonical\CanonicalIndex;
use Koneko\VuexyWebsiteAdmin\Application\UI\Livewire\Seo\Jsonld\JsonldIndex;
use Koneko\VuexyWebsiteAdmin\Application\UI\Livewire\Seo\LocalLocationCard;
use Koneko\VuexyWebsiteAdmin\Application\UI\Livewire\Seo\Manifest\ManifestCard;
use Koneko\VuexyWebsiteAdmin\Application\UI\Livewire\Seo\OgCard;
use Koneko\VuexyWebsiteAdmin\Application\UI\Livewire\Seo\Sitemap\{SitemapIndex, SitemapUrlOffcanvasForm};
use Koneko\VuexyWebsiteAdmin\Application\UI\Livewire\Seo\SocialCards\SocialCardsIndex;
use Koneko\VuexyWebsiteAdmin\Application\UI\Livewire\Seo\Robots\RobotsCard;
use Koneko\VuexyWebsiteAdmin\Application\UI\Livewire\Translate\Google\GoogleTanslateCard;
*/

use Koneko\VuexyWebsiteAdmin\Console\Commands\{SitemapGenerate, WebsiteCacheHelperCommand, WebsiteContentHelperCommand, WebsiteMenuHelperCommand, WebsiteSeoHelperCommand};
use Koneko\VuexyWebsiteAdmin\Models\WebsiteSite;

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
            // Sitios web
            'site.site-offcanvas-form' => SiteOffCanvasForm::class,

            // General
            'site.description-card'         => DescriptionCard::class,
            'site.visibility-security-card' => VisibilitySecurityCard::class,
            'site.favicon-card'             => FaviconCard::class,

            // Template
            'site.template-card' => TemplateCard::class,

            // Marca
            'site.brand-card'            => BrandCard::class,
            'site.logo-on-light-bg-card' => LogoOnLightBgCard::class,
            'site.logo-on-dark-bg-card'  => LogoOnDarkBgCard::class,

            // SEO
            'site.local-location-card' => LocalLocationCard::class,
            'site.schema-org-card'     => SchemaOrgCard::class,
            'site.og-card'             => OgCard::class,
            'site.twitter-card'        => TwitterCard::class,

            // Contacto
            'site.contact-info-card' => ContactInfoCard::class,
            'site.contact-form-card' => ContactFormCard::class,

            // Ubicaciones
            'site.contact-location-card' => LocationCard::class,
            'site.contact-branches-card' => BranchesCard::class,

            // Redes sociales
            'site.social-card' => SocialCard::class,

            // Chat
            'site.chat-card' => ChatCard::class,
            'site.whatsapp-card' => WhatsappCard::class,
            'site.tawk-to-card'  => TawkToCard::class,

            // Integraciones
            'site.google-analytics-card'      => GoogleAnalyticsCard::class,
            'site.google-tags-card'           => GoogleTagsCard::class,
            'site.google-search-console-card' => GoogleSearchConsoleCard::class,
            'site.pixel-meta-card'            => PixelMetaCard::class,
            'site.twitter-api-card'           => TwitterApiCard::class,

            // Menús
            'site.menu-card' => MenuCard::class,

            // Páginas
            'site.page-card' => PageCard::class,







            // Visibilidad en buscadores


            // Formulario de contacto

            // Analítica y seguimiento

            // Chat & Comunicación
            'site.messenger-card' => MessengerCard::class,

            // Traducciones e internacional

            // Preguntas frecuentes
            'site.faq-index'          => FaqIndex::class,
            'site.faq-offcanvas-form' => FaqOffcanvasForm::class,

            // Galería de imágenes
            'site.gallery-index' => GalleryIndex::class,

            // Avisos legales
            'site.legal-index'          => LegalIndex::class,
            'site.legal-offcanvas-form' => LegalOffCanvasForm::class,

            // Herramientas SEO
            'site.sitemap-index'          => SitemapIndex::class,
            'site.sitemap-offcanvas-form' => SitemapUrlOffcanvasForm::class,
            'site.canonical-index'        => CanonicalIndex::class,

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

    // 📦 Scope Models
    'scopeModels' => [
        'website' => WebsiteSite::class,
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
            'path' => 'config/vuexy_admin_menu.php',
        ],
    ],
];
