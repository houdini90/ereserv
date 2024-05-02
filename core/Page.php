<?php

/**
 * class Page
 * 
 * use to call Pages
 */

abstract class Page {

    protected $pageContent;

    abstract public function render($params = array());

    abstract public function redirect($route);

}