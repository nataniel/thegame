<?php
namespace Main\Helper;

class RandomBackground
{
    public static function security()
    {
        $background = [
            '//www.texturepalace.com/gallery/mixed/mixed-2014-03-07/texture-mix-1.JPG',
            '//images.designtrends.com/wp-content/uploads/2015/12/18123233/Snow-Flakes-Texture.jpg',
        ];

        return self::random($background);
    }

    private static function random($background)
    {
        return 'url(' . $background[array_rand($background)] . ')';
    }
}