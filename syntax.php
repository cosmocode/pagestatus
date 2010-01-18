<?php

if(!defined('DOKU_INC')) die();

if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(DOKU_PLUGIN.'syntax.php');
require_once(DOKU_INC.'inc/pageutils.php');

class syntax_plugin_pagestatus extends DokuWiki_Syntax_Plugin {

    var $inner = false;
    var $status = false;

    function getInfo(){
        return confToHash(dirname(__FILE__).'/plugin.info.txt');
    }

    function getType() { return 'container'; }
    function getPType() { return 'block'; }
    function getSort() { return 375; }
    function connectTo($mode) {
        $this->Lexer->addEntryPattern('<status .*?>',$mode,'plugin_pagestatus');
    }
    
    function postConnect() {
        $this->Lexer->addExitPattern('</status>','plugin_pagestatus');
    }

    function handle($match, $state, $pos, &$handler){
        switch ($state) {
        case DOKU_LEXER_ENTER : 
            $status = substr($match, 8, -1);
            $this->inner = true;
            $this->status = $status;
            return array('open', $status);

        case DOKU_LEXER_EXIT :
            $this->inner = false;
            return array('close');
        }
 
        return array($match, $state, $pos); 
    }

    function render($mode, &$renderer, $data) {
        if($mode == 'xhtml'){

            if ($data[0] == 'open') {
                $status = htmlspecialchars($data[1]);
                $renderer->doc .= '<div class="plugin__pagestatus '. strtolower($status) .'">Status: '.$status;
            } elseif ($data[0] == 'close') {
                $renderer->doc .= '</div>';
            } else {
                $out = $data[0];
                $renderer->doc .= nl2br(htmlspecialchars($out));
            }

            return true;
        }
        return false;
    }


}

?>
