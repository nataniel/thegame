<?php
namespace Main\Helper;

class NumberToPLN extends \E4u\Application\Helper\ViewHelper
{
    public function show($amount, $currency = 'zł')
    {
        return number_format($amount, 2, ',', '&nbsp;') . ($currency ? '&nbsp;' . $currency : '');
    }
}