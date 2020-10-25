// Browser sniff -- the following code does a very simple browser check and rates the
//     browser as either Internet Explorer on a Win32 platform or not, so that we
//     know to use the ActiveX model, or the plug-in Model.
var sBrowser = navigator.userAgent;
if ((sBrowser.indexOf("IE") > -1) && (navigator.platform == "Win32"))
{
	sBrowser = "IE";
} else {
	sBrowser = "nonIE";
}
// end browser sniff


btnMute_on = new Image();
btnMute_on.src = "images/volume.gif";
btnMute_off = new Image();
btnMute_off.src = "images/volumex.gif";

function img_off(imgName) {
    if (1 == 1) {
        imgOver = eval(imgName + "_off.src");
        document [imgName].src = imgOver;
    }
}

function img_on(imgName) {
    if (1 == 1) {
        imgOut = eval(imgName + "_on.src");
        document [imgName].src = imgOut;
    }
}

function showClick() // This function is called by the btnShowControls button.
                     // It sets the ShowControls property of Media Player to true.
{
	if (sBrowser == "IE") {
		document.MediaPlayer1.ShowControls = true;
	} else {
		document.MediaPlayer1.SetShowControls(true);
	}
}

function hideClick() // This function is called by the btnHideControls button.
                     // It sets the ShowControls property of Media Player to false.
{
	if (sBrowser == "IE") {
		document.MediaPlayer1.ShowControls = false;
	} else {
		document.MediaPlayer1.SetShowControls(false);
	}
}


function muteClick() // This function is called by the "Mute" button.
                     // It toggles the state of the Mute property of the Media Player.
{
	var bMuteState;
	if (sBrowser == "IE") {
		bMuteState = document.MediaPlayer1.Mute;
	} else {
		bMuteState = document.MediaPlayer1.GetMute();
	}

	if (bMuteState == true) {
		if (sBrowser == "IE") {
			document.MediaPlayer1.Mute = false;
		} else {
			document.MediaPlayer1.SetMute(false);
		}
        img_on('btnMute');
	} else {
		if (sBrowser == "IE") {
			document.MediaPlayer1.Mute = true;
		} else {
			document.MediaPlayer1.SetMute(true);
		}
        img_off('btnMute');
	}
}

