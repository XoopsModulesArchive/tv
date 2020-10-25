<?php
/*
************************************************************************************************
*
*                    Module TV 1.9  pour XOOPS RC2
*
* Créé par Codephp (http://www.codephp.net) et ckforum (http://ckforum.dyndns.org) pour MPN
* adapté à XOOPS et enrichi par kyex (http://kyexoops.multimania.com)
* pour toute question n'hésitez pas à me contacter sur kyeXoops
* Fichier CONFIG.PHP pour le module TV
* Ce fichier sert à renseigner le site par défault de votre chaine TV
* Les modifications de ce fichier sont apportées via le module admin de votre site XOOPS
*
*  tv.php :
*  (fichier permettant l'intégration de TV dans XOOPS via un iframe et ilayer cela permet
*  de ne réactualiser que la télé lors de la sélection d'une chaîne et non pas tout le site
*  Gain de temps évident pour les utilisateurs)
*************************************************************************************************
*/

// 20/10/2001 adaption PostNuke 0.64 par kyex
//12/01/2001 adaptation XOOPS par kyex
// 10/02/2002 v1.2 pour XOOPS RC2 par kyex
// 27/04/2002 v1.9 pour XOOPS RC2 par kyex (beta de la 2.0)
// 06/06/2002 V1.9 pour XOOPS RC3 par kyex
include 'header.php';

if ('tv' == $xoopsConfig['startpage']) {
    $xoopsOption['show_rblock'] = 1;

    require XOOPS_ROOT_PATH . '/header.php';

    make_cblock();

    echo '<br>';
} else {
    $xoopsOption['show_rblock'] = 0;

    require XOOPS_ROOT_PATH . '/header.php';
}

OpenTable();

if (0 != $hid) {
    $accesdirect = "?topic=$hid";
} else {
    $accesdirect = '';
}

echo '' . '<center>' . '<iframe src="tv.php' . $accesdirect . '" name="TV online" width="450" height="730" frameborder="0" marginwidth="0" marginheight="0" ></iframe>' . '<layer src="tv.php' . $accesdirect . '" width="400" height="730" name="TV online" ></layer></center>';

CloseTable();

include 'footer.php';
