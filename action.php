<?php

if(!defined('DOKU_INC')) die();

if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(DOKU_PLUGIN.'action.php');
require_once(DOKU_INC.'inc/pageutils.php');
require_once(DOKU_INC.'inc/form.php');
require_once(DOKU_INC.'inc/io.php');

class action_plugin_pagestatus extends DokuWiki_Action_Plugin {

    function getInfo(){
        return confToHash(dirname(__FILE__).'/info.txt');
    }

    function register($controller) {
        $controller->register_hook('TOOLBAR_DEFINE', 'AFTER', $this, 'addToolbar', array ());
        $controller->register_hook('TPL_METAHEADER_OUTPUT', 'AFTER', $this, 'addUser', array());
    }

    function addUser(&$event, $param) {
        echo '<script type="text/javascript" charset="utf-8" ><!--//--><![CDATA[//><!--
        USER="'.(empty($_SERVER['REMOTE_USER'])?$_SERVER['REMOTE_ADDR']:$_SERVER['REMOTE_USER']).'";
        //--><!]]></script>';

    }

    function addToolbar(&$event, $param) {
        $stats = $this->getConf('status');
        $stats = explode(',',$stats);
        $event->data[] = array(
            'type' => 'textlist',
            'title' => $this->getLang('toolbartitle'),
            'icon' => '../../plugins/pagestatus/status.png',
            'status' => $stats
        );
        return false;
    }

}

?>
