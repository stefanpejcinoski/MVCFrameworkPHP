<?php

namespace Framework\Classes;

use Framework\Interfaces\TemplateRendering;
use Framework\Traits\TemplateHelpers;
use Smarty;

/**
 * Defines properties and methods necessary for rendering template views
 */

 class View 
{

    use TemplateHelpers;

    protected static View $instance;
    public function __construct()
    {
        $this->engine = Config::getConfig('app')->getKey('template_engine');
    }

    public static function create() {
        if(!isset(self::$instance)){
            self::$instance = new View();
        }
        return self::$instance;
    }
    /**
     * Display the provided template file with the given scripts, stylesheets and parameters
     * 
     * @param string $template required
     * @param array $parameters optional
     * @param array $scripts optional
     * @param array $styles optional
     */
    public function display(string $template, array $parameters = null, array $scripts = null, array $styles = null) 
    {
       $fullpage = '';
        if(isset($scripts)){
           foreach($scripts as $script){
                echo $this->loadTemplateScript(Config::getConfig('app'), $script);
            }
        }
        if(isset($styles)){
            foreach($styles as $style){
                 echo $this->loadTemplateStyle(Config::getConfig('app'), $style);
             }
         }
    
         $template = $this->loadTemplate(Config::getConfig('app'), $template);
         SmartyRenderer::getRenderer()->renderAndDisplayTemplate($parameters, $template);

    }
}