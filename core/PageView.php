<?php

/**
 * class PageView
 * use to call views, for simple page that doesn't use CRUD
 */

class PageView extends View {
    
    public function render($params = array()) {

        $elements = parent::render($params);
        extract($elements);
        extract($params);

        include_once(VIEWS.'templates/layout.php');

    }

}