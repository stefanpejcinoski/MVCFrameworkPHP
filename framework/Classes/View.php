<?php

namespace Framework\Classes;

use Framework\Interfaces\TemplateRendering;
use Framework\Traits\FileOperations;
use Framework\Traits\TemplateHelpers;


/**
 * Defines properties and methods necessary for rendering template views
 */

 class View 
{

    use TemplateHelpers;
    use FileOperations;

    protected static View $instance;
    protected TemplateRendering $engineInstance;
    public function __construct()
    {
        $this->engineInstance = Config::getConfig('app')->getKey('template_engine')::getRenderer();
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

         $scriptList = $this->loadFilesFromDirectory($scriptsDir, 'js');
         $stylesheetList = $this->loadFilesFromDirectory($stylesheetsDir, 'css');

         foreach($scriptList as $script){
            echo '<script src="'.$this->joinPaths([Config::getConfig('app')->getKey('scripts_directory'), $script]).'"/></script>';
         }


         foreach($stylesheetList as $stylesheet){
            echo '<link rel="stylesheet" href="'.$this->joinPaths([Config::getConfig('app')->getKey('stylesheets_directory'), $stylesheet]).'"></link>';
         }

         $template = $this->loadTemplate(Config::getConfig('app'), $template);
         $this->engineInstance->renderAndDisplayTemplate($parameters, $template);

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
        $fullTemplate= '';
        
        $scriptsDir = self::joinPaths([Config::getConfig('app')->getKey('root_directory'), Config::getConfig('app')->getKey('scripts_directory')]);
        $stylesheetsDir = self::joinPaths([Config::getConfig('app')->getKey('root_directory'), Config::getConfig('app')->getKey('stylesheets_directory')]);

        $scriptList = $this->loadFilesFromDirectory($scriptsDir, 'js');
        $stylesheetList = $this->loadFilesFromDirectory($stylesheetsDir, 'css');

        foreach($scriptList as $script){
           $fullTemplate.= '<script src="'.$this->joinPaths([Config::getConfig('app')->getKey('scripts_directory'), $script]).'"/></script>';
        }


        foreach($stylesheetList as $stylesheet){
           $fullTemplate.= '<link rel="stylesheet" href="'.$this->joinPaths([Config::getConfig('app')->getKey('stylesheets_directory'), $stylesheet]).'"></link>';
        }

         $template = $this->loadTemplate(Config::getConfig('app'), $template);
         $renderedString = $this->engineInstance->getRenderedTemplateString($parameters, $template);

         $fullTemplate.=$renderedString;

         return $renderedString;

    }
}