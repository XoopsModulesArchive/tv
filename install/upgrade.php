<?php
// Upgrade du module TV
// Le mode d'emploi est dans docs/install.txt
// Module d'installation pour PostNuke .64 par kyex - octobre 2001
// Version XOOPS RC2 par kyex - fevrier 2002
// Version RC3 par kyex
// mise a jour globale pour 1.0,1.2 et 1.9  - aout 2002

include '../../../mainfile.php';

function entete()
{
    echo '' . '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">' . '<HTML>' . '<HEAD>' . '<TITLE>Upgrade module TV pour XOOPS RC2</TITLE>' . '</HEAD>' . '<BODY>' . '<CENTER><H1>Upgrade vers v1.9.5</H1></CENTER><br><br>';
}

function pied()
{
    echo '</BODY></HTML>';
}

function license()
{
    entete();

    echo '' . '<form action=upgrade.php method="post">' . '<center>';

    echo 'License<br>' . '<textarea name="license" cols=50 rows=8>';

    include '../docs/licence.txt';

    echo '</textarea><br><br>' . 'Credits<br>' . '<textarea name="credits" cols=80 rows=8>';

    include '../docs/credits.txt';

    echo '</textarea><br><br>' . '<input type="submit" name="op" value="Suite">' . '</center>' . '</form>';

    pied();
}

function AlterTable()
{
    global $xoopsDB, $dbhost, $dbuname, $dbpass, $dbname;

    global $prefix;

    entete();

    // 1.2 vers 1.9

    echo '<h2>Modification de la table ' . $xoopsDB->prefix('television') . '</h2>';

    echo '<i>ALTER TABLE ' . $xoopsDB->prefix('television') . '</i><br>'; // modif de la table

    $result = $xoopsDB->query(
        'ALTER TABLE ' . $xoopsDB->prefix('television') . " ADD
              date int(10) NOT NULL default '0';"
    );

    // 1.9 vers 1.95
    echo '<i>ALTER TABLE ' . $xoopsDB->prefix('television') . '</i><br>'; // modif de la table
    $result = $xoopsDB->query(
        'ALTER TABLE ' . $xoopsDB->prefix('television') . ' MODIFY
             urlram varchar(250) NOT NULL;'
    );

    $result = $xoopsDB->query(
        'ALTER TABLE ' . $xoopsDB->prefix('television') . ' ADD
             tvdescription text NULL;'
    );

    echo '<h2>Renommer la table ' . $xoopsDB->prefix('television') . ' en ' . $xoopsDB->prefix('tv') . '</h2>';

    echo '<i>RENAME TABLE ' . $xoopsDB->prefix('television') . '</i><br>'; // modif de la table

    $result = $xoopsDB->query('ALTER TABLE ' . $xoopsDB->prefix('television') . ' RENAME ' . $xoopsDB->prefix('tv') . ';');

    // accès à la suite :)

    echo '<form action=upgrade.php method="post">' . '<center>' . 'Champ <i>date</i> ajouté!!!<br>' . '<table width="50%" align=center>'; ?>
    <tr>
        <td align=center>
            <INPUT type="hidden" name="rien" value="rien">
            <INPUT type="submit" name="op" value="Continue">
        </td>
    </tr>
    </table>
    </center>
    </form>
    <?php
    pied();
}

function CreateTable()
{
    global $xoopsDB, $dbhost, $dbuname, $dbpass, $dbname;

    global $prefix;

    entete();

    // si on est en 1.9, on renomme la table tv_userpref

    // sinon, on la crée!!!

    echo '<h2>Renommer la table ' . $xoopsDB->prefix('television_userspref') . ' en ' . $xoopsDB->prefix('tv_userspref') . '</h2>';

    echo '<i>Rename TABLE ' . $xoopsDB->prefix('television_userspref') . '</i><br>'; // modif de la table

    $result = $xoopsDB->query('ALTER TABLE ' . $xoopsDB->prefix('television_userspref') . ' RENAME ' . $xoopsDB->prefix('tv_userspref') . ';');

    echo '<h2>Creation de la table ' . $xoopsDB->prefix('tv_userspref') . '</h2>';

    echo '<i>CREATE TABLE ' . $xoopsDB->prefix('tv_userspref') . '</i><br>'; // creation de la table

    $result = $xoopsDB->query(
        'CREATE TABLE ' . $xoopsDB->prefix('tv_userspref') . " (
            uid int(5) NOT NULL default '0',
            type varchar(8) NOT NULL default '',
            valeur text NOT NULL,
            UNIQUE KEY uid (uid,type)
            ) ENGINE = ISAM;"
    );

    // Table Players pour v1.95

    echo '<h2>Creation de la table ' . $xoopsDB->prefix('tv_players') . '</h2>';

    echo '<i>CREATE TABLE ' . $xoopsDB->prefix('tv_players') . '</i><br>'; // creation de la table

    $result = $xoopsDB->query(
        'CREATE TABLE ' . $xoopsDB->prefix('tv_players') . " (
            player_id mediumint(8) NOT NULL auto_increment,
            player varchar(10) NOT NULL default '',
            description varchar(100) NOT NULL default '',
            codePlayer text NOT NULL,
            lien varchar(100) NOT NULL default '',
            codeBoutons text NOT NULL,
            codePlay text NOT NULL,
            codeStop text NOT NULL,
            codePause text NOT NULL,
            codeMute text NOT NULL,
            PRIMARY KEY  (player_id),
            UNIQUE KEY player (player)
            ) ENGINE = ISAM;"
    );

    // accès à la suite :)

    echo '<form action=upgrade.php method="post">' . '<center>' . 'Table <i>' . $xoopsDB->prefix('tv_userspref') . '</i> ajoutée ou mise à jour!!!<br>' . 'Table <i>' . $xoopsDB->prefix('tv_players') . '</i> ajoutée!!!<br>' . '<table width="50%" align=center>'; ?>
    <tr>
        <td align=center>
            <INPUT type="hidden" name="rien" value="rien">
            <INPUT type="submit" name="op" value="Finish">
        </td>
    </tr>
    </table>
    </center>
    </form>
    <?php
    pied();
}

function fin()
{
    global $xoopsDB, $dbhost, $dbuname, $dbpass, $dbname;

    global $prefix;

    echo '<h2>Insertion des players dans la table ' . $xoopsDB->prefix('tv_players') . '</h2>';

    echo '<i>INSERT some players INTO ' . $xoopsDB->prefix('tv_players') . '</i><br>';

    $result = $xoopsDB->query(
        'INSERT INTO  ' . $xoopsDB->prefix('tv_players') . " (player, description, codePlayer, lien, codeBoutons, codePlay, codeStop, codePause, codeMute)
      VALUES ('real', 'Real Video',
 '<object classid=\"clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA\" height=\"\$height\" id=\"stream\" width=\"\$width\">\r\n <param name=\"_ExtentX\" value=\"6350\">\r\n <param name=\"_ExtentY\" value=\"4763\">\r\n <param name=\"AUTOSTART\" value=\"-1\">\r\n <param name=\"SHUFFLE\" value=\"0\">\r\n <param name=\"PREFETCH\" value=\"0\">\r\n <param name=\"NOLABELS\" value=\"0\">\r\n <param name=\"SRC\" value=\"\$urlram\">\r\n <param name=\"CONTROLS\" value=\"ImageWindow\">\r\n <param name=\"CONSOLE\" value=\"video1\">\r\n <param name=\"LOOP\" value=\"0\">\r\n <param name=\"NUMLOOP\" value=\"0\">\r\n <param name=\"CENTER\" value=\"0\">\r\n <param name=\"MAINTAINASPECT\" value=\"0\">\r\n<embed src=\"\$urlram\" width=\"\$width\" height=\"\$height\" controls=\"ImageWindow\" autostart=\"-1\" console=\"cons\" type=\"audio/x-pn-realaudio-plugin\" designtimesp=\"3165\" _extentx=\"6350\" _extenty=\"4763\" shuffle=\"0\" prefetch=\"0\" nolabels=\"0\" loop=\"0\" numloop=\"0\" center=\"0\" maintainaspect=\"0\">\r\n</embed>\r\n</object>',
 'http://real.com',
 '<object id=Object1 name=realPlayer classid=clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA width=26 height=26 VIEWASTEXT>\"\r\n<param name=\"SRC\" value=\"\$urlram\">\"\r\n<param name=\"CONTROLS\" value=\"PlayOnlyButton\">\"\r\n<param name=\"CONSOLE\" value=\"video1\">\"\r\n<embed name=\"CONTROLS\" width=\"26\" height=\"26\" controls=\"PlayOnlyButton\"\r\n	console=\"video1\" type=\"audio/X-pn-realaudio-plugin\" >\"\r\n</embed>\r\n</object>\r\n<object id=Object2 name=realPlayer classid=clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA width=26 height=26 VIEWASTEXT>\"\r\n<param name=\"CONTROLS\" value=\"StopButton\">\"\r\n<param name=\"CONSOLE\" value=\"video1\">\"\r\n<embed name=\"CONTROLS\" width=\"26\" height=\"26\" controls=\"StopButton\"\r\n   console=\"video1\" type=\"audio/X-pn-realaudio-plugin\" >\"\r\n</embed>\r\n</object>\r\n<object id=Object3 name=realPlayer classid=clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA width=114 height=26 VIEWASTEXT>\"\r\n<param name=\"CONTROLS\" value=\"PositionField\">\"\r\n<param name=\"CONSOLE\" value=\"video1\">\"\r\n<embed name=\"CONTROLS\" width=\"114\" height=\"26\" controls=\"PositionField\"\r\n   console=\"video1\" type=\"audio/X-pn-realaudio-plugin\" >\"\r\n</embed>\r\n</object>\r\n<object id=Object4 name=realPlayer classid=clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA width=26 height=26 VIEWASTEXT>\"\r\n<param name=\"CONTROLS\" value=\"MuteCtrl\">\"\r\n<param name=\"CONSOLE\" value=\"video1\">\"\r\n<embed name=\"CONTROLS\" width=\"26\" height=\"26\" controls=\"MuteCtrl\"\r\n   console=\"video1\" type=\"audio/X-pn-realaudio-plugin\" >\"\r\n</embed>\r\n</object>',
 '<object id=Object1 name=realPlayer classid=clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA width=26 height=26 VIEWASTEXT>\"\r\n<param name=\"SRC\" value=\"\$urlram\">\"\r\n<param name=\"CONTROLS\" value=\"PlayOnlyButton\">\"\r\n<param name=\"CONSOLE\" value=\"video1\">\"\r\n<embed name=\"CONTROLS\" width=\"26\" height=\"26\" controls=\"PlayOnlyButton\"\r\n	console=\"video1\" type=\"audio/X-pn-realaudio-plugin\" >\"\r\n</embed>\r\n</object>',
 '<object id=Object2 name=realPlayer classid=clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA width=26 height=26 VIEWASTEXT>\"\r\n<param name=\"CONTROLS\" value=\"StopButton\">\"\r\n<param name=\"CONSOLE\" value=\"video1\">\"\r\n<embed name=\"CONTROLS\" width=\"26\" height=\"26\" controls=\"StopButton\"\r\n   console=\"video1\" type=\"audio/X-pn-realaudio-plugin\" >\"\r\n</embed>\r\n</object>',
 '',
'<object id=Object4 name=realPlayer classid=clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA width=26 height=26 VIEWASTEXT>\"\r\n<param name=\"CONTROLS\" value=\"MuteCtrl\">\"\r\n<param name=\"CONSOLE\" value=\"video1\">\"\r\n<embed name=\"CONTROLS\" width=\"26\" height=\"26\" controls=\"MuteCtrl\"\r\n   console=\"video1\" type=\"audio/X-pn-realaudio-plugin\" >\"\r\n</embed>\r\n</object>'
      );"
    );

    $result = $xoopsDB->query(
        'INSERT INTO  ' . $xoopsDB->prefix('tv_players') . " (player, description, codePlayer, lien, codeBoutons, codePlay, codeStop, codePause, codeMute)
      VALUES ('wm', 'Windows Media',
 '<OBJECT ID=\"MediaPlayer1\" classid=\"CLSID:22d6f312-b0f6-11d0-94ab-0080c74c7e95\" CODEBASE=\"http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=5,1,52,701\" height=\"\$height\" width=\"\$width\" standby=\"Loading Microsoft Windows Media Player components...\" type=\"application/x-oleobject\">\r\n <PARAM NAME=\"FileName\" VALUE=\"\$urlram\">\r\n <PARAM NAME=\"TransparentAtStart\" Value=\"true\">\r\n <PARAM NAME=\"AutoStart\" Value=\"true\">\r\n <PARAM NAME=\"AnimationatStart\" Value=\"true\">\r\n <PARAM NAME=\"ShowControls\" Value=\"false\">\r\n <PARAM NAME=\"autoSize\" 		 Value=\"false\">\r\n <PARAM NAME=\"displaySize\" 	 Value=\"0\">\r\n<EMBED type=\"application/x-mplayer2\" pluginspage=\"http://www.microsoft.com/Windows/MediaPlayer/\" src=\"\$urlram\" Name=MediaPlayer1 AutoStart=-1 Width=\$width Height=\$height transparentAtStart=0 animationAtStart=-1 ShowControls=0 autoSize=0 displaySize=0>\r\n</EMBED>\r\n</OBJECT>',
 'http://windowsmedia.microsoft.com',
 '<a href=\"#####\" onclick=\"document.MediaPlayer1.Play();\" ><img name=\"btnPlay\" src=\"images/play.gif\" border=0></a>\r\n<a href=\"#####\" onclick=\"document.MediaPlayer1.Stop();\"><img name=\"btnStop\" src=\"images/stop.gif\" border=0></a>\r\n<a href=\"#####\" onclick=\"document.MediaPlayer1.Pause();\"><img name=\"btnPause\"src=\"images/pause.gif\" border=0></a>\r\n<a href=\"#####\" onclick=\"muteClick()\"><img name=\"btnMute\" src=\"images/volume.gif\" border=0></a>',
 '<a href=\"#####\" onclick=\"document.MediaPlayer1.Play();\" ><img name=\"btnPlay\" src=\"images/play.gif\" border=0></a>',
 '<a href=\"#####\" onclick=\"document.MediaPlayer1.Stop();\"><img name=\"btnStop\" src=\"images/stop.gif\" border=0></a>',
 '<a href=\"#####\" onclick=\"document.MediaPlayer1.Pause();\"><img name=\"btnPause\"src=\"images/pause.gif\" border=0></a>',
 '<a href=\"#####\" onclick=\"muteClick()\"><img name=\"btnMute\" src=\"images/volume.gif\" border=0></a>'
     );"
    );

    $result = $xoopsDB->query(
        'INSERT INTO  ' . $xoopsDB->prefix('tv_players') . " (player, description, codePlayer, lien, codeBoutons)
      VALUES ('qt', 'QuickTime',
 '<OBJECT CLASSID=\"clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B\" WIDTH=\$width HEIGHT=\$height CODEBASE=\"http://www.apple.com/qtactivex/qtplugin.cab\">\r\n <PARAM NAME=\"SRC\" VALUE=\"\$urlram\">\r\n <PARAM NAME=\"AUTOPLAY\" VALUE=\"true\">\r\n <PARAM NAME=\"CONTROLLER\" VALUE=\"TRUE\">\r\n <PARAM NAME=\"target\" VALUE=\"myself\">\r\n <EMBED WIDTH=\$width TARGET=MYSELF SRC=\"\$urlram\" HEIGHT=\$height PLUGINSPAGE=\"http://www.apple.com/quicktime/download/index.html\" CONTROLLER=TRUE CACHE=\"true\">\r\n</OBJECT>\";', 'http://www.apple.com/quicktime/download/index.html', ''
     );"
    );

    echo '<i>Players inserted</i><br>';

    echo '<h2>Mise a jour de la table ' . $xoopsDB->prefix('tv') . ' pour les player_id</h2>';

    echo '<i>Update ' . $xoopsDB->prefix('tv') . ' for player_id</i><br>';

    $result = $xoopsDB->query('update ' . $xoopsDB->prefix('tv') . " set player_id=1 where player='real'");

    $result = $xoopsDB->query('update ' . $xoopsDB->prefix('tv') . " set player_id=2 where player='wm'");

    $result = $xoopsDB->query('update ' . $xoopsDB->prefix('tv') . " set player_id=3 where player='qt'");

    echo '<id>updated</i>';

    echo 'Mise &agrave; jour effectu&eacute;e !<br>';

    echo '<center> La mise à jour est terminée&nbsp;&nbsp;<i>Upgrade completed</i></center>';

    echo 'Vous pouvez (devez) maintenant supprimer le r&eacute;pertoire <b>tv/install</b><br>';

    echo '<I>You can (must) DELETE the directory <b>tv/install</b></i>';
}

switch ($op) {
    case 'Suite':
        AlterTable();
        break;
    case 'Continue':
        CreateTable();
        break;
    case 'Finish':
        fin();
        break;
    default:
        license();
        break;
}

?>
