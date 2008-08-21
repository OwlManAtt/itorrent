<?xml version="1.0"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
    <head>
        <title>{if $page_title eq ''}{$site_name} | Welcome{else}{$site_name} | {$page_title}{/if}</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <style type="text/css" media="screen">
            @import url( {$display_settings.public_dir}/resources/styles/style-psp.css );
        </style>

        <script type='text/javascript' src='{$display_settings.public_dir}/resources/script/fat.js'></script>
    </head>
    <body>
        <div id='header'>
            <span id='page_name'><h1>{$page_html_title}</h1></span>
            <h1><a id='site_name' href='{$display_settings.public_dir}'>{$site_name}</a></h1>
        </div>

        <div id='main-box'>
            <div id='left-column'>
                <ul id='navigation-bar' class='flat-list'>
                    <li>{kkkurl link_text='Torrents' slug='torrents'}</li>
                    <li>{kkkurl link_text='RSS Feeds' slug='rss-feeds'}</li>
                    <li>{kkkurl link_text='Client Settings' slug='client-settings'}</li>
                {if $logged_in == true}
                {include file="psp/layout/user_box.tpl"}
                {/if}
                </ul>
            </div>

            <div id='right-column'>
                <!-- Page beging here. -->

