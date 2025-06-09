<?php

namespace app\components\services;

use Da\QrCode\QrCode;

class QrCodeService
{
    public const BACKGROUND_RED = 240;
    public const BACKGROUND_GREEN = 240;
    public const BACKGROUND_BLUE = 240;
    public const MARGIN = 5;
    private const SIZE = 200;
    public static function generateQrCode(string $url, int $size = self::SIZE): string
    {
        $qrCode = (new QrCode($url))
            ->setSize($size)
            ->setMargin(self::MARGIN)
            ->setBackgroundColor(self::BACKGROUND_RED, self::BACKGROUND_GREEN, self::BACKGROUND_BLUE);

        return $qrCode->writeDataUri();
    }
}