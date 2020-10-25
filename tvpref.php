<?php

/*
************************************************************************************************
*                    Module TV 1.9  pour XOOPS RC3
*
* Créé par Codephp (http://www.codephp.net) et ckforum (http://ckforum.dyndns.org) pour MPN
* adapté à XOOPS et enrichi par kyex (http://kyex.inconnueteam.com)
* pour toute question n'hésitez pas à me contacter sur kyeXoops
*************************************************************************************************
*/

// 20/10/2001 adaption PostNuke 0.64 par kyex
// 12/01/2002 adaptation XOOPS par kyex
// 10/02/2002 v1.2 pour XOOPS RC2 par kyex
// 27/04/2002 v1.9 pour XOOPS RC2 par kyex (beta de la 2.0)
// 06/06/2002 V1.9 pour XOOPS RC3 par kyex

include "header.php";
include "cache/config.php";
include "class/class.tv.php";
include "include/fonctions.php";
require_once XOOPS_ROOT_PATH . "/class/module.textsanitizer.php";
require XOOPS_ROOT_PATH . "/header.php";

//echo "<body class='bg1'>";

// selection dans un combo box.
// on récupère les chaînes dans un tableau
/* on garde pour plus tard : gestion des chaines préférées
/$siteliste = tv::getAllTVs(0,false);
$hid=$topic;
echo "<br><table border='0' align=center>
        <form action=\"tv.php\" method=\"post\">
        <tr>
        <td valign='middle'>"._TV_NOM_CHAINE.":</td>
        <td valign='middle'>";
    echo "<SELECT NAME=\"topic\" onChange=\"submit($hid)\">";

    echo "<OPTION VALUE=\"\">"._TV_SELECT_CHAINE."</option>\n";
    foreach($siteliste as $hid=>$sitename)
    {
        if ($hid==$topic) { $sel = "selected "; }
        echo "<option $sel value=\"$hid\">$sitename</option>\n";
        $sel = "";
    }
echo "
        </td>
        </tr>
        </form>
        </table>";
*/

/// PARTIE EN TEST : userpref
///
///error_reporting(E_ALL);
if (!$xoopsUser) {
    echo _TV_NO_ANO . "<br>";
    require XOOPS_ROOT_PATH . "/footer.php";
    exit;
} else {
    //    echo"uid = ".$xoopsUser->uid()."<br>";
    $tvpref = new TVUserPref($xoopsUser->getVar("uid"));
    //    echo "op = $op<br>";
    // modif 1/2/02 : un seul FORM, utilisation comparaison anciennes/nouvelles valeurs
    /*
        switch($op)
        {
            case "skin":
                 $tvpref->setOption("skin",$newskin);
                 $tvpref->save();
                 break;
            case "chdef":
                 $tvpref->setOption("chdef",$chdef);
                 $tvpref->save();
                 break;
        }
    */
    if (isset($op)) {
        $tvpref->setOption("skin", $newskin);
        $tvpref->setOption("chdef", $chdef);
        $tvpref->save();
    }
    $skin  = $tvpref->getOption("skin");
    $chdef = $tvpref->getOption("chdef");
}

OpenTable();
// modif 01/07/02 : un seul formulaire, avec test des modifs
echo "<form action=\"tvpref.php\" method=\"post\">
<table><tr><td valign='middle'>" . _TV_CHOIXSKIN . ":</td>
        <td valign='middle'>";
echo "<SELECT NAME=\"newskin\">";
echo "<OPTION VALUE=\"\">" . _TV_DEFSKIN . "</option>\n";
$skins_dir = XOOPS_ROOT_PATH . "/modules/tv/skins";
$handle    = opendir($skins_dir);
while ($file = readdir($handle)) {
    clearstatcache();
    if (!ereg("^[.]{1,2}$", $file) && is_dir($skins_dir . "/" . $file)) {
        $sel = "";
        if ($file == $skin) {
            $sel = "selected ";
        }
        echo "<option $sel value=\"$file\">$file</option>\n";
    }
}
echo "</select>";
echo "</td></tr><tr><td>";
//echo "<input type=hidden name=oldskin value=\"$skin\">";
//echo "<input type=hidden name=op value=skin>";
//echo "<input type=submit value='"._SUBMIT."'>";
echo "</td></tr>";
//echo "</table></form>";

$siteliste = tv::getAllTVs(0, false);
//echo "<form action=\"tvpref.php\" method=\"post\">";
//echo "<table>";
echo "<tr><td valign='middle'>" . _TV_DEFCHAINE . ":</td>
        <td valign='middle'>";
echo "<SELECT NAME=\"chdef\">";

echo "<OPTION VALUE=\"\">" . _NONE . "</option>\n";
foreach ($siteliste as $hid => $sitename) {
    $sel = "";
    if ($hid == $chdef) {
        $sel = "selected ";
    }
    echo "<option $sel value=\"$hid\">$sitename</option>\n";
}

//echo "</td></tr><tr><td>";
//echo "<input type=hidden name=op value=chdef>";
//echo "<input type=hidden name=oldchdef value=\"$chdef\">";
echo "</td></tr>";
// chaines préférées

// validation et fin du formulaire
echo "<tr><td><center><input name ='op' type=submit value='" . _SUBMIT . "'></center>";
echo "</td></tr>";
echo "</form></table>";

CloseTable();
require XOOPS_ROOT_PATH . "/footer.php";

?>

