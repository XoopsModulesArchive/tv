<?php

require_once XOOPS_ROOT_PATH . '/class/module.textsanitizer.php';
require_once XOOPS_ROOT_PATH . '/class/module.errorhandler.php';
require_once XOOPS_ROOT_PATH . '/class/xoopstree.php';
require_once XOOPS_ROOT_PATH . '/kernel/object.php';

class TV
{
    public $hid;

    public $sitename;

    public $urlram;

    public $sitesurl;

    public $status;

    public $logo;

    public $description;

    public $clicktv;

    public $player;

    public $player_id;

    public $skin;

    public function TV($id = -1)
    {
        global $xoopsDB;

        $this->db = $xoopsDB;

        if (is_array($id)) {
            $this->makeTV($id);
        } elseif (-1 != $id) {
            $this->getTV($id);
        }
    }

    public function setHid($value)
    {
        $this->hid = $value;
    }

    public function setSitename($value)
    {
        $this->sitename = $value;
    }

    public function setUrlram($value)
    {
        $this->urlram = $value;
    }

    public function setSitesurl($value)
    {
        $this->sitesurl = $value;
    }

    public function setStatus($value)
    {
        $this->status = $value;
    }

    public function setLogo($value)
    {
        $this->logo = $value;
    }

    public function setTvdescription($value)
    {
        $this->tvdescription = $value;
    }

    public function setClicktv($value)
    {
        $this->clicktv = $value;
    }

    public function setPlayer($value)
    {
        $this->player = $value;
    }

    public function setPlayer_id($value)
    {
        $this->player_id = $value;
    }

    public function hid()
    {
        return $this->hidid;
    }

    public function sitename()
    {
        return $this->sitename;
    }

    public function urlram()
    {
        return $this->urlram;
    }

    public function sitesurl()
    {
        return $this->sitesurl;
    }

    public function status()
    {
        return $this->status;
    }

    public function logo()
    {
        return $this->logo;
    }

    public function tvdescription()
    {
        return $this->tvdescription;
    }

    public function clicktv()
    {
        return $this->clicktv;
    }

    public function player()
    {
        return $this->player;
    }

    public function player_id()
    {
        return $this->player_id;
    }

    public function addclicktv()
    {
        $this->clicktv++;

        $sql = 'UPDATE ' . $this->db->prefix('tv') . " SET clicktv='" . $this->clicktv . "' WHERE hid=" . $this->hid . '';

        $this->db->queryF($sql);
    }

    public function update()
    {
        $sql = 'UPDATE '
               . $this->db->prefix('tv')
               . " SET sitename='"
               . $this->sitename
               . "', urlram='"
               . $this->urlram
               . "', sitesurl='"
               . $this->sitesurl
               . "', status='"
               . $this->status
               . "',logo='"
               . $this->logo
               . "',tvdescription='"
               . $this->tvdescription
               . "', player='"
               . $this->player
               . "',player_id="
               . $this->player_id
               . ", clicktv='"
               . $this->clicktv
               . "' WHERE hid="
               . $this->hid
               . '';

        $this->db->queryF($sql);
    }

    public function getTV($hid)
    {
        $sql = 'SELECT * FROM ' . $this->db->prefix('tv') . ' WHERE hid=' . $hid . '';

        $array = $this->db->fetchArray($this->db->query($sql));

        $this->makeTV($array);
    }

    public function makeTV($array)
    {
        foreach ($array as $key => $value) {
            $this->$key = $value;
        }
    }

    public function getAllTVs($limit = 0, $asobject = true)
    {
        global $xoopsDB;

        $db = &$xoopsDB;

        $myts = new MyTextSanitizer();

        $ret = [];

        $sql = 'SELECT * FROM ' . $db->prefix('tv') . ' where status>0 ';

        $result = $db->query($sql, $limit, 0);

        while (false !== ($myrow = $db->fetchArray($result))) {
            if ($asobject) {
                $ret[] = new self($myrow);
            } else {
                $ret[$myrow['hid']] = htmlspecialchars($myrow['sitename']);
            }
        }

        return $ret;
    }
}

class TVUserPref
{           // config peso d'un user (a terme...)
    public $uid;

    public $option;

    public $db;

    public function TVUserPref($id = -1)
    {
        global $xoopsDB;

        $this->db = $xoopsDB;

        $this->option = [];

        $this->db->setDebug(false);

        if (-1 != $id) {
            $this->getTVUserPref($id);
        }
    }

    public function getOption($type)
    {
        if (isset($this->option[$type])) {
            return ($this->option[$type]);
        }
  

        return false;
    }

    public function setId($value)
    {
        $this->id = $value;
    }

    public function setOption($type, $valeur)
    {
        $this->option[$type] = $valeur;
    }

    public function save()
    {
        foreach ($this->option as $type => $valeur) {
            //            echo $this->uid.":save pour $type avec $valeur.<br>";

            if ('' == $valeur) {
                $this->db->queryF('DELETE FROM ' . $this->db->prefix('tv_userspref') . ' WHERE uid=' . $this->uid . " AND type='$type'");
            } else {
                $this->db->queryF('INSERT INTO ' . $this->db->prefix('tv_userspref') . ' VALUES (' . $this->uid . ",'$type','$valeur')");

                $this->db->queryF('UPDATE ' . $this->db->prefix('tv_userspref') . " SET valeur='$valeur' WHERE uid=" . $this->uid . " and type='$type'");
            }
        }
    }

    public function getTVUserPref($uid)
    {
        $sql = 'SELECT * FROM ' . $this->db->prefix('tv_userspref') . ' WHERE uid=' . $uid . '';

        $result = $this->db->query($sql);

        $this->uid = $uid;

        while (false !== ($myrow = $this->db->fetchArray($result))) {
            //            $this->uid = $myrow['uid'];

            $this->option[$myrow['type']] = $myrow['valeur'];

            //             echo $myrow['uid'].":option[".$myrow['type']."] = ".$myrow['valeur']."<br>";
        }
    }
}

class TVPlayer extends XoopsObject
{
    // constructor

    public function TVPlayer($player = null)
    {
        $this->XoopsObject();

        $this->initVar('player_id', 'int', null, false);

        $this->initVar('player', 'textbox', null, true, 10, false);

        $this->initVar('description', 'textbox', null, true, 100, true);

        $this->initVar('codePlayer', 'textarea', null, true, null, false);

        $this->initVar('lien', 'textbox', null, true, 100, true);

        $this->initVar('codeBoutons', 'textarea', null, false, null, false);

        $this->initVar('codePlay', 'textarea', null, false, null, false);

        $this->initVar('codeStop', 'textarea', null, false, null, false);

        $this->initVar('codePause', 'textarea', null, false, null, false);

        $this->initVar('codeMute', 'textarea', null, false, null, false);

        $this->vars['codePlayer']['nohtml'] = $this->vars['codePlayer']['nosmiley'] = $this->vars['codePlayer']['noxcode'] = true;

        if (!empty($player)) {
            if (is_array($player)) {
                $this->set($player);
            } else {
                $this->load($player);
            }
        }
    }

    // private

    public function load($player_id)
    {
        $sql = 'SELECT * FROM ' . $this->db->prefix('tv_players') . " WHERE player_id=$player_id";

        $array = $this->db->fetchArray($this->db->query($sql));

        $this->set($array);
    }

    // public

    public function delete()
    {
        $sql = 'DELETE FROM ' . $this->db->prefix('tv_players') . ' WHERE player_id=' . $this->getVar('player_id') . '';

        if (!$this->db->query($sql)) {
            return false;
        }

        return true;
    }

    // public

    public function store()
    {
        if (!$this->isCleaned()) {
            if (!$this->cleanVars()) {
                return false;
            }
        }

        foreach ($this->cleanVars as $k => $v) {
            $$k = $v;
        }

        if (empty($player_id)) {
            $player_id = $this->db->genId($this->db->prefix('tv_players') . '_player_seq');

            $sql = 'INSERT INTO '
                         . $this->db->prefix('tv_players')
                         . " (player,  description, codePlayer, lien, codeBoutons, codePlay, codeStop, codePause, codeMute) VALUES ('$player', '$description', '$codePlayer', '$lien', '$codeBoutons', '$codePlay', '$codeStop', '$codePause', '$codeMute')";
        } else {
            $sql = 'UPDATE '
                   . $this->db->prefix('tv_players')
                   . " SET player='$player', description='$description', codePlayer='$codePlayer', lien='$lien', codeBoutons='$codeBoutons', codePlay='$codePlay', codeStop='$codeStop', codePause='$codePause', codeMute='$codeMute' WHERE player_id='$player_id'";
        }

        if (!$result = $this->db->query($sql)) {
            $this->setErrors('Could not store data in the database.');

            return false;
        }

        if (empty($player)) {
            return $this->db->getInsertId();
        }

        return $player;
    }

    public function getAll($limit = 0, $asobject = true)
    {
        global $xoopsDB;

        $db = &$xoopsDB;

        $myts = new MyTextSanitizer();

        $ret = [];

        $sql = 'SELECT * FROM ' . $db->prefix('tv_players');

        $result = $db->query($sql, $limit, 0);

        while (false !== ($myrow = $db->fetchArray($result))) {
            if ($asobject) {
                $ret[] = new self($myrow);
            } else {
                $ret[$myrow['player_id']] = htmlspecialchars($myrow['description']);
            }
        }

        return $ret;
    }
}
