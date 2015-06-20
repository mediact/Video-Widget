<?php
/**
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

class Clockworkgeek_VideoWidget_Block_Vimeo extends Mage_Core_Block_Template
{

    protected function _construct()
    {
        parent::_construct();

        if (!$this->hasTemplate()) {
            $this->setTemplate('clockworkgeek/videowidget/vimeo.phtml');
        }
    }

    public function getCode()
    {
        $code = parent::getCode();
        // sanitise user input in case user cannot read instructions
        switch (true) {
            case preg_match('#^(\d{6,12})$#', $code, $match):
            case preg_match('#//vimeo.com/(\d{6,12})\b#', $code, $match):
            case preg_match('#//player.vimeo.com/video/(\d{6,12})\b#', $code, $match):
                $code = $match[1];
                break;
            default:
                $code = '';
        }

        return $code;
    }

    public function getEmbedUrl()
    {
        if (($code = $this->getCode())) {
            $code = "https://player.vimeo.com/video/{$code}";

            if ($this->getAutoplay()) {
                $code .= '&autoplay=1';
            }
        
            if ($this->getLoop()) {
                $code .= '&loop=1';
            }
        }

        return (string) $code;
    }

    public function getAspectPercentage()
    {
        switch ($this->getAspectRatio()) {
            case 'widescreen':
                $ratio = 16/9;
                break;
            default:
                $ratio = 4/3;
        }
        return sprintf('%.4g%%', 100 / $ratio);
    }

    protected function _toHtml()
    {
        return $this->getCode() ? parent::_toHtml() : '';
    }
}
