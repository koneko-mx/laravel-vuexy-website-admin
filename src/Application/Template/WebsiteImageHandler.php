<?php

declare(strict_types=1);

namespace Koneko\VuexyWebsiteAdmin\Application\Template;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Koneko\VuexyAdmin\Application\Settings\Manager\KonekoSettingManager;
use Koneko\VuexyWebsiteAdmin\Models\{WebsiteSite, WebsiteSeoProfile};
use Illuminate\Http\UploadedFile;

/**
 * Servicio para gestionar favicon y logos administrativos.
 * - Versiona logos en 4 variantes (normal/horizontal × light/dark) sin perder proporción.
 * - Genera tamaños small/medium/large + base64 por variante.
 */
class WebsiteImageHandler
{
    private string $driver;
    private string $imageDisk = 'public';

    public const FAVICON_BASE_PATH = 'favicon-website/';
    public const LOGO_BASE_PATH    = 'logo-website/';
    public const SHARE_BASE_PATH   = 'share-website/';

    // Tamaños por área de píxeles, conservando aspecto (no recorta)
    private const PIXELS_SMALL  = 22500;   // ~150×150
    private const PIXELS_MEDIUM = 75625;   // ~275×275
    private const PIXELS_LARGE  = 262144;  // ~512×512
    private const PIXELS_BASE64 = 230400;  // ~480×480 (calidad para inline)

    // Variantes admitidas para logos
    // "" (default), "h" (horizontal), "dark", "h_dark" (horizontal + dark)
    public const LOGO_VARIANTS = ['default', 'h_default', 'dark', 'h_dark'];

    private const GROUP = 'layout';
    //private const SECTION = 'website';

    public function __construct()
    {
        $this->driver = config('image.driver', 'gd');
    }

    private function settings(WebsiteSite $site, $section): KonekoSettingManager
    {
        return settings('website-admin')
            ->context(self::GROUP, $section)
            ->scope($site);
    }

    /**
     * Procesa y guarda múltiples versiones del favicon (recorta a tamaño exacto: cover WxH).
     */
    public function processAndSaveFavicon(UploadedFile $image, WebsiteSeoProfile $profile): void
    {
        $old_favicons = $profile->favicons;
        $imageManager = new ImageManager($this->driver);

        $baseName = uniqid('favicon_', true);

        try {
            $original = $imageManager->read($image->getRealPath());
            $favicons = [];

            foreach ($this->getFaviconSizes() as $size => [$w, $h]) {
                $resized   = clone $original;
                $resized   = $resized->cover($w, $h);
                $file_name = "{$baseName}_{$size}.png";

                Storage::disk($this->imageDisk)
                    ->put(self::FAVICON_BASE_PATH . $file_name, $resized->toPng(indexed: true));

                $favicons[$size] = $file_name;
            }

            if ($old_favicons) {
                $delete_images = array_map(fn($v) => self::FAVICON_BASE_PATH . $v, $old_favicons);
                $this->deleteOldFiles($delete_images);
            }

            $p = WebsiteSeoProfile::query()->findOrFail($profile->id);

            $p->fill([
                'favicon' => $favicons,
            ])->save();

        } finally {
            $image->delete();
        }
    }

    /**
     * Procesa y guarda un logo en UNA variante (e.g. '', 'h', 'dark', 'h_dark').
     * Mantiene proporción real: redimensiona por área de píxeles, sin recortes.
     */
    public function processAndSaveImageLogo(UploadedFile $image, WebsiteSite $site, string $variant = 'default'): void
    {
        $imageManager = new ImageManager($this->driver);
        $original     = $imageManager->read($image->getRealPath());

        try {
            $this->saveLogoForVariant($original, $site, $variant);
        } finally {
            $image->delete();
        }
    }

    /**
     * Procesa y guarda un logo en VARIAS variantes a la vez.
     * @param array $variants e.g. WebsiteImageHandler::LOGO_VARIANTS
     */
    public function processAndSaveImageLogoVariants(UploadedFile $image, WebsiteSite $site, array $variants = self::LOGO_VARIANTS): void
    {
        $imageManager = new ImageManager($this->driver);
        $original     = $imageManager->read($image->getRealPath());

        try {
            foreach ($variants as $variant) {
                $this->saveLogoForVariant($original, $site, (string)$variant);
            }
        } finally {
            $image->delete();
        }
    }

    /**
     * Obtiene las variables (paths/base64) del logo para una variante.
     * $variant: '', 'h', 'dark', 'h_dark'
     */
    public function getImageLogoVars(WebsiteSite $site, string $sub_group): array
    {
        $settings = $this->settings($site, 'logo')
            ->subGroup($sub_group)
            ->asArray()
            ->all() ?? [];

        return [
            'small'  => isset($settings['small'])
                ? self::LOGO_BASE_PATH . $settings['small']
                : '../vendor/vuexy-admin/img/logo/koneko-04.png',
            'medium' => isset($settings['medium'])
                ? self::LOGO_BASE_PATH . $settings['medium']
                : '../vendor/vuexy-admin/img/logo/koneko-04.png',
            'large'  => isset($settings['large'])
                ? self::LOGO_BASE_PATH . $settings['large']
                : '../vendor/vuexy-admin/img/logo/koneko-04.png',
            'base64' => isset($settings['base64'])
                ? $settings['base64']
                : '',
        ];
    }

    /**
     * Shortcut para obtener TODAS las variantes en un arreglo estructurado.
     */
    public function getAllLogoVars(WebsiteSite $site): array
    {
        $out = [];
        foreach (self::LOGO_VARIANTS as $key => $v) {
            $out[$key] = $this->getImageLogoVars($site, $v);
        }
        return $out;
    }

    /**
     * Guarda (borra previas y re-genera) small/medium/large/base64 de una variante.
     */
    private function saveLogoForVariant($originalImage, WebsiteSite $site, string $variant = 'default'): void
    {
        // Limpia versiones antiguas SOLO de la variante
        $this->deleteOldLogoImages($site, $variant);

        // Clonamos para cada tamaño, manteniendo proporción
        $this->saveResizedLogo($originalImage, self::PIXELS_SMALL,  $site, 'small',  $variant);
        $this->saveResizedLogo($originalImage, self::PIXELS_MEDIUM, $site, 'medium', $variant);
        $this->saveResizedLogo($originalImage, self::PIXELS_LARGE,  $site, 'large',  $variant);
        $this->saveBase64Logo ($originalImage, self::PIXELS_BASE64, $site,           $variant);
    }

    /**
     * Redimensiona y guarda un logo (sin recorte, conservando aspecto).
     */
    private function saveResizedLogo($image, int $maxPixels, WebsiteSite $site, string $size = '', string $variant = 'default'): void
    {
        //$size  = $size ? "_{$size}" : '';
        //$variant = $variant ? "_{$variant}" : '';

        $resized = clone $image;
        $this->resizeImageToMaxPixels($resized, $maxPixels);

        $fileName = uniqid("logo_{$size}_{$variant}_", true) . '.png';
        $path     = self::LOGO_BASE_PATH . $fileName;

        Storage::disk($this->imageDisk)->put($path, $resized->toPng(indexed: true));

        $keyName = $size;

        $this->settings($site, 'logo')->subGroup($variant)->set($keyName, $fileName);
    }

    /**
     * Guarda un logo en base64 (JPG calidad 40 por tamaño/uso inline). Mantiene proporción.
     */
    private function saveBase64Logo($image, int $maxPixels, WebsiteSite $site, string $variant = 'default'): void
    {
        $resized = clone $image;
        $this->resizeImageToMaxPixels($resized, $maxPixels);

        $base64 = (string) $resized->toJpg(40)->toDataUri();

        $this->settings($site, 'logo')->subGroup($variant)->set('base64', $base64);
    }

    /**
     * Elimina archivos de imágenes antiguos (solo archivos; ignora valores base64).
     */
    private function deleteOldFiles(array $paths): void
    {
        foreach ($paths as $path) {
            if ($path && !str_starts_with($path, 'data:') && Storage::disk($this->imageDisk)->exists($path)) {
                Storage::disk($this->imageDisk)->delete($path);
            }
        }
    }

    /**
     * Elimina versiones anteriores de logos PARA UNA variante.
     * Evita borrar valores base64 del settings store.
     */
    private function deleteOldLogoImages(WebsiteSite $site, string $variant = 'default'): void
    {
        $image_files = $this->settings($site, 'logo')
            ->subGroup($variant)
            ->asArray()
            ->all() ?? [];

        $paths = [];
        foreach ($image_files as $key => $value) {
            if (is_string($value) && !str_starts_with($key, 'base64') && !str_starts_with($value, 'data:')) {
                $paths[] = self::LOGO_BASE_PATH . $value;
            }
        }

        $this->deleteOldFiles($paths);
    }

    /**
     * Redimensiona imagen conservando aspecto. Calcula W×H aproximados a partir del área.
     */
    private function resizeImageToMaxPixels($image, int $maxPixels)
    {
        $originalWidth  = $image->width();
        $originalHeight = $image->height();
        $aspectRatio    = $originalWidth / max(1, $originalHeight);

        if ($aspectRatio > 1) {
            $newWidth  = sqrt($maxPixels * $aspectRatio);
            $newHeight = $newWidth / $aspectRatio;
        } else {
            $newHeight = sqrt($maxPixels / max(0.0001, $aspectRatio));
            $newWidth  = $newHeight * $aspectRatio;
        }

        $image->resize((int) round($newWidth), (int) round($newHeight), function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        return $image;
    }

    /**
     * Tamaños estándar de favicons.
     */
    private function getFaviconSizes(): array
    {
        return [
            '16x16'   => [16, 16],
            '76x76'   => [76, 76],
            '120x120' => [120, 120],
            '152x152' => [152, 152],
            '180x180' => [180, 180],
            '192x192' => [192, 192],
        ];
    }

    /**
     * Guarda imagen para OG/Twitter con tamaño fijo y recorte COVER.
     * $kind: 'og' => 1200x630, 'twitter' => 800x418 (summary_large_image)
     * Devuelve ruta relativa: e.g. "share-website/og_...png"
     */
    public function processAndSaveShareImage(UploadedFile $image, string $kind = 'og'): string
    {
        $dims = match ($kind) {
            'twitter' => [800, 418],
            default   => [1200, 630],
        };

        $imageManager = new ImageManager($this->driver);
        $original     = $imageManager->read($image->getRealPath());

        Storage::disk($this->imageDisk)->makeDirectory(self::SHARE_BASE_PATH);

        $file   = uniqid($kind . '_', true) . '.png';
        $path   = self::SHARE_BASE_PATH . $file;

        // cover: recorte centrado al canvas objetivo
        $processed = clone $original;
        $processed = $processed->cover($dims[0], $dims[1]); // fill y recorta
        Storage::disk($this->imageDisk)->put($path, $processed->toPng(indexed: true));

        // limpia temp
        $image->delete();

        return $path; // relativo a storage/
    }
}
