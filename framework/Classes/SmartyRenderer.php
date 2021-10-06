<?php

/**
 * Wrapper class for the Smarty PHP engine, allows for using the engine in the app while having the app be independant of this particular engine and being dependant only on the wrapper's interface
 */

 namespace Framework\Classes;

use Framework\Interfaces\TemplateRenderer;
use Framework\Traits\TemplateHelpers;
 use Smarty;

 class SmartyRenderer implements TemplateRenderer
 {
    use TemplateHelpers;

    protected Smarty $smartyInstance;
    protected $template;
     public function __construct()
     {
      
         $this->smartyInstance = new Smarty();
         $this->smartyInstance->setCompileDir($this->getCompiledTemplateDirectory(Config::getInstance('app')));
         $this->smartyInstance->caching = false;
       
     }
     
     /**
      * Method getInstance
      *
      * Get an instance of the Smarty template renderer
      * @return SmartyRenderer
      */
     public static function getInstance() :SmartyRenderer
     {
         return new SmartyRenderer();
     }

     
     /**
      * Method assignVariables
      *
      * Assign variables to the current template
      * @param array $variables Array of variables to assign
      *
      * @return void
      */
     public function assignVariables(array $variables)
     {
         if (!empty($variables))
         {
            foreach ($variables as $name=>$value){
                $this->smartyInstance->assign($name, $value);
            }
         }
     }
     
     /**
      * Method renderAndDisplayTemplate
      *
      * Render and display the provided template
      * @param string $template The template file name (without an extension)
      * @param array $variables Variables to assign to the template
      *
      * @return void
      */
     public function renderAndDisplayTemplate(string $template, array $variables)
     {
         $this->assignVariables($variables);
         $this->smartyInstance->display($template);
     }
     
     /**
      * Method getRenderedTemplateString
      *
      * Render the provided template and return it as a string
      * @param string $template The template file name (without an extension)
      * @param array $variables Variables to assign to the template
      *
      * @return string The template string
      */
     public function getRenderedTemplateString(string $template, array $variables) :string
     {
         $this->assignVariables($variables);
         return $this->smartyInstance->fetch($template);
     }
 }