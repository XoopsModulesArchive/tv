<?

/*
************************************************************************************************
*                    Module TV1.9  pour XOOPS RC3
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
// 08/2002 v1.95 pour XOOPS RC3 par kyex

include "header.php";
include "cache/config.php";
include "class/class.tv.php";
include "include/fonctions.php";
require_once XOOPS_ROOT_PATH . "/class/module.textsanitizer.php";

/*
****************************************************************************************
* télévision par defaut
* 
* recuperation des variables du fichier config.php qui se trouve dans admin/modules.
****************************************************************************************
*/

$urlram    = $urlram1;
$sitesurl  = $sitesurl1;
$logo      = $logo1;
$sitename2 = $sitename21;
$player    = $player1;
/*
**************************************************
* Ne modifiez pas les paramètres ci-dessous
* Sauf si vous savez ce que vous faîtes :)
**************************************************
*/

// ENTETE HTML

echo tv_affiche_entete_html();

//error_reporting(E_ALL);
if ($xoopsUser) {
    //    echo"uid = ".$xoopsUser->uid()."<br>";
    $tvpref = new TVUserPref($xoopsUser->getVar("uid"));
    //    echo "topic=$topic,".$tvpref->getOption("chdef")." <br>";
    $skin = $tvpref->getOption("skin");
    if ($skin) {
        $nomskin = $skin;
    }
    if ($topic == 0) {
        $topic = $tvpref->getOption("chdef");
    }
}

if ($topic != 0) {
    $tv = new TV($topic);
    $tv->addclicktv();
    // voir si la suite est tjr utile ou si on n'utilise plus que l'objet $tv
    $sitename2     = $tv->sitename;
    $urlram        = $tv->urlram;
    $sitesurl      = $tv->sitesurl;
    $logo          = $tv->logo;
    $tvdescription = $tv->tvdescription;
    $player        = $tv->player;
} else {
    $tvdescription = "";
    $tv            = new TV();
    $tv->makeTV(["hid" => 0, "sitename" => $sitename2, "urlram" => $urlram, "sitesurl" => $sitesurl, "logo" => $logo, "tvdescription" => $tvdescription, "player" => $player]);
}

// on inclut le script correspondant au player en cours, s'il existe
if (file_exists(XOOPS_ROOT_PATH . "/modules/tv/include/$player.js")) {
    echo "<script language='JavaScript' src='" . XOOPS_URL . "/modules/tv/include/$player.js'></script>";
}

echo "<body>";
// selection dans un combo box.
// on récupère les chaînes dans un tableau
$siteliste = tv::getAllTVs(0, false);
$hid       = $topic;
echo "<br><table border='0' align=center>
        <form action=\"tv.php\" method=\"post\">
        <tr>
        <td valign='middle'>" . _TV_NOM_CHAINE . ":</td>
        <td valign='middle'>";
echo "<SELECT NAME=\"topic\" onChange=\"submit($hid)\">";

echo "<OPTION VALUE=\"\">" . _TV_SELECT_CHAINE . "</option>\n";
foreach ($siteliste as $hid => $sitename) {
    if ($hid == $topic) {
        $sel = "selected ";
    }
    echo "<option $sel value=\"$hid\">$sitename</option>\n";
    $sel = "";
}
echo "</select>
        </td>
        </tr>
        </form>
        </table>";

/// PARTIE EN TEST : Gestion des skins et userpref
//error_reporting(E_ALL);
// ouverture du fichier de skin

if ($xoopsUser) {
    //    echo"uid = ".$xoopsUser->uid()."<br>";
    $tvpref = new TVUserPref($xoopsUser->getVar("uid"));
    $skin   = $tvpref->getOption("skin");
    if ($skin) {
        $nomskin = $skin;
    }
}
$res = chdir("skins/$nomskin");
//echo "skin=$nomskin, res=$res<br>";
include "config.php";
// on se positionne pour pouvoir travailler en relatif par rapport à la skin
$lines   = file("skin.tpl");
$myts    = new MyTextSanitizer;
$comment = $myts->previewTarea($destv);

// initialisation des regex
$patterns     = [];
$replacements = [];

tv_init_regex(&$patterns, &$replacements, $tv, $height, $width, $comment);

foreach ($lines as $ligne) {
    echo preg_replace($patterns, $replacements, $ligne);
}

?>

