<?php
namespace Main\Helper;

class ShowAssetPrice extends \E4u\Application\Helper\ViewHelper
{
    public function show($asset)
    {
        $html = [];
        foreach ($asset->getPrice() as $class => $amount) {

            $supply = $asset->getPlayer()->getSupplyByType($class);
            $img = $this->getView()->image('images/resources/' . $supply->getType() . '.png', $this->getView()->t($supply));
            $html[] = sprintf('%s&nbsp;%s:&nbsp;%+d', $img, $this->getView()->t($supply), $amount * -1);

        }

        return join('<br />', $html);
    }
}