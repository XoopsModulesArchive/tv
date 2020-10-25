<?php
/*
************************************************************************************************
*                    Module on TV 1.9 pour XOOPS RC3
*
* Créé par Codephp (http://www.codephp.net) et ckforum (http://ckforum.dyndns.org) pour MPN
* adapté à XOOPS et enrichi par kyex (http://kyexoops.multimania.com)
* pour toute question n'hésitez pas à me contacter sur kyeXoops
*************************************************************************************************
*/

// v1.95 08/2002 par kyex (http://kyex.inconnueteam.net)

include 'admin_header.php';
require_once XOOPS_ROOT_PATH . '/class/module.textsanitizer.php';
require XOOPS_ROOT_PATH . '/modules/tv/cache/config.php';
require XOOPS_ROOT_PATH . '/modules/tv/class/class.tv.php';
require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';

if (!isset($op)) {
    $op = 'admin';
}

// affichage liste des players, avec options ajout, suppr, modif
function tv_players_admin()
{
    xoops_cp_header();

    OpenTable();

    echo "<h4 style='text-align:left;'>" . _AM_PLAYERSLIST . '</h4>';

    $players_arr = TVPlayer::getAll(0, true);

    $players_count = count($players_arr);

    if (is_array($players_arr) && $players_count > 0) {
        echo "<form action='players.php' method='post'><table border='0' cellpadding='0' cellspacing='0' valign='top' width='100%'><tr><td class='bg2'>
		<table width='100%' border='0' cellpadding='4' cellspacing='1'>
		<tr class='bg3'><td>" . _AM_PLAYER . '</td><td>' . _AM_DESCRIPTION . '</td><td>' . _AM_LIEN . '</td><td>&nbsp;</td></tr>';

        foreach ($players_arr as $player) {
            echo "<tr class='bg1'><td align='center'><input type='hidden' name='player[]' value='"
                 . $player->getVar('player_id')
                 . "'>"
                 . $player->getVar('player')
                 . "</td><td align='center'>"
                 . $player->getVar('description')
                 . "</td><td align='center'>"
                 . $player->getVar('lien')
                 . "</td><td align='right'><a href='players.php?op=edit&amp;player_id="
                 . $player->getVar('player_id')
                 . "'>"
                 . _EDIT
                 . "</a><br><a href='players.php?op=delete&amp;player_id="
                 . $player->getVar('player_id')
                 . "'>"
                 . _DELETE
                 . '</a></td></tr>';
        }

        echo "<tr align='center' class='bg3'><td colspan='7'><input type='submit' value='" . _ADD . "'><input type='hidden' name='op' value='ajout'></td></tr></table></td></tr></table></form>";
    }

    CloseTable();
}

function tv_players_ajout()
{
    $player_form = new XoopsThemeForm(_AM_ADDPLAYER, 'players_form', 'players.php');

    $player_text = new XoopsFormText(_AM_PLAYER, 'player', 10, 10);

    $player_form->addElement($player_text);

    $desc_text = new XoopsFormText(_AM_DESCRIPTION, 'description', 50, 255);

    $player_form->addElement($desc_text);

    $codePlayer_tarea = new XoopsFormTextarea(_AM_CODEPLAYER, 'codePlayer', '', 10);

    $player_form->addElement($codePlayer_tarea);

    $lien_text = new XoopsFormText(_AM_LIEN, 'lien', 50, 255);

    $player_form->addElement($lien_text);

    $codeBoutons_tarea = new XoopsFormTextarea(_AM_CODEBOUTONS, 'codeBoutons', '', 10);

    $player_form->addElement($codeBoutons_tarea);

    $codePlay_tarea = new XoopsFormTextarea(_AM_CODEPLAY, 'codePlay', '', 10);

    $player_form->addElement($codePlay_tarea);

    $codeStop_tarea = new XoopsFormTextarea(_AM_CODESTOP, 'codeStop', '', 10);

    $player_form->addElement($codeStop_tarea);

    $codePause_tarea = new XoopsFormTextarea(_AM_CODEPAUSE, 'codePause', '', 10);

    $player_form->addElement($codePause_tarea);

    $codeMute_tarea = new XoopsFormTextarea(_AM_CODEMUTE, 'codeMute', '', 10);

    $player_form->addElement($codeMute_tarea);

    //$more_label = new XoopsFormLabel("", "<br><a href='index.php?op=ajouter&amp;player_id=".$tvplayer->getVar("player")."'>"._AM_ADDMORE."</a>");

    //$option_tray->addElement($more_label);

    //$player_form->addElement($option_tray);

    $op_hidden = new XoopsFormHidden('op', 'ajout_ok');

    $player_form->addElement($op_hidden);

    $submit_button = new XoopsFormButton('', 'player_submit', _SUBMIT, 'submit');

    $player_form->addElement($submit_button);

    xoops_cp_header();

    OpenTable();

    $player_form->display();

    CloseTable();
}

// action ajout
function tv_players_ajout_ok($player, $description, $codePlayer, $lien, $codeBoutons, $codePlay, $codeStop, $codePause, $codeMute)
{
    $tvplayer = new TVPlayer();

    $tvplayer->setVar('player', $player);

    $tvplayer->setVar('description', $description);

    $tvplayer->setVar('codePlayer', $codePlayer);

    $tvplayer->setVar('lien', $lien);

    $tvplayer->setVar('codeBoutons', $codeBoutons);

    $tvplayer->setVar('codePlay', $codePlay);

    $tvplayer->setVar('codeStop', $codeStop);

    $tvplayer->setVar('codePause', $codePause);

    $tvplayer->setVar('codeMute', $codeMute);

    if (!$tvplayer->store()) {
        echo $tvplayer->getErrors();

        exit();
    }

    redirect_header('players.php', 1, _AM_DBUPDATED);

    exit();
}

// confirmation suppression
function tv_players_suppr($player_id)
{
    xoops_cp_header();

    error_reporting(E_ALL);

    $tvplayer = new TVPlayer($player_id);

    OpenTable();

    echo "<h4 style='text-align:left;'>" . sprintf(_AM_RUSUREDEL, $tvplayer->getVar('player')) . "</h4>\n";

    echo "<table><tr><td>\n";

    echo myTextForm('players.php?op=delete_ok&player_id=' . $tvplayer->getVar('player_id') . '', _YES);

    echo "</td><td>\n";

    echo myTextForm('players.php?op=list', _NO);

    echo "</td></tr></table>\n";

    CloseTable();
}

// action suppression
function tv_players_suppr_ok($player_id)
{
    $tvplayer = new TVPlayer($player_id);

    $tvplayer->delete();

    redirect_header('players.php', 1, _AM_DBUPDATED);

    exit();
}

// ecran modification
function tv_players_modif($player_id)
{
    $tvplayer = new TVPlayer($player_id);

    $player_form = new XoopsThemeForm(_AM_EDITPLAYER, 'players_form', 'players.php');

    $player_text = new XoopsFormText(_AM_PLAYER, 'player', 10, 10, $tvplayer->getVar('player'));

    $player_form->addElement($player_text);

    $desc_text = new XoopsFormText(_AM_DESCRIPTION, 'description', 50, 255, $tvplayer->getVar('description', 'E'));

    $player_form->addElement($desc_text);

    $codePlayer_tarea = new XoopsFormTextarea(_AM_CODEPLAYER, 'codePlayer', $tvplayer->getVar('codePlayer', 'E'), 10);

    $player_form->addElement($codePlayer_tarea);

    $lien_text = new XoopsFormText(_AM_LIEN, 'lien', 50, 255, $tvplayer->getVar('lien', 'E'));

    $player_form->addElement($lien_text);

    $codeBoutons_tarea = new XoopsFormTextarea(_AM_CODEBOUTONS, 'codeBoutons', $tvplayer->getVar('codeBoutons', 'E'), 10);

    $player_form->addElement($codeBoutons_tarea);

    $codePlay_tarea = new XoopsFormTextarea(_AM_CODEPLAY, 'codePlay', $tvplayer->getVar('codePlay', 'E'), 10);

    $player_form->addElement($codePlay_tarea);

    $codeStop_tarea = new XoopsFormTextarea(_AM_CODESTOP, 'codeStop', $tvplayer->getVar('codeStop', 'E'), 10);

    $player_form->addElement($codeStop_tarea);

    $codePause_tarea = new XoopsFormTextarea(_AM_CODEPAUSE, 'codePause', $tvplayer->getVar('codePause', 'E'), 10);

    $player_form->addElement($codePause_tarea);

    $codeMute_tarea = new XoopsFormTextarea(_AM_CODEMUTE, 'codeMute', $tvplayer->getVar('codeMute', 'E'), 10);

    $player_form->addElement($codeMute_tarea);

    //$more_label = new XoopsFormLabel("", "<br><a href='index.php?op=ajouter&amp;player_id=".$tvplayer->getVar("player")."'>"._AM_ADDMORE."</a>");

    //$option_tray->addElement($more_label);

    //$player_form->addElement($option_tray);

    $op_hidden = new XoopsFormHidden('op', 'modif_ok');

    $player_form->addElement($op_hidden);

    $player_id_hidden = new XoopsFormHidden('player_id', $tvplayer->getVar('player_id'));

    $player_form->addElement($player_id_hidden);

    $submit_button = new XoopsFormButton('', 'player_submit', _SUBMIT, 'submit');

    $player_form->addElement($submit_button);

    xoops_cp_header();

    OpenTable();

    $player_form->display();

    CloseTable();
}

// action modification
function tv_players_modif_ok($player_id, $player, $description, $codePlayer, $lien, $codeBoutons, $codePlay, $codeStop, $codePause, $codeMute)
{
    //	$tvplayer = new TVPlayer(array("player"=>$player_id,"description"=>$description,"codePlayer"=>$codePlayer,"lien"=>$lien,"codeBoutons"=>$codeBoutons,"codePlay"=>$codePlay,"codeStop"=>$codeStop,"codePause"=>$codePause,"codeMute"=>$codeMute));

    $tvplayer = new TVPlayer($player_id);

    $tvplayer->setVar('player', $player);

    $tvplayer->setVar('description', $description);

    $tvplayer->setVar('codePlayer', $codePlayer);

    $tvplayer->setVar('lien', $lien);

    $tvplayer->setVar('codeBoutons', $codeBoutons);

    $tvplayer->setVar('codePlay', $codePlay);

    $tvplayer->setVar('codeStop', $codeStop);

    $tvplayer->setVar('codePause', $codePause);

    $tvplayer->setVar('codeMute', $codeMute);

    if (!$tvplayer->store()) {
        echo $tvplayer->getErrors();

        exit();
    }

    redirect_header('players.php', 1, _AM_DBUPDATED);

    exit();
}

switch ($op) {
    case 'ajout':
        tv_players_ajout();
        break;
    case 'ajout_ok':
        tv_players_ajout_ok($player, $description, $codePlayer, $lien, $codeBoutons, $codePlay, $codeStop, $codePause, $codeMute);
        break;
    case 'edit':
        tv_players_modif($player_id);
        break;
    case 'modif_ok':
        tv_players_modif_ok($player_id, $player, $description, $codePlayer, $lien, $codeBoutons, $codePlay, $codeStop, $codePause, $codeMute);
        break;
    case 'delete':
        tv_players_suppr($player_id);
        break;
    case 'delete_ok':
        tv_players_suppr_ok($player_id);
        break;
    default:
        tv_players_admin();
}

include 'admin_footer.php';
