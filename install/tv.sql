CREATE TABLE tv (
    hid           INT(11)      NOT NULL AUTO_INCREMENT,
    sitename      VARCHAR(50)  NOT NULL DEFAULT '',
    urlram        VARCHAR(100) NOT NULL DEFAULT '',
    sitesurl      VARCHAR(200) NOT NULL DEFAULT '',
    status        TINYINT(1)   NOT NULL DEFAULT '0',
    logo          VARCHAR(200) NOT NULL DEFAULT '',
    tvdescription TEXT         NOT NULL,
    clicktv       INT(10)               DEFAULT '0',
    player        VARCHAR(10)           DEFAULT 'real',
    date          INT(10)      NOT NULL DEFAULT '0',
    PRIMARY KEY (hid),
    KEY idxtvstatus (status)
)
    ENGINE = ISAM;


#
# Contenu de la table `tv`
#

INSERT INTO tv(hid, sitename, urlram, sitesurl, status, logo, tvdescription, clicktv, player, date)
VALUES (1, 'LCI', 'http://infos.tf1.fr/statique/medias/lci.ram', 'http://www.lci.fr', 1, 'images/lc1.gif', 'LCI', 0, 'real', 1016395698);
INSERT INTO tv (hid, sitename, urlram, sitesurl, status, logo, tvdescription, clicktv, player, date)
VALUES (2, 'i tv', 'http://www.itv.fr/regarder/itv.ram', 'http://www.itv.fr', 1, 'http://www.itv.fr/img/logo_i.gif', 'iTelevision', 0, 'real', 1016395699);
INSERT INTO tv (hid, sitename, urlram, sitesurl, status, logo, tvdescription, clicktv, player, date)
VALUES (3, 'CineInfo.fr', 'http://www.cineinfo.fr/live/cineinfo_live.rpm', 'http://www.cineinfo.fr', 1, 'http://www.cineinfo.fr/gif/menu_top/logo.gif', 'ineinfo', 0, 'real', 1016395700);
INSERT INTO tv (hid, sitename, urlram, sitesurl, status, logo, tvdescription, clicktv, player, date)
VALUES (4, 'Euronews', 'http://stream1.euronews.net:8080/ramgen/bulletin/bul-bulletin3-fr.rm?usehostname', 'http://www.euronews.net', 1, 'images/euronews.gif', 'EuroNews', 0, 'real', 1016395701);
INSERT INTO tv (hid, sitename, urlram, sitesurl, status, logo, tvdescription, clicktv, player, date)
VALUES (5, 'France 2 - 20h', 'http://www.francetv.fr/infos/videosjt/popupjt/video/20h/jt20h.ram', 'http://www.francetv.fr', 1, 'http://www.francetv.fr/infos/videosjt/popupjt/images/f2.gif', 'France 2', 0, 'real', 1016395702);
INSERT INTO tv (hid, sitename, urlram, sitesurl, status, logo, tvdescription, clicktv, player, date)
VALUES (6, 'France 3 - 19/20', 'http://www.francetv.fr/regions/lienram/1920.ram', 'http://www.francetv.fr/regions', 1, 'http://www.francetv.fr/infos/videosjt/popupjt/images/f3.gif', 'France 3', 0, 'real', 1016395703);
INSERT INTO tv (hid, sitename, urlram, sitesurl, status, logo, tvdescription, clicktv, player, date)
VALUES (22, 'MSNBC', 'http://www.msnbc.com/m/mw/s/msnbc/asx.asp', 'http://www.msnbc.com', 1, 'images/msnbc.gif', 'MSNBC', 0, 'wm', 1016395719);
INSERT INTO tv (hid, sitename, urlram, sitesurl, status, logo, tvdescription, clicktv, player, date)
VALUES (29, 'Bratisla Boys+Annie Cordy', 'http://morninglive.m6.fr/videos/bratislaboys/videos/ram/cordy.rpm', 'http://www.morninglive.com', 'Bratisla Boys', 0, 'http://morninglive.m6.fr/header/logo.jpg', 26, 'real', 1020873291);
# --------------------------------------------------------# --------------------------------------------------------


CREATE TABLE tv_userspref (
    uid    INT(5)     NOT NULL DEFAULT '0',
    type   VARCHAR(8) NOT NULL DEFAULT '',
    valeur TEXT       NOT NULL,
    UNIQUE KEY uid (uid, type)
)
    ENGINE = ISAM;


CREATE TABLE kxp__tv_players (
    player      VARCHAR(10)  NOT NULL DEFAULT '',
    description VARCHAR(100) NOT NULL DEFAULT '',
    codeHTML    TEXT         NOT NULL,
    lien        VARCHAR(100) NOT NULL DEFAULT '',
    codeBoutons TEXT         NOT NULL,
    PRIMARY KEY (player)
)
    ENGINE = ISAM;

#
# Contenu de la table `kxp__tv_players`
#

INSERT INTO kxp__tv_players (player, description, codeHTML, lien, codeBoutons)
VALUES ('real', 'Real Video',
        '<object classid="clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA" height="\\$height" id="stream" width="\\$width">\r\n <param name="_ExtentX" value="6350">\r\n <param name="_ExtentY" value="4763">\r\n <param name="AUTOSTART" value="-1">\r\n <param name="SHUFFLE" value="0">\r\n <param name="PREFETCH" value="0">\r\n <param name="NOLABELS" value="0">\r\n <param name="SRC" value="\\$urlram">\r\n <param name="CONTROLS" value="ImageWindow">\r\n <param name="CONSOLE" value="video1">\r\n <param name="LOOP" value="0">\r\n <param name="NUMLOOP" value="0">\r\n <param name="CENTER" value="0">\r\n <param name="MAINTAINASPECT" value="0">\r\n<embed src="\\$urlram" width="\\$width" height="\$height" controls="ImageWindow" autostart="-1" console="cons" type="audio/x-pn-realaudio-plugin" designtimesp="3165" _extentx="6350" _extenty="4763" shuffle="0" prefetch="0" nolabels="0" loop="0" numloop="0" center="0" maintainaspect="0">\r\n</embed>\r\n</object>',
        'http://real.com',
        '<object id=Object1 name=realPlayer classid=clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA width=26 height=26 VIEWASTEXT>"\r\n<param name="SRC" value="\$urlram">"\r\n<param name="CONTROLS" value="PlayOnlyButton">"\r\n<param name="CONSOLE" value="video1">"\r\n<embed name="CONTROLS" width="26" height="26" controls="PlayOnlyButton"\r\n	console="video1" type="audio/X-pn-realaudio-plugin" >"\r\n</embed>\r\n</object>\r\n<object id=Object2 name=realPlayer classid=clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA width=26 height=26 VIEWASTEXT>"\r\n<param name="CONTROLS" value="StopButton">"\r\n<param name="CONSOLE" value="video1">"\r\n<embed name="CONTROLS" width="26" height="26" controls="StopButton"\r\n   console="video1" type="audio/X-pn-realaudio-plugin" >"\r\n</embed>\r\n</object>\r\n<object id=Object3 name=realPlayer classid=clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA width=114 height=26 VIEWASTEXT>"\r\n<param name="CONTROLS" value="PositionField">"\r\n<param name="CONSOLE" value="video1">"\r\n<embed name="CONTROLS" width="114" height="26" controls="PositionField"\r\n   console="video1" type="audio/X-pn-realaudio-plugin" >"\r\n</embed>\r\n</object>\r\n<object id=Object4 name=realPlayer classid=clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA width=26 height=26 VIEWASTEXT>"\r\n<param name="CONTROLS" value="MuteCtrl">"\r\n<param name="CONSOLE" value="video1">"\r\n<embed name="CONTROLS" width="26" height="26" controls="MuteCtrl"\r\n   console="video1" type="audio/X-pn-realaudio-plugin" >"\r\n</embed>\r\n</object>');
INSERT INTO kxp__tv_players (player, description, codeHTML, lien, codeBoutons)
VALUES ('wm', 'Windows Media',
        '<OBJECT ID="MediaPlayer1" classid="CLSID:22d6f312-b0f6-11d0-94ab-0080c74c7e95" CODEBASE="http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=5,1,52,701" height="\$height" width="\$width" standby="Loading Microsoft Windows Media Player components..." type="application/x-oleobject">\r\n <PARAM NAME="FileName" VALUE="\$urlram">\r\n <PARAM NAME="TransparentAtStart" Value="true">\r\n <PARAM NAME="AutoStart" Value="true">\r\n <PARAM NAME="AnimationatStart" Value="true">\r\n <PARAM NAME="ShowControls" Value="false">\r\n <PARAM NAME="autoSize" 		 Value="false">\r\n <PARAM NAME="displaySize" 	 Value="0">\r\n<EMBED type="application/x-mplayer2" pluginspage="http://www.microsoft.com/Windows/MediaPlayer/" src="\$urlram" Name=MediaPlayer1 AutoStart=-1 Width=\$width Height=\$height transparentAtStart=0 autostart=-1 animationAtStart=-1 ShowControls=0 autoSize=0 displaySize=0>\r\n</EMBED>\r\n</OBJECT>',
        'http://windowsmedia.microsoft.com',
        '<a href="#####" onclick="document.MediaPlayer1.Play();" ><img name="btnPlay" src="images/play.gif" border=0 /></a>\r\n<a href="#####" onclick="document.MediaPlayer1.Stop();"><img name="btnStop" src="images/stop.gif" border=0 /></a>\r\n<a href="#####" onclick="document.MediaPlayer1.Pause();"><img name="btnPause"src="images/pause.gif" border=0 /></a>\r\n<a href="#####" onclick="muteClick()"><img name="btnMute" src="images/volume.gif" border=0 /></a>');
INSERT INTO kxp__tv_players (player, description, codeHTML, lien, codeBoutons)
VALUES ('qt', 'QuickTime',
        '<OBJECT CLASSID="clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B" WIDTH=\$width HEIGHT=\$height CODEBASE="http://www.apple.com/qtactivex/qtplugin.cab">\r\n <PARAM NAME="SRC" VALUE="\$urlram">\r\n <PARAM NAME="AUTOPLAY" VALUE="true">\r\n <PARAM NAME="CONTROLLER" VALUE="TRUE">\r\n <PARAM NAME="target" VALUE="myself">\r\n <EMBED WIDTH=\$width TARGET=MYSELF SRC="\$urlram" HEIGHT=\$height PLUGINSPAGE="http://www.apple.com/quicktime/download/index.html" CONTROLLER=TRUE CACHE="true">\r\n</OBJECT>";',
        'http://www.apple.com/quicktime/download/index.html', '');
