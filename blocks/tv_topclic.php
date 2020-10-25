<?php
// ------------------------------------------------------------------------- //
//                XOOPS - PHP Content Management System                      //
//                       <http://xoops.codigolivre.org.br>                             //
// ------------------------------------------------------------------------- //
// Based on:								     //
// myPHPNUKE Web Portal System - http://myphpnuke.com/	  		     //
// PHP-NUKE Web Portal System - http://phpnuke.org/	  		     //
// Thatware - http://thatware.org/					     //
// ------------------------------------------------------------------------- //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
// ------------------------------------------------------------------------- //
/******************************************************************************
 * Function: b_tv_topclic_show
 * Input   :
 *           $block['content'] = The optional above content
 * Output  : Les chaines les plus regardées
 ******************************************************************************/
function b_tv_topclic_show($options)
{
    global $xoopsDB, $xoopsConfig;

    $block = [];

    $myts = new MyTextSanitizer();

    $result = $xoopsDB->query('SELECT hid, sitename, clicktv, date FROM ' . $xoopsDB->prefix('tv') . ' WHERE status>0 ORDER BY ' . $options[0] . ' DESC', $options[1], 0);

    $block['content'] = '<small>';

    while (false !== ($myrow = $xoopsDB->fetcharray($result))) {
        $title = htmlspecialchars($myrow['sitename']);

        if (!XOOPS_USE_MULTIBYTES) {
            if (mb_strlen($title) >= 19) {
                $title = mb_substr($title, 0, 18) . '...';
            }
        }

        $block['content'] .= '&nbsp;&nbsp;<strong><big>&middot;</big></strong>&nbsp;<a href="' . XOOPS_URL . '/modules/tv/index.php?hid=' . $myrow['hid'] . "\">$title</a> ";

        if ('clicktv' == $options[0]) {
            $block['content'] .= '(' . $myrow['clicktv'] . ')<br>';

            $block['title'] = _TV_TITRE_BLOC;
        } elseif ('date' == $options[0]) {
            $block['content'] .= '(' . formatTimestamp($myrow['date'], 's') . ')<br>';

            $block['title'] = _TV_TITRE_BLOC2;
        }
    }

    $block['content'] .= '</small>';

    return $block;
}

function b_tv_topclic_edit($options)
{
    $form = '' . _TV__DISP . '&nbsp;';

    $form .= '<input type="hidden" name="options[]" value="';

    if ('date' == $options[0]) {
        $form .= 'date"';
    } else {
        $form .= 'clicktv"';
    }

    $form .= '>';

    $form .= '<input type="text" name="options[]" value="' . $options[1] . '">&nbsp;' . _TV_CHANNELS . '';

    return $form;
}
