<?php
chdir('../../..');
require_once('includes/config.inc.php');
$dir = "{$APP_CONFIG['public_dir']}/resources/script/iui";

header('Content-type: text/css');
?>

/* iui.css (c) 2007 by iUI Project Members, see LICENSE.txt for license */
body {
    margin: 0;
    font-family: Helvetica;
    background: #FFFFFF;
    color: #000000;
    overflow-x: hidden;
    -webkit-user-select: none;
    -webkit-text-size-adjust: none;
}

body > *:not(.toolbar) {
    display: none;
    position: absolute;
    margin: 0;
    padding: 0;
    left: 0;
    top: 45px;
    width: 100%;
    min-height: 372px;
}

body[orient="landscape"] > *:not(.toolbar) {
    min-height: 268px;
}

body > *[selected="true"] {
    display: block;
}

a[selected], a:active {
    background-color: #194fdb !important;
    background-image: url(<?php echo $dir; ?>/listArrowSel.png), url(<?php $dir; ?>/selection.png) !important;
    background-repeat: no-repeat, repeat-x;
    background-position: right center, left top;
    color: #FFFFFF !important;
}

a[selected="progress"] {
    background-image: url(<?php echo $dir; ?>/loading.gif), url(<?php echo $dir;?>/selection.png) !important;
}

/************************************************************************************************/

body > .toolbar {
    box-sizing: border-box;
    -moz-box-sizing: border-box;
    -webkit-box-sizing: border-box;
    border-bottom: 1px solid #2d3642;
    border-top: 1px solid #6d84a2;
    padding: 10px;
    height: 45px;
    background: url(<?php echo $dir; ?>/toolbar.png) #6d84a2 repeat-x;
}

.toolbar > h1 {
    position: absolute;
    overflow: hidden;
    left: 50%;
    margin: 1px 0 0 -75px;
    height: 45px;
    font-size: 20px;
    width: 150px;
    font-weight: bold;
    text-shadow: rgba(0, 0, 0, 0.4) 0px -1px 0;
    text-align: center;
    text-overflow: ellipsis;
    white-space: nowrap;
    color: #FFFFFF;
}

body[orient="landscape"] > .toolbar > h1 {
    margin-left: -125px;
    width: 250px;
}

.button {
    position: absolute;
    overflow: hidden;
    top: 8px;
    right: 6px;
    margin: 0;
    border-width: 0 5px;
    padding: 0 3px;
    width: auto;
    height: 30px;
    line-height: 30px;
    font-family: inherit;
    font-size: 12px;
    font-weight: bold;
    color: #FFFFFF;
    text-shadow: rgba(0, 0, 0, 0.6) 0px -1px 0;
    text-overflow: ellipsis;
    text-decoration: none;
    white-space: nowrap;
    background: none;
    -webkit-border-image: url(<?php echo $dir; ?>/toolButton.png) 0 5 0 5;
}

.blueButton {
    -webkit-border-image: url(blueButton.png) 0 5 0 5;
    border-width: 0 5px;
}

.leftButton {
    left: 6px;
    right: auto;
}

#backButton {
    display: none;
    left: 6px;
    right: auto;
    padding: 0;
    max-width: 55px;
    border-width: 0 8px 0 14px;
    -webkit-border-image: url(<?php echo $dir; ?>/backButton.png) 0 8 0 14;
}

.whiteButton,
.grayButton {
    display: block;
    border-width: 0 12px;
    padding: 10px;
    text-align: center;
    font-size: 20px;
    font-weight: bold;
    text-decoration: inherit;
    color: inherit;
}

.whiteButton {
    -webkit-border-image: url(<?php echo $dir; ?>/whiteButton.png) 0 12 0 12;
    text-shadow: rgba(255, 255, 255, 0.7) 0 1px 0;
}

.grayButton {
    -webkit-border-image: url(<?php echo $dir; ?>/grayButton.png) 0 12 0 12;
    color: #FFFFFF;
}

/************************************************************************************************/

body > ul > li {
    position: relative;
    margin: 0;
    border-bottom: 1px solid #E0E0E0;
    padding: 8px 0 8px 10px;
    font-size: 20px;
    font-weight: bold;
    list-style: none;
}

body > ul > li.group {
    position: relative;
    top: -1px;
    margin-bottom: -2px;
    border-top: 1px solid #7d7d7d;
    border-bottom: 1px solid #999999;
    padding: 1px 10px;
    background: url(<?php echo $dir; ?>/listGroup.png) repeat-x;
    font-size: 17px;
    font-weight: bold;
    text-shadow: rgba(0, 0, 0, 0.4) 0 1px 0;
    color: #FFFFFF;
}

body > ul > li.group:first-child {
    top: 0;
    border-top: none;
}

body > ul > li > a {
    display: block;
    margin: -8px 0 -8px -10px;
    padding: 8px 32px 8px 10px;
    text-decoration: none;
    color: inherit;
    background: url(<?php echo $dir; ?>/listArrow.png) no-repeat right center;
}

a[target="_replace"] {
    box-sizing: border-box;
    -webkit-box-sizing: border-box;
    padding-top: 25px;
    padding-bottom: 25px;
    font-size: 18px;
    color: cornflowerblue;
    background-color: #FFFFFF;
    background-image: none;
}

/************************************************************************************************/
    
body > .dialog {
    top: 0;
    width: 100%;
    min-height: 417px;
    z-index: 2;
    background: rgba(0, 0, 0, 0.8);
    padding: 0;
    text-align: right;
}

.dialog > fieldset {
    box-sizing: border-box;
    -webkit-box-sizing: border-box;
    width: 100%;
    margin: 0;
    border: none;
    border-top: 1px solid #6d84a2;
    padding: 10px 6px;
    background: url(<?php echo $dir; ?>/toolbar.png) #7388a5 repeat-x;
}

.dialog > fieldset > h1 {
    margin: 0 10px 0 10px;
    padding: 0;
    font-size: 20px;
    font-weight: bold;
    color: #FFFFFF;
    text-shadow: rgba(0, 0, 0, 0.4) 0px -1px 0;
    text-align: center;
}

.dialog > fieldset > label {
    position: absolute;
    margin: 16px 0 0 6px;
    font-size: 14px;
    color: #999999;
}

input {
    box-sizing: border-box;
    -webkit-box-sizing: border-box;
    width: 100%;
    margin: 8px 0 0 0;
    padding: 6px 6px 6px 44px;
    font-size: 16px;
    font-weight: normal;
}

/************************************************************************************************/

body > .panel {
    box-sizing: border-box;
    -webkit-box-sizing: border-box;
    padding: 10px;
    background: #c8c8c8 url(<?php echo $dir; ?>/pinstripes.png);
}

.panel > fieldset {
    position: relative;
    margin: 0 0 20px 0;
    padding: 0;
    background: #FFFFFF;
    -webkit-border-radius: 10px;
    border: 1px solid #999999;
    text-align: right;
    font-size: 16px;
}

.row  {
    position: relative;
    min-height: 42px;
    border-bottom: 1px solid #999999;
    -webkit-border-radius: 0;
    text-align: right;
}

fieldset > .row:last-child {
    border-bottom: none !important;
}

.row > input {
    box-sizing: border-box;
    -webkit-box-sizing: border-box;
    margin: 0;
    border: none;
    padding: 12px 10px 0 110px;
    height: 42px;
    background: none;
}

.row > span {
    position: absolute;
    padding: 12px 10px 0 110px;
    margin: 0;
}

.row > label {
    position: absolute;
    margin: 0 0 0 14px;
    line-height: 42px;
    font-weight: bold;
}

.row > .toggle {
    position: absolute;
    top: 6px;
    right: 6px;
    width: 100px;
    height: 28px;
}

.toggle {
    border: 1px solid #888888;
    -webkit-border-radius: 6px;
    background: #FFFFFF url(<?php echo $dir; ?>/toggle.png) repeat-x;
    font-size: 19px;
    font-weight: bold;
    line-height: 30px;
}

.toggle[toggled="true"] {
    border: 1px solid #143fae;
    background: #194fdb url(<?php echo $dir; ?>/toggleOn.png) repeat-x;
}

.toggleOn {
    display: none;
    position: absolute;
    width: 60px;
    text-align: center;
    left: 0;
    top: 0;
    color: #FFFFFF;
    text-shadow: rgba(0, 0, 0, 0.4) 0px -1px 0;
}

.toggleOff {
    position: absolute;
    width: 60px;
    text-align: center;
    right: 0;
    top: 0;
    color: #666666;
}

.toggle[toggled="true"] > .toggleOn {
    display: block;
}

.toggle[toggled="true"] > .toggleOff {
    display: none;
}

.thumb {
    position: absolute;
    top: -1px;
    left: -1px;
    width: 40px;
    height: 28px;    
    border: 1px solid #888888;
    -webkit-border-radius: 6px;
    background: #ffffff url(<?php echo $dir; ?>/thumb.png) repeat-x;
}

.toggle[toggled="true"] > .thumb {
    left: auto;
    right: -1px;
}

.panel > h2 {
    margin: 0 0 8px 14px;
    font-size: inherit;
    font-weight: bold;
    color: #4d4d70;
    text-shadow: rgba(255, 255, 255, 0.75) 2px 2px 0;
}

/************************************************************************************************/

#preloader {
    display: none;
    background-image: url(<?php echo $dir; ?>/loading.gif), url(<?php echo $dir; ?>/selection.png),
        url(<?php echo $dir; ?>/blueButton.png), url(<?php echo $dir; ?>/listArrowSel.png), url(<?php echo $dir; ?>/listGroup.png);
}

/*********** Owl Custom ************/
.progress-border {
    height: 15px; 
    width: 135px;
    background: #fff;
    border: 1px solid gray;
    margin: 0;
    padding: 1px;
}

.progress-bar {
    height: 13px;
    margin-top: 1px;
    padding: 0;
    background-image: url(<?php echo $dir; ?>/toggleOn.png);
}
