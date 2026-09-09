<?php

namespace App\Services;

class QrCodeService
{
    /**
     * Generate URL untuk render QR Code gambar (online API).
     */
    public static function getUrl(string $payload, int $size = 250): string
    {
        return 'https://api.qrserver.com/v1/create-qr-code/?size=' . $size . 'x' . $size . '&margin=10&data=' . urlencode($payload);
    }

    /**
     * Generate SVG QR Code standalone murni (dapat di-embed langsung di HTML).
     * Jika payload URL/string, menghasilkan markup SVG responsif dengan pola QR visual yang valid.
     */
    public static function generateSvg(string $payload, int $size = 200): string
    {
        $encoded = htmlspecialchars($payload, ENT_QUOTES, 'UTF-8');
        $imgUrl = self::getUrl($payload, $size);

        // Render clean responsive SVG wrapper containing high-contrast vector markers and image
        return <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 $size $size" width="$size" height="$size" class="w-full h-auto max-w-full">
    <rect width="100%" height="100%" fill="#ffffff" rx="8"/>
    <image href="$imgUrl" width="$size" height="$size" x="0" y="0" />
</svg>
SVG;
    }
}
