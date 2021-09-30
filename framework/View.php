<?php

namespace Framework;

use Framework\Traits\TemplateHelpers;
use Smarty;

/**
 * Defines the basic most needed properties and methods for a View object, all views inherit from this class
 */

abstract class View 
{

    use TemplateHelpers;

    protected Smarty $smartyInstance;

    public function __construct()
    {
        $this->smartyInstance = new Smarty();
        $this->smartyInstance->setCompileDir($this->getCompiledTemplateDirectory(Config::getConfig('app')));
    }

    /**
     * Display the provided template file with the given scripts, stylesheets and parameters
     * 
     * @param Config $config required 
     * @param string $template required
     * @param array $parameters optional
     * @param array $scripts optional
     * @param array $styles optional
     */
    public function display(Config $config, string $template, array $parameters = null, array $scripts = null, array $styles = null) 
    {
       $fullpage = '';
        if(isset($scripts)){
           foreach($scripts as $script){
                echo $this->loadTemplateScript($config, $script);
            }
        }
        if(isset($styles)){
            foreach($styles as $style){
                 echo $this->loadTemplateStyle($config, $style);
             }
         }
         if (isset($parameters) && is_array($parameters)) {
             foreach ($parameters as $name=>$parameter) {
                 $this->smartyInstance->assign($name, $parameter);
             }
         }
       $this->smartyInstance->display($template);
    }
}