#
# Structure de la table `tv`
#

CREATE TABLE tv (
    hid           INT(11)      NOT NULL AUTO_INCREMENT,
    sitename      VARCHAR(50)  NOT NULL DEFAULT '',
    urlram        VARCHAR(250) NOT NULL DEFAULT '',
    sitesurl      VARCHAR(200) NOT NULL DEFAULT '',
    status        TINYINT(1)   NOT NULL DEFAULT '0',
    logo          VARCHAR(200) NOT NULL DEFAULT '',
    clicktv       INT(10)               DEFAULT '0',
    player        VARCHAR(10)           DEFAULT 'real',
    date          INT(10)      NOT NULL DEFAULT '0',
    tvdescription TEXT         NOT NULL,
    player_id     MEDIUMINT(8) NOT NULL DEFAULT 1,
    PRIMARY KEY (hid),
    KEY idxtvstatus (status)
)
    ENGINE = ISAM;

#
# Contenu de la table `tv`
#

#INSERT INTO tv (hid, sitename, urlram, sitesurl, status, logo, clicktv, player, player_id, date, tvdescription) VALUES (1,'LCI','http://infos.tf1.fr/statique/medias/lci.ram','http://www.lci.fr',1,'images/lc1.gif',170,'real',1,1016395698,'');
INSERT INTO tv (hid, sitename, urlram, sitesurl, status, logo, clicktv, player, player_id, date, tvdescription)
VALUES (2, 'i Television', 'http://www.itelevision.fr/regarder/itv.ram', 'http://www.itelevision.fr', 1, 'http://www.itelevision.fr/img/logo_i.gif', 134, 'real', 1, 1016395699, '');
INSERT INTO tv (hid, sitename, urlram, sitesurl, status, logo, clicktv, player, player_id, date, tvdescription)
VALUES (3, 'France 2 - 20h', 'http://www.francetv.fr/infos/videosjt/popupjt/video/20h/jt20h.ram', 'http://www.francetv.fr', 1, 'http://www.francetv.fr/infos/videosjt/popupjt/images/f2.gif', 131, 'real', 1, 1016395702, '');
INSERT INTO tv (hid, sitename, urlram, sitesurl, status, logo, clicktv, player, player_id, date, tvdescription)
VALUES (4, 'France 3 - 19/20', 'http://www.francetv.fr/regions/lienram/1920.ram', 'http://www.francetv.fr/regions', 1, 'http://www.francetv.fr/infos/videosjt/popupjt/images/f3.gif', 66, 'real', 1, 1016395703, '');
INSERT INTO tv (hid, sitename, urlram, sitesurl, status, logo, clicktv, player, player_id, date, tvdescription)
VALUES (5, 'France 2 - 13h', 'http://www.francetv.fr/infos/videosjt/popupjt/video/13h/jt13h.ram', 'http://www.francetv.fr', 1, 'http://www.francetv.fr/infos/videosjt/popupjt/images/f2.gif', 87, 'real', 1, 1016395717, '');
INSERT INTO tv (hid, sitename, urlram, sitesurl, status, logo, clicktv, player, player_id, date, tvdescription)
VALUES (6, '&#20013;&#22830;&#24291;&#25773;&#38651;&#33274;&#', 'http://www.cbs.org.tw/realaudio/cbs1.ram', 'http://www.cbs.org.tw', 1, 'http://www.cbs.org.tw/big5/images/cbs_logonew.gif', 132, 'real', 1, 1016395718, '');
INSERT INTO tv (hid, sitename, urlram, sitesurl, status, logo, clicktv, player, player_id, date, tvdescription)
VALUES (7, 'MSNBC', 'http://www.msnbc.com/m/mw/s/msnbc/asx.asp', 'http://www.msnbc.com', 1, 'images/msnbc.gif', 169, 'wm', 2, 1016395719, '');
INSERT INTO tv (hid, sitename, urlram, sitesurl, status, logo, clicktv, player, player_id, date, tvdescription)
VALUES (8, 'Eurosport FR audio (test)', 'rtsp://realserver.tf1.ext.imaginet.fr/eurosport/live/audio_24/live_fr.smi', 'http://www.eurosport.fr', 1, 'http://www.eurosport.fr/img/top/logo_eurosport_3.gif', 95, 'real', 1, 1016395721, '');
INSERT INTO tv (hid, sitename, urlram, sitesurl, status, logo, clicktv, player, player_id, date, tvdescription)
VALUES (9, 'Fashion TV (Real)', 'http://www.ftv.fr/video/rpm/FTV_live/11.rpm', 'http://www.ftv.fr', 1, 'http://www.ftv.fr/images/logo.jpg', 110, 'real', 1, 1016395723, '');
INSERT INTO tv (hid, sitename, urlram, sitesurl, status, logo, clicktv, player, player_id, date, tvdescription)
VALUES (10, 'Fashion TV (WM)', 'http://www.ftv.com/video/wmp/tonline300k.asx', 'http://www.ftv.fr', 1, 'http://www.ftv.fr/images/logo.jpg', 86, 'wm', 2, 1016395724, '');
INSERT INTO tv (hid, sitename, urlram, sitesurl, status, logo, clicktv, player, player_id, date, tvdescription)
VALUES (11, 'Bratisla Boys+Annie Cordy', 'http://morninglive.m6.fr/videos/bratislaboys/videos/ram/cordy.rpm', 'http://www.morninglive.com', 1, 'http://morninglive.m6.fr/header/logo.jpg', 122, 'real', 1, 1020873291, '');
INSERT INTO tv (hid, sitename, urlram, sitesurl, status, logo, clicktv, player, date, tvdescription, player_id)
VALUES (12, 'Apple iPod', 'http://a772.g.akamai.net/5/772/51/95c61ae0a2c206/1a1a1aaa2198c627970773d80669d84574a8d80d3cb12453c02589f25382e353c32f94c32c9c0b6f/ipod_intro_240.mov', 'http://www.apple.com/fr/ipod/', 1,
        'http://a772.g.akamai.net/7/772/51/4e464ab58bcd79/www.apple.com/fr/ipod/images/index_top07112002.jpg', 55, 'qt', 1028054353, 'Presentation de l\'iPod d\'Apple', 3);
# --------------------------------------------------------

#
# Structure de la table `tv_players`
#

CREATE TABLE tv_players (
    player_id   MEDIUMINT(8) NOT NULL AUTO_INCREMENT,
    player      VARCHAR(10)  NOT NULL DEFAULT '',
    description VARCHAR(100) NOT NULL DEFAULT '',
    codePlayer  TEXT         NOT NULL,
    lien        VARCHAR(100) NOT NULL DEFAULT '',
    codeBoutons TEXT         NOT NULL,
    codePlay    TEXT         NOT NULL,
    codeStop    TEXT         NOT NULL,
    codePause   TEXT         NOT NULL,
    codeMute    TEXT         NOT NULL,
    PRIMARY KEY (player_id),
    UNIQUE KEY player (player)
)
    ENGINE = ISAM;

#
# Contenu de la table `tv_players`
#

INSERT INTO tv_players (player_id, player, description, codePlayer, lien, codeBoutons, codePlay, codeStop, codePause, codeMute)
VALUES (1, 'real', 'Real Video',
        '<object classid="clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA" height="$height" id="stream" name="stream" width="$width">\r\n <param name="_ExtentX" value="6350">\r\n <param name="_ExtentY" value="4763">\r\n <param name="AUTOSTART" value="-1">\r\n <param name="SHUFFLE" value="0">\r\n <param name="PREFETCH" value="0">\r\n <param name="NOLABELS" value="0">\r\n <param name="SRC" value="$urlram">\r\n <param name="CONTROLS" value="ImageWindow">\r\n <param name="CONSOLE" value="video1">\r\n <param name="LOOP" value="0">\r\n <param name="NUMLOOP" value="0">\r\n <param name="CENTER" value="0">\r\n <param name="MAINTAINASPECT" value="0">\r\n<embed src="$urlram" width="$width" height="$height" controls="ImageWindow" autostart="-1" console="cons" type="audio/x-pn-realaudio-plugin" designtimesp="3165" _extentx="6350" _extenty="4763" shuffle="0" prefetch="0" nolabels="0" loop="0" numloop="0" center="0" maintainaspect="0">\r\n</embed>\r\n</object>',
        'http://real.com',
        '<object id=Object1 name=realPlayer classid=clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA width=26 height=26 VIEWASTEXT>"\r\n<param name="SRC" value="$urlram">"\r\n<param name="CONTROLS" value="PlayOnlyButton">"\r\n<param name="CONSOLE" value="video1">"\r\n<embed name="CONTROLS" width="26" height="26" controls="PlayOnlyButton"\r\n        console="video1" type="audio/X-pn-realaudio-plugin" >"\r\n</embed>\r\n</object>\r\n<object id=Object2 name=realPlayer classid=clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA width=26 height=26 VIEWASTEXT>"\r\n<param name="CONTROLS" value="StopButton">"\r\n<param name="CONSOLE" value="video1">"\r\n<embed name="CONTROLS" width="26" height="26" controls="StopButton"\r\n   console="video1" type="audio/X-pn-realaudio-plugin" >"\r\n</embed>\r\n</object>\r\n<object id=Object3 name=realPlayer classid=clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA width=114 height=26 VIEWASTEXT>"\r\n<param name="CONTROLS" value="PositionField">"\r\n<param name="CONSOLE" value="video1">"\r\n<embed name="CONTROLS" width="114" height="26" controls="PositionField"\r\n   console="video1" type="audio/X-pn-realaudio-plugin" >"\r\n</embed>\r\n</object>\r\n<object id=Object4 name=realPlayer classid=clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA width=26 height=26 VIEWASTEXT>"\r\n<param name="CONTROLS" value="MuteCtrl">"\r\n<param name="CONSOLE" value="video1">"\r\n<embed name="CONTROLS" width="26" height="26" controls="MuteCtrl"\r\n   console="video1" type="audio/X-pn-realaudio-plugin" >"\r\n</embed>\r\n</object>',
        '<a href="#####" onclick="document.stream.DoPlay();"><img name="btnPlay"src="images/play.gif" border=0 /></a>', '<a href="#####" onclick="document.stream.DoStop();"><img name="btnStop"src="images/stop.gif" border=0 /></a>',
        '<a href="#####" onclick="document.stream.DoPause();"><img name="btnPause"src="images/pause.gif" border=0 /></a>',
        '<object id=Object4 name=realPlayer classid=clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA width=26 height=26 VIEWASTEXT>"\r\n<param name="CONTROLS" value="MuteCtrl">"\r\n<param name="CONSOLE" value="video1">"\r\n<embed name="CONTROLS" width="26" height="26" controls="MuteCtrl"\r\n   console="video1" type="audio/X-pn-realaudio-plugin" >"\r\n</embed>\r\n</object>');
INSERT INTO tv_players (player_id, player, description, codePlayer, lien, codeBoutons, codePlay, codeStop, codePause, codeMute)
VALUES (2, 'wm', 'Windows Media',
        '<OBJECT ID="MediaPlayer1" classid="CLSID:22d6f312-b0f6-11d0-94ab-0080c74c7e95" CODEBASE="http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=5,1,52,701" height="$height" width="$width" standby="Loading Microsoft Windows Media Player components..." type="application/x-oleobject">\r\n <PARAM NAME="FileName" VALUE="$urlram">\r\n <PARAM NAME="TransparentAtStart" Value="true">\r\n <PARAM NAME="AutoStart" Value="true">\r\n <PARAM NAME="AnimationatStart" Value="true">\r\n <PARAM NAME="ShowControls" Value="false">\r\n <PARAM NAME="autoSize"                  Value="false">\r\n <PARAM NAME="displaySize"          Value="0">\r\n<EMBED type="application/x-mplayer2" pluginspage="http://www.microsoft.com/Windows/MediaPlayer/" src="$urlram" Name=MediaPlayer1 AutoStart=-1 Width=$width Height=$height transparentAtStart=0 animationAtStart=-1 ShowControls=0 autoSize=0 displaySize=0>\r\n</EMBED>\r\n</OBJECT>',
        'http://windowsmedia.microsoft.com',
        '<a href="#####" onclick="document.MediaPlayer1.Play();" ><img name="btnPlay" src="images/play.gif" border=0 /></a>\r\n<a href="#####" onclick="document.MediaPlayer1.Stop();"><img name="btnStop" src="images/stop.gif" border=0 /></a>\r\n<a href="#####" onclick="document.MediaPlayer1.Pause();"><img name="btnPause"src="images/pause.gif" border=0 /></a>\r\n<a href="#####" onclick="muteClick()"><img name="btnMute" src="images/volume.gif" border=0 /></a>',
        '<a href="#####" onclick="document.MediaPlayer1.Play();" ><img name="btnPlay" src="images/play.gif" border=0 /></a>', '<a href="#####" onclick="document.MediaPlayer1.Stop();"><img name="btnStop" src="images/stop.gif" border=0 /></a>',
        '<a href="#####" onclick="document.MediaPlayer1.Pause();"><img name="btnPause"src="images/pause.gif" border=0 /></a>', '<a href="#####" onclick="muteClick()"><img name="btnMute" src="images/volume.gif" border=0 /></a>');
INSERT INTO tv_players (player_id, player, description, codePlayer, lien, codeBoutons, codePlay, codeStop, codePause, codeMute)
VALUES (3, 'qt', 'QuickTime',
        '<OBJECT ID="MediaPlayer1" CLASSID="clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B" WIDTH=$width HEIGHT=$height CODEBASE="http://www.apple.com/qtactivex/qtplugin.cab">\r\n <PARAM NAME="SRC" VALUE="$urlram">\r\n <PARAM NAME="AUTOPLAY" VALUE="true">\r\n <PARAM NAME="CONTROLLER" VALUE="True">\r\n <PARAM NAME="ENABLEJAVASCRIPT" VALUE="True">\r\n <PARAM NAME="SAVEEMBEDTAGS" VALUE="True">\r\n <PARAM NAME="SCALE" VALUE="ToFit">\r\n <EMBED NAME="MediaPlayer1" WIDTH=$width TARGET=MYSELF SRC="$urlram" HEIGHT=$height PLUGINSPAGE="http://www.apple.com/quicktime/download/index.html" SAVEEMBEDTAGS="True" AUTOPLAY="True" CONTROLLER="True" ENABLEJAVASCRIPT="True" CACHE="true" SCALE="ToFit">\r\n </EMBED>\r\n</OBJECT>',
        'http://www.apple.com/quicktime/download/index.html', '', '', '', '', '');
# --------------------------------------------------------

#
# Structure de la table `tv_userspref`
#

CREATE TABLE tv_userspref (
    uid    INT(5)     NOT NULL DEFAULT '0',
    type   VARCHAR(8) NOT NULL DEFAULT '',
    valeur TEXT       NOT NULL,
    UNIQUE KEY uid (uid, type)
)
    ENGINE = ISAM;
