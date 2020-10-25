<?php

function tv_affiche_entete_html()
{
    global $xoopsConfig;

    $content = '';

    $content .= "<?xml version='1.0' encoding='"
                . _CHARSET
                . "'"
                . '?'
                . '>'
                . "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Strict//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd'>"
                . "<html xmlns='http://www.w3.org/1999/xhtml'>"
                . '<head>'
                . '<title>TV</title>'
                . '<meta http-equiv="Content-Type" content="text/html; charset='
                . _CHARSET
                . '">'
                . "<meta name=\"author\" content=\"kyex\">\n"
                . "<meta name=\"copyright\" content=\"Copyright (c) 2002 by kyex\">\n";

    $currenttheme = getTheme();

    //require_once XOOPS_ROOT_PATH."/themes/".$currenttheme."/theme.php";

    if (file_exists(XOOPS_ROOT_PATH . '/themes/' . $currenttheme . '/language/lang-' . $xoopsConfig['language'] . '.php')) {
        require XOOPS_ROOT_PATH . '/themes/' . $currenttheme . '/language/lang-' . $xoopsConfig['language'] . '.php';
    }

    $themecss = getcss($currenttheme);

    $content .= "<link rel='stylesheet' type='text/css' media='all' href='" . XOOPS_URL . "/xoops.css'>\n";

    if ($themecss) {
        $content .= "<link rel='stylesheet' type='text/css' href='$themecss'>\n\n";
    }

    $content .= '</head>';

    return ($content);
}

function tv_init_regex($patterns, $replacements, $tv, $height, $width, $comment)
{
    $patterns = [];

    $replacements = [];

    // ajout d'un popup made in taiwan (merci liya)

    $patterns[] = '/@PLAYERPOP/';

    $replacements[] = '<script language="JavaScript">'
                      . 'function MM_openBrWindow(theURL,winName,features) {'
                      . 'window.open(theURL,winName,features);'
                      . '} </script>'
                      . "<a href=\"#####\" onclick=\"MM_openBrWindow('"
                      . XOOPS_URL
                      . "/modules/tv/tv.php','TVPOP','scrollbars=yes,resizable=yes,width=500,height=620')\"><img name=\"popup\" src=\"images/popup.gif\" border=0 alt='popup'></a>";

    //==========================================================================

    // utilisation de la classe TVPlayer pour gérer autant de players que l'on veut

    $tvplayer = new TVPlayer($tv->player_id());

    $patterns[] = '/@PLAYEROBJECT/';

    // on est maintenant obligé de remplacer les variables dans la chaine

    $codePlayer = $tvplayer->getVar('codePlayer', 'N');

    $codePlayer = preg_replace('/\\$width/', "$width", $codePlayer);

    $codePlayer = preg_replace('/\\$height/', "$height", $codePlayer);

    $codePlayer = preg_replace('/\\$urlram/', $tv->urlram, $codePlayer);

    $replacements[] = $codePlayer;

    $patterns[] = '/@PLAYERNEEDED/';

    $replacements[] = sprintf(_TV_PLAYER_OBLIGATOIRE, $tvplayer->getVar('description'));

    $patterns[] = '/@HERE/';

    $replacements[] = _TV_ICI;

    $patterns[] = '/@PLAYERLINK/';

    $replacements[] = $tvplayer->getVar('lien');

    $patterns[] = '/@PLAYERBUTTONS/';

    $replacements[] = preg_replace('/\\$urlram/', $tv->urlram, $tvplayer->getVar('codeBoutons', 'N'));

    $patterns[] = '/@PLAYERPLAY/';

    $replacements[] = preg_replace('/\\$urlram/', $tv->urlram, $tvplayer->getVar('codePlay', 'N'));

    $patterns[] = '/@PLAYERSTOP/';

    $replacements[] = $tvplayer->getVar('codeStop', 'N');

    $patterns[] = '/@PLAYERPAUSE/';

    $replacements[] = $tvplayer->getVar('codePause', 'N');

    $patterns[] = '/@PLAYERMUTE/';

    $replacements[] = $tvplayer->getVar('codeMute', 'N');

    //===============================================================================

    $patterns[] = '/@SITENAME/';

    $replacements[] = $tv->sitename;

    $patterns[] = '/@SITELINK/';

    $replacements[] = $tv->sitesurl;

    $patterns[] = '/@SITELOGO/';

    $replacements[] = $tv->logo;

    $patterns[] = '/@COMMENT/';

    $replacements[] = $comment;

    $patterns[] = '/@TVDESCRIPTION/';

    $replacements[] = $tv->tvdescription;
}
