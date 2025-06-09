<?php

namespace app\components\services;

use Da\QrCode\QrCode;

class QrCodeService
{
    public static function generateQrCode(string $url, int $size = 200): string
    {
        $qrCode = (new QrCode($url))
            ->setSize($size)
            ->setMargin(5)
            ->setBackgroundColor(240, 240, 240);

        return $qrCode->writeDataUri();
    }
}