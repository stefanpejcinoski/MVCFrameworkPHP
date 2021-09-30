<?php

namespace Framework\Classes;

use Framework\Interfaces\TemplateRendering;
use Framework\Traits\FileOperations;
use Framework\Traits\TemplateHelpers;
use Smarty;

/**
 * Defines properties and methods necessary for rendering template views
 */

 class View 
{

    use TemplateHelpers;
    use FileOperations;

    protected static View $instance;
    public function __construct()
    {
        $this->engine = Config::getConfig('app')->getKey('template_engine');
    }

    /**
     * Returns an instance of the View object allowing one line calls to render a template
     */
    public static function getView() {
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
    public function display(string $template, array $parameters = null) 
    {
        
         $scriptsDir = self::joinPaths([Config::getConfig('app')->getKey('root_directory'), Config::getConfig('app')->getKey('scripts_directory')]);
         $stylesheetsDir = self::joinPaths([Config::getConfig('app')->getKey('root_directory'), Config::getConfig('app')->getKey('stylesheets_directory')]);
         foreach($this->loadFilesFromDirectory($scriptsDir, 'js') as $script){
            echo '<script src="'.$script.'"/></script>';
         }


         foreach($this->loadFilesFromDirectory($stylesheetsDir, 'css') as $stylesheet){
            echo '<link rel="stylesheet" href="'.$stylesheet.'"></link>';
         }

         $template = $this->loadTemplate(Config::getConfig('app'), $template);
         SmartyRenderer::getRenderer()->renderAndDisplayTemplate($parameters, $template);

    }
     /**
     * Renders and returns the provided template as a string, allowing it to be sent back as an AJAX call response
     * 
     * @param string $template required
     * @param array $parameters optional
     * @param array $scripts optional
     * @param array $styles optional
     */
    public function getViewAsString(string $template, array $parameters = null) 
    {
     
    
         $template = $this->loadTemplate(Config::getConfig('app'), $template);
        return  SmartyRenderer::getRenderer()->getRenderedTemplateString($parameters, $template);

    }
}