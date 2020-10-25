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

// ajouts pour XOOPS
include 'admin_header.php';
require_once XOOPS_ROOT_PATH . '/class/module.textsanitizer.php';
//require_once XOOPS_ROOT_PATH."/class/xoopscomments.php";
require XOOPS_ROOT_PATH . '/modules/tv/cache/config.php';
require XOOPS_ROOT_PATH . '/modules/tv/class/class.tv.php';

$myts = new MyTextSanitizer();

$hlpfile = 'tv.html';

/*
*********************************************************
* Liste de chaînes dispnibles sur votre site Module admin
*
*********************************************************
*/

function tv_admin()
{
    global $xoopsDB, $xoopsTheme;

    xoops_cp_header();

    OpenTable();

    tv_config();

    echo '
    <center><font size=4><b><A name="LISTE">' . _TV_LISTE . '</a></b></font></center>
    <form action=index.php method=post>
    <center><table width=100% border=0 cellspacing=1 cellpadding=1 class=bg2>
  <tr  class=bg1>
    <td align=center>' . _TV_ID . '</td>
    <td align=center>' . _TV_NOM_CHAINE . '</td>
    <td align=center>' . _TV_VU . '</td>
    <td align=center>' . _TV_URL_FICHIER_REAL . '</td>
    <td align=center>' . _TV_SITE_CHAINE . '</td>
    <td align=center>' . _TV_LOGO . '</td>
	<td align=center>' . _TV_DESCRIPTION_GENERALE . '</td>
    <td align=center>' . _TV_PLAYER . '</td>
    <td align=center>' . _TV_STATUT . '</td>
    <td align=center>' . _TV_ACTION . '</td>

   ';

    $result1 = $xoopsDB->query(
        'select hid,sitename,urlram,sitesurl,status,logo,tvdescription,player_id,clicktv
    from ' . $xoopsDB->prefix('tv') . ' order by hid'
    );

    error_reporting(E_ALL);

    $tvplayer = new TVPlayer();

    while (list(
        $hid, $sitenametv, $urlram, $sitesurl, $status, $logo, $tvdescription, $player_id, $clicktv
        ) = $xoopsDB->fetchRow($result1)) {
        if (mb_strlen($urlram) > 20) {
            $urlram = mb_substr($urlram, 0, 20);

            $urlram .= '...';
        }

        /*
        if (strlen($logo) > 30) {
                $logo= substr($logo, 0, 30);
               $logo.= "...";
            }
        */

        $tvplayer->load($player_id);

        echo "<tr class=bg1>
    <td align=center>$hid</td>
    <td align=center>$sitenametv</a></td>
	<td align=center>$clicktv</td>
    <td><a href='#####' onClick=javascript:openWithSelfMain('" . XOOPS_URL . "/modules/tv/tvreal.php?topic=$hid','TV',500,620);>$urlram</a></td>
    <td><a href=$sitesurl target=blanck>$sitesurl</a></td>
    <td align=center><img src=$logo width='50'></td>
    <td>$tvdescription</td>
    <td align=center>" . $tvplayer->getVar('player') . '</td>
    ';

        if (1 == $status) {
            $status = _TV_ACTIF;
        } else {
            $status = _TV_INACTIF;
        }

        echo "
    <td align=center>$status</td>
    <td align=center  nowrap><a href=index.php?req=tv_edit&hid=$hid>" . _EDIT . "</a>
      | <a href=index.php?req=tv_del&hid=$hid>" . _DELETE . '</a></td>

  </tr>';
    }

    //·s¼WÀW¹D³¡¤À

    echo '</table>
    <br><br>
    </center><font size=4><b><a name="AJOUT">' . _TV_AJOUT_CHAINE . '</a></b><br><br>
    <font size=2>
    <form action=index.php method=post>
    <table border=0 ><tr><td>
    ' . _TV_NOM_CHAINE . ' : </td><td><input type=text name=xsitenametv size=50 maxlength=50></td></tr><tr><td>
    ' . _TV_URL_FICHIER_REAL . ' : </td><td><input type=text name=urlram size=50 maxlength=250></td></tr><tr><td>
    ' . _TV_SITE_CHAINE . ' : </td><td><input type=text name=sitesurl size=50 maxlength=200></td></tr><tr><td>
    ' . _TV_LOGO . ' : </td><td><input type=text name=logo size=50 maxlength=200></td></tr><tr><td>
    ' . _TV_DESCRIPTION_GENERALE . ' : </td><td><textarea name=tvdescription cols=50 rows=5></textarea></td></tr><tr><td>
    ' . _TV_PLAYER . ' : </td><td><select name=player_id>';

    /*
        <option name=player value='real' selected>RealVideo</option>
        <option name=player value='wm'>Windows Media</option>
        <option name=player value='qt'>QuickTime</option>
    */

    // on utlise maintenant la classe TVPlayer

    $players_arr = TVPlayer::getAll(0, false);

    foreach ($players_arr as $player_id => $player_desc) {
        echo "<option name=player value='$player_id'>$player_desc</option>";
    }

    echo '</select></td></tr><tr><td>
    ' . _TV_STATUT . ' : </td><td><select name=status>
	<option name=status value=0>' . _TV_INACTIF . '</option>
	<option name=status value=1 selected>' . _TV_ACTIF . '</option>
	</select></td></tr></table>
    <input type=hidden name=req value=tv_add>
    <input type=submit value=' . _TV_AJOUTER . '>
    </form>
    </td></tr></table></td></tr></table>';
}

/*
*********************************************************
* Fonction d'édition d'une chaine
*********************************************************
*/

function tv_edit($hid)
{
    global $xoopsDB;

    $result = $xoopsDB->query('select sitename, urlram, sitesurl, status ,logo ,tvdescription, player, player_id from ' . $xoopsDB->prefix('tv') . " where hid='$hid'");

    [$xsitenametv, $urlram, $sitesurl, $status, $logo, $tvdescription, $player, $player_id] = $xoopsDB->fetchrow($result);

    xoops_cp_header();

    OpenTable();

    echo '
    <center><font size=4><b>' . _TV_MODIF_CHAINE . "</b></font></center>
    <form action=index.php method=post>
    <input type=hidden name=hid value=$hid>
    <table border=0 width=100%><tr><td>
    " . _TV_NOM_CHAINE . " </td><td><input type=\"text\" name=xsitenametv size=50 maxlength=50 value=\"$xsitenametv\"></td></tr><tr><td>
    " . _TV_URL_FICHIER_REAL . " </td><td><input type=text name=urlram size=50 maxlength=250 value=$urlram></td></tr><tr><td>
    " . _TV_SITE_CHAINE . " </td><td><input type=text name=sitesurl size=50 maxlength=200 value=$sitesurl></td></tr><tr><td>
    " . _TV_LOGO . " </td><td><input type=text name=logo size=50 maxlength=200 value=$logo></td></tr><tr><td>
    " . _TV_DESCRIPTION_GENERALE . " : </td><td><textarea name=tvdescription cols=50 rows=5>$tvdescription</textarea></td></tr><tr><td>
    " . _TV_PLAYER . ' </td><td><select name=player_id>';

    /*
        echo "
        <option player=status value=\"real\" $sel_real>RealVideo</option>
        <option player=status value=\"wm\" $sel_wm>Windows Media</option>
        <option player=status value=\"qt\" $sel_wm>QuickTime</option>
    */

    // on utlise maintenant la classe TVPlayer

    $tvplayers_arr = TVPlayer::getAll(0, false);

    foreach ($tvplayers_arr as $tvplayer_id => $tvplayer_desc) {
        $selected = ($tvplayer_id == $player_id) ? 'selected' : ' ';

        echo "<option name=player value='$tvplayer_id' $selected>$tvplayer_desc</option>";
    }

    echo '</select></td></tr><tr><td>
    ' . _TV_STATUT . ' </td><td><select name=status>';

    if (1 == $status) {
        $sel_a = 'selected';
    } else {
        $sel_i = 'selected';
    }

    echo "
	<option name=status value=1 $sel_a>" . _TV_ACTIF . "</option>
	<option name=status value=0 $sel_i>" . _TV_INACTIF . '</option>
	</select></td></tr></table>
    <input type=hidden name=req value=tv_save>
    <input type=submit value=' . _TV_ENREGISTRER . '>
    </form>
    </td></tr></table></td></tr></table>';
}

/*
*********************************************************
* Fonction de sauvegarde ou de modification d'une chaine
*********************************************************
*/

function tv_save($hid, $xsitenametv, $urlram, $sitesurl, $status, $logo, $tvdescription, $player_id)
{
    global $xoopsDB;

    // $xsitenametv = ereg_replace(" ", "", $xsitenametv);

    //echo "update ".$xoopsDB->prefix("tv")." set sitename='$xsitenametv', urlram='$urlram', sitesurl='$sitesurl', status='$status',logo='$logo', player='$player' where hid='$hid'";

    //echo "<br>";

    $xoopsDB->query('update ' . $xoopsDB->prefix('tv') . " set sitename='$xsitenametv', urlram='$urlram', sitesurl='$sitesurl', status='$status',logo='$logo',tvdescription='$tvdescription', player_id=$player_id where hid='$hid'");

    redirect_header('index.php', 1, _AM_DBUPDATED);

    exit();
}

/*
*********************************************************
* Fonction d'ajout d'une chaine
*********************************************************
*/

function tv_add($xsitenametv, $urlram, $sitesurl, $status, $logo, $tvdescription, $player_id)
{
    global $xoopsDB;

    // $xsitename = ereg_replace(" ", "", $xsitename);

    //echo "insert into ".$xoopsDB->prefix("tv")." values (NULL, '$xsitenametv', '$urlram', '$sitesurl', '$status' ,'$logo', '0', '$player')";

    //echo"<br>";

    $xoopsDB->queryF('insert into ' . $xoopsDB->prefix('tv') . "(sitename, urlram, sitesurl, status, logo, tvdescription, clicktv, player_id, date) values ('$xsitenametv', '$urlram', '$sitesurl', '$status' ,'$logo' ,'$tvdescription','0', $player_id," . time() . ')');

    redirect_header('index.php', 1, _AM_DBUPDATED);

    exit();
}

/*
*********************************************************
* Fonction de suppression d'une chaine
*********************************************************
*/

function tv_del($hid, $ok)
{
    global $xoopsDB;

    xoops_cp_header();

    OpenTable();

    echo '<center><br>';

    echo '<font size=3 color=Red>';

    echo '<b>' . _TV_CONFIRMER_SUPPR . '</b><br><br><font color=Black>';

    echo "[ <a href=index.php?req=tv_delete_ok&hid=$hid>" . _YES . '</a> | <a href=index.php>' . _NO . '</a> ]<br><br>';

    echo '</TD></TR></TABLE></TD></TR></TABLE>';
}

function tv_delete_ok($hid)
{
    global $xoopsDB;

    $res = $xoopsDB->queryF('delete from ' . $xoopsDB->prefix('tv') . " where hid=$hid");

    // echo "res de "."delete from ".$xoopsDB->prefix("tv")." where hid='$hid'"." = $res !!<br>";

    redirect_header('index.php', 1, _AM_DBUPDATED);

    exit();
}

/*
*********************************************************
* Fonction Configuration
*********************************************************
*/

function tv_config()
{
    // kyex: variable du fichier config.php du module

    global $xoopsDB, $urlram1, $sitesurl1, $logo1, $player1, $sitename21, $destv, $nomskin;

    global $xoopsDB, $xoopsConfig, $myts;

    OpenTable();

    echo '<center><font size=4><b>' . _TV_CONFIG . '</b></center><br><br>';

    // acces direct a la gestion des lecteurs :

    echo '<center><a href="players.php">[' . _AM_PLAYERSLIST . ']</a></center><br>';

    echo '<font size=2>';

    echo '<form action="index.php" method="post">';

    /*
    ********************************************************************************
    * Liste des Variables servant a renseigner le fichier config.php de l'add on TV
    *
    * Fonction Configuration
    * $urlram1
    * $sitesurl1
    * $logo1
    * $player1
    * $sitename21
    * $destv
    * $nomskin
    ********************************************************************************
    */

    echo '<br><br><center><font size=4><b>' . _TV_PARAM_CHAINE_DEFAUT . ' </center>';

    echo '<table border=0 width=100%><tr><td><br><br>';

    echo '</td></tr>';

    echo '<tr><td>' . _TV_URL_FICHIER_REAL . ' : </td><td>';

    echo "<input type=\"text\" name=\"xurlram1\" size=\"50\" value=\"$urlram1\"></td></tr>";

    echo '<tr><td>' . _TV_SITE_CHAINE . ' : </td><td>';

    echo "<input type=\"text\" name=\"xsitesurl1\" size=\"50\" value=\"$sitesurl1\"></td></tr>";

    echo '<tr><td>' . _TV_CHEMIN_LOGO . ' : </td><td>';

    echo "<input type=\"text\" name=\"xlogo1\" size=\"50\" value=\"$logo1\"></td></tr>";

    echo '<tr><td>' . _TV_PLAYER . ' : </td><td>';

    echo "<input type=\"text\" name=\"xplayer1\" size=\"50\" value=\"$player1\"></td></tr>";

    echo '<tr><td>' . _TV_NOM_CHAINE . ' : </td><td>';

    echo "<input type=\"text\" name=\"xsitename21\" size=\"50\" value=\"$sitename21\"></td></tr>";

    $destvedit = $myts->previewTarea($destv);

    $destvedit = $destv;

    echo ' <tr><td>';

    echo ' ' . _TV_DESCRIPTION_GENERALE . " : </td><td><textarea name=\"xdestv\" cols=50 rows=5>$destvedit</textarea>
    </td></tr>";

    echo '<tr><td>' . _TV_DEFSKIN . ' : </td><td>';

    echo '<SELECT NAME="xnomskin">';

    $skins_dir = XOOPS_ROOT_PATH . '/modules/tv/skins';

    //echo "sd = $skins_dir<br>";

    $handle = opendir($skins_dir);

    while ($file = readdir($handle)) {
        //    echo "file=$file<br>";

        clearstatcache();

        if (!ereg('^[.]{1,2}$', $file) && is_dir($skins_dir . '/' . $file)) {
            $sel = '';

            if ($file == $nomskin) {
                $sel = 'selected ';
            }

            echo "<option $sel value=\"$file\">$file</option>\n";
        }
    }

    echo '</select></td></tr>';

    echo '</table><br><br>';

    echo '<input type=hidden name=fct value=tv>';

    echo '<input type=hidden name=req value=tv_config_sauve>';

    echo '<input type=submit value=' . _TV_MODIFIER . '>';

    echo '</form>';

    //echo "</td></tr></table></td></tr></table>";

    closetable();
}

function tv_config_sauve($xurlram1, $xsitesurl1, $xlogo1, $xplayer1, $xsitename21, $xdestv, $xnomskin)
{
    global $xoopsDB, $fct, $nuke_url, $myts;

    global $ModName;

    $xdestvbody = $myts->addSlashes($xdestv);

    $filename = '../cache/config.php';

    $file = fopen($filename, 'wb');

    $content = '';

    $content .= "<?PHP\n";

    $content .= "\n";

    $content .= "/*\n";

    $content .= "************************************************************************************************\n";

    $content .= "*                    Module TV 1.9  pour XOOPS RC3\n";

    $content .= "*\n";

    $content .= "* Créé par Codephp (http://www.codephp.net) et ckforum (http://ckforum.dyndns.org) pour MPN\n";

    $content .= "* adapté à XOOPS et enrichi par kyex (http://kyexoops.multimania.com)\n";

    $content .= "* pour toute question n'hésitez pas à me contacter sur kyeXoops\n";

    $content .= "* Fichier CONFIG.PHP pour le module TV\n";

    $content .= "* Ce fichier sert à renseigner le site par défault de votre chaine TV\n";

    $content .= "* Les modifications de ce fichier sont apportées via le module admin de votre site XOOPS\n";

    $content .= "*************************************************************************************************\n";

    $content .= "*/\n";

    $content .= "\n";

    $content .= "// Adaptation Xoops par Kyex\n";

    $content .= "\$urlram1= \"$xurlram1\";\n";

    $content .= "\$sitesurl1= \"$xsitesurl1\";\n";

    $content .= "\$logo1= \"$xlogo1\";\n";

    $content .= "\$player1= \"$xplayer1\";\n";

    $content .= "\$sitename21= \"$xsitename21\";\n";

    $content .= "\$destv= \"$xdestv\";\n";

    $content .= "\$nomskin= \"$xnomskin\";\n";

    $content .= '?';

    $content .= ">\n";

    fwrite($file, $content);

    fclose($file);

    redirect_header('index.php', 1, _AM_DBUPDATED);

    exit();
}

//echo "op=$op ;req=$req !!!<br>";

switch ($req) {
    case 'tv_del':
        tv_del($hid, $ok);
        break;
    case 'tv_add':
        tv_add($xsitenametv, $urlram, $sitesurl, $status, $logo, $tvdescription, $player_id);
        break;
    case 'tv_save':
        tv_save($hid, $xsitenametv, $urlram, $sitesurl, $status, $logo, $tvdescription, $player_id);
        break;
    case 'tv_edit':
        tv_edit($hid);
        break;
    case 'tv_delete_ok':
        tv_delete_ok($hid);
        break;
    case 'tv_config_sauve':
        tv_config_sauve($xurlram1, $xsitesurl1, $xlogo1, $xplayer1, $xsitename21, $xdestv, $xnomskin);
        break;
    default:
        tv_admin();
        break;
}

// ajout XOOPS
include 'admin_footer.php';
