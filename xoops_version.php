<?php

$modversion['name']        = _MI_TV_NOM;
$modversion['version']     = 1.95;
$modversion['description'] = _MI_TV_DESC;
$modversion['credits']     = "docs/credits.txt";
$modversion['author']      = "kyex";
$modversion['help']        = "tv.html";
$modversion['license']     = "docs/licence.txt";
$modversion['official']    = "no";
$modversion['image']       = "images/tv_logo.jpg";
$modversion['dirname']     = "tv";

// Admin things
$modversion['hasAdmin']   = 1;
$modversion['adminindex'] = "admin/index.php";
$modversion['adminmenu']  = "admin/menu.php";

// Menu
$modversion['hasMain']        = 1;
$modversion['sub'][1]['name'] = _MI_TV_PREFS;
$modversion['sub'][1]['url']  = "tvpref.php";

// Blocks
$modversion['blocks'][1]['file']        = "tv_topclic.php";
$modversion['blocks'][1]['name']        = _MI_TV_NOM_BLOC;
$modversion['blocks'][1]['description'] = _MI_TV_DESC_BLOC;
$modversion['blocks'][1]['show_func']   = "b_tv_topclic_show";
$modversion['blocks'][1]['edit_func']   = "b_tv_topclic_edit";
$modversion['blocks'][1]['options']     = "clicktv|10";
$modversion['blocks'][2]['file']        = "tv_topclic.php";
$modversion['blocks'][2]['name']        = _MI_TV_NOM_BLOC2;
$modversion['blocks'][2]['description'] = _MI_TV_DESC_BLOC2;
$modversion['blocks'][2]['show_func']   = "b_tv_topclic_show";
$modversion['blocks'][2]['edit_func']   = "b_tv_topclic_edit";
$modversion['blocks'][2]['options']     = "date|10";

//SQL
$modversion['sqlfile']['mysql'] = "sql/mysql.sql";
$modversion['tables'][0]        = "tv";
$modversion['tables'][1]        = "tv_userspref";
$modversion['tables'][2]        = "tv_players";
?>

