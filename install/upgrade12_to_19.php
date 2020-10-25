<?php
// Upgrade du module TV
// Le mode d'emploi est dans docs/install.txt
// Module d'installation pour PostNuke .64 par kyex - octobre 2001
// Version XOOPS RC2 par kyex - fevrier 2002

include "../../../mainfile.php";

//echo "db = $dbname<br>";

function entete()
{
    echo "" . "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">" . "<HTML>" . "<HEAD>" . "<TITLE>Upgrade module TV pour XOOPS RC2</TITLE>" . "</HEAD>" . "<BODY>" . "<CENTER><H1>Upgrade du module TV 1.2 vers v1.9</H1></CENTER><br><br>";
}

function pied()
{
    echo "</BODY></HTML>";
}

function license()
{
    entete();
    echo "" . "<form action=upgrade12_to_19.php method=\"post\">" . "<center>";
    echo "License<br>" . "<textarea name=\"license\" cols=50 rows=8>";
    include "../docs/licence.txt";
    echo "</textarea><br><br>" . "Credits<br>" . "<textarea name=\"credits\" cols=80 rows=8>";
    include "../docs/credits.txt";
    echo "</textarea><br><br>" . "<input type=\"submit\" name=\"op\" value=\"Suite\">" . "</center>" . "</form>";
    pied();
}

function AlterTable()
{
    global $xoopsDB, $dbhost, $dbuname, $dbpass, $dbname;
    global $prefix;

    entete();
    echo "<h2>Modification de la table " . $xoopsDB->prefix("television") . "</h2>";
    echo "<i>ALTER TABLE " . $xoopsDB->prefix("television") . "</i><br>";// modif de la table
    $result = $xoopsDB->query(
        "ALTER TABLE " . $xoopsDB->prefix("television") . " ADD
              date int(10) NOT NULL default '0';"
    ) or die ("<font>Unable to alter " . $xoopsDB->prefix("television") . "</font>");

    // accès à la suite :)
    echo "<form action=upgrade12_to_19.php method=\"post\">" . "<center>" . "Champ <i>date</i> ajouté!!!<br>" . "<table width=\"50%\" align=center>";
    ?>
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
    echo "<h2>Creation de la table " . $xoopsDB->prefix("television_userspref") . "</h2>";
    echo "<i>CREATE TABLE " . $xoopsDB->prefix("television_userspref") . "</i><br>";// creation de la table
    $result = $xoopsDB->query(
        "CREATE TABLE " . $xoopsDB->prefix("television_userspref") . " (
            uid int(5) NOT NULL default '0',
            type varchar(8) NOT NULL default '',
            valeur text NOT NULL,
            UNIQUE KEY uid (uid,type)
            ) ENGINE = ISAM;"
    ) or die ("<font class=\"post-failed\">Unable to make " . $xoopsDB->prefix("television_userspref") . "</font>");

    // accès à la suite :)
    echo "<form action=upgrade12_to_19.php method=\"post\">" . "<center>" . "Table <i>"$xoopsDB->prefix("television_userspref") . "</i> ajouté!!!<br>" . "<table width=\"50%\" align=center>";
?>
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
    case "Suite":
        AlterTable();
        break;

    case "Continue":
        CreateTable();
    case "Finish":
        fin();
        break;

    default:
        license();
        break;
}

?>
