<?php
// Upgrade du module TV
// Le mode d'emploi est dans docs/install.txt
// Module d'installation pour PostNuke .64 par kyex - octobre 2001
// Version XOOPS RC2 par kyex - fevrier 2002

include '../../../mainfile.php';

//echo "db = $dbname<br>";

function entete()
{
    echo '' . '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">' . '<HTML>' . '<HEAD>' . '<TITLE>Upgrade module TV pour XOOPS RC2</TITLE>' . '</HEAD>' . '<BODY>' . '<CENTER><H1>Upgrade du module TV vers 1.2</H1></CENTER><br><br>';
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

    echo '<h2>Modification de la table ' . $xoopsDB->prefix('television') . '</h2>';

    echo '<i>ALTER TABLE ' . $xoopsDB->prefix('television') . '</i><br>'; // modif de la table

    $result = $xoopsDB->query(
        'ALTER TABLE ' . $xoopsDB->prefix('television') . ' ADD
            tvdescription text NULL;'
    ) or die('<font class="post-failed">Unable to alter ' . $xoopsDB->prefix('television') . '</font>');

    // accès à la suite :)

    echo '<form action=upgrade.php method="post">' . '<center>' . 'Champ <i>player</i> ajouté!!!<br>' . '<table width="50%" align=center>'; ?>
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

switch ($op) {
    case 'Suite':
        AlterTable();
        break;
    case 'Finish':
        fin();
        break;
    default:
        license();
        break;
}

?>
