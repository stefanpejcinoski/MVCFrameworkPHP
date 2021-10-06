<?php

namespace Framework\Classes;

use Framework\Interfaces\TemplateRenderer;
use Framework\Traits\FileOperations;
use Framework\Traits\TemplateHelpers;


/**
 * Defines properties and methods necessary for rendering template views
 */

 class View 
{

    use TemplateHelpers;
    use FileOperations;

    
    protected TemplateRenderer $engineInstance;
    public function __construct()
    {
        $this->engineInstance = Config::getInstance('app')->getKey('template_engine')::getInstance();
    }

    /**
     * Method getInstance
     * 
     * Returns an instance of the class.
     */
    public static function getInstance() {
        return new View;
    }
    /**
     * Method display
     * 
     * Display the provided template file with the given scripts, stylesheets and parameters
     * 
     * @param string $template required
     * @param array $parameters optional
     * @param array $scripts optional
     * @param array $styles optional
     */
    public function display(string $template, array $parameters = []) 
    {
        
        $scriptsDir = self::joinPaths([PROJECTROOT, Config::getInstance('app')->getKey('scripts_directory')]);
        $stylesheetsDir = self::joinPaths([PROJECTROOT, Config::getInstance('app')->getKey('stylesheets_directory')]);

         $scriptList = $this->loadFilesFromDirectory($scriptsDir, 'js');
         $stylesheetList = $this->loadFilesFromDirectory($stylesheetsDir, 'css');

         foreach($scriptList as $script){
            echo '<script src="'.$this->joinPaths([Config::getInstance('app')->getKey('scripts_directory'), $script]).'"/></script>';
         }


         foreach($stylesheetList as $stylesheet){
            echo '<link rel="stylesheet" href="'.$this->joinPaths([Config::getInstance('app')->getKey('stylesheets_directory'), $stylesheet]).'"></link>';
         }
        
         $template = $this->loadTemplate(Config::getInstance('app'), $template);
        
         $this->engineInstance->renderAndDisplayTemplate($template, $parameters);

    }
     /**
     * Method getViewAsString
     * 
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
        
        $scriptsDir = self::joinPaths([PROJECTROOT, Config::getInstance('app')->getKey('scripts_directory')]);
        $stylesheetsDir = self::joinPaths([PROJECTROOT, Config::getInstance('app')->getKey('stylesheets_directory')]);
        
        $scriptList = $this->loadFilesFromDirectory($scriptsDir, 'js');
        $stylesheetList = $this->loadFilesFromDirectory($stylesheetsDir, 'css');

        foreach($scriptList as $script){
           $fullTemplate.= '<script src="'.$this->joinPaths(['/', Config::getInstance('app')->getKey('scripts_directory'), $script]).'"/></script>';
        }


        foreach($stylesheetList as $stylesheet){
           $fullTemplate.= '<link rel="stylesheet" href="'.$this->joinPaths(['/', Config::getInstance('app')->getKey('stylesheets_directory'), $stylesheet]).'"></link>';
        }

         $template = $this->loadTemplate(Config::getInstance('app'), $template);
         $renderedString = $this->engineInstance->getRenderedTemplateString($template, $parameters);

         $fullTemplate.=$renderedString;

         return $renderedString;

    }
}