<?php 

namespace Views;

use Framework\Config;
use Framework\View;

/**
 * Views related to the home page and it's functionality
 */
class HomeView extends View
{
    public function __construct(){
        parent::__construct();
    }
    
    
        
    
    public function homePage(Config $config)
    {
        $template = $this->loadTemplate($config, 'homepage');
        $this->display($config, $template, ['text'=>'HelloWorld'], ['bootstrap.bundle.min.js', 'jquery.min.js'], ['bootstrap.min.css']);
    }
}