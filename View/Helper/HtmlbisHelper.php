<?php
/*
    This file is part of Authake.

    Author: Jérôme Combaz (jakecake/velay.greta.fr)
    Contributors:

    Authake is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    Authake is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Foobar.  If not, see <http://www.gnu.org/licenses/>.
*/


App::import('Helper', 'Html');

class HtmlbisHelper extends HtmlHelper {
        
    function iconlink($icon, $title, $url = null, $htmlAttributes = array(), $confirmMessage = false) {
        $img = parent::image("/authake/img/icons/{$icon}.png", array('title' => $title));
        return parent::link($img, $url, am($htmlAttributes, array('escape'=>false)), $confirmMessage, false);
    }
    
    function iconallowdeny($what) {
        if ($what == 'Allow')
            echo $this->image("/authake/img/icons/accept.png", array('title' => __('Allow')));
        else
            echo $this->image("/authake/img/icons/delete.png", array('title' => __('Deny')));
    }
}
?>