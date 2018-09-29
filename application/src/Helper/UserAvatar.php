<?php
namespace Main\Helper;

use E4u\Application\Helper\ViewHelper;
use Main\Model\User;

class UserAvatar extends ViewHelper
{
    private function _image($avatar, $alt, $size)
    {
        return $this->getView()
            ->image($avatar, $alt, [ 'class' => 'avatar', 'style' => "max-width: {$size}px; max-height: {$size}px;" ]);
    }

    /**
     * @param  User $user
     * @param  int $size
     * @return string
     */
    private function _gravatar($user, $size)
    {
        return $this->getView()
            ->_('gravatar', $user->getEmail(), [ 'img_size' => $size ], [ 'class' => 'avatar' ])->__toString();
    }

    /**
     * @param  User $user
     * @param  int $size
     * @return string
     */
    public function show($user, $size = 32)
    {
        if (!is_null($user)) {
            $avatar = $user->getAvatar();
            return !empty($avatar) && $avatar->fileExists()
                ? $this->_image($avatar, $user->getName(), $size)
                : $this->_gravatar($user, $size);
        }
    }
}