<?php

/**
 * Wrapper class for the Smarty PHP engine, allows for using the engine in the app while having the app be independant of this particular engine and being dependant only on the wrapper's interface
 */

 namespace Framework\Classes;
 use Framework\Interfaces\TemplateRendering;
use Framework\Interfaces\TemplateRenderingInterface;
use Framework\Traits\TemplateHelpers;
 use Smarty;

 class SmartyRenderer implements TemplateRenderingInterface
 {
    use TemplateHelpers;

    protected Smarty $smartyInstance;
    protected $template;
     public function __construct()
     {
      
         $this->smartyInstance = new Smarty();
         $this->smartyInstance->setCompileDir($this->getCompiledTemplateDirectory(Config::getConfig('app')));
         $this->smartyInstance->caching = false;
       
     }

     public static function getRenderer()
     {
         return new SmartyRenderer();
     }


     public function assignVariables(array $variables)
     {
         if (!empty($variables))
         {
            foreach ($variables as $name=>$value){
                $this->smartyInstance->assign($name, $value);
            }
         }
     }

     public function renderAndDisplayTemplate(string $template, array $variables)
     {
     
       
         $this->assignVariables($variables);
       
         $this->smartyInstance->display($template);
     }

     public function getRenderedTemplateString(string $template, array $variables)
     {
         $this->assignVariables($variables);
         return $this->smartyInstance->fetch($template);
     }
 }