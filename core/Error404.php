<?php

/**
 * class view
 * 
 * use to call views
 */

class Error404 extends Page {

    public function render($params = array()) {
        
        extract($params);
        
        ob_start();
        include(VIEWS.'partials/_script.php');
        $scripts = ob_get_clean();        

        ob_start();
        include(VIEWS.'partials/_head.php');
        $head = ob_get_clean();

        include_once(VIEWS.'templates/404.php');
    }

    
    public function redirect($route) {
        header("Location: ".HOST.$route);
        exit;
    }

}