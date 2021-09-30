<?php

/**
 * Helper functions for loading template files
 */

 namespace Framework\Traits;

use Framework\Classes\Config;

trait TemplateHelpers
 {
     protected function loadTemplate (Config $config, string $tplname) :string
     {
        return PROJECTROOT.'/'.$config->getKey('template_directory').'/'.$tplname.'.tpl';
     }
     protected function getCompiledTemplateDirectory (Config $config) :string 
     {
        return PROJECTROOT.'/'.$config->getKey('compiled_templates_directory');
     }
     protected function loadTemplateStyle (Config $config, string $stylename) :string
     {
         return '<link rel="stylesheet" href="'.PROJECTROOT.'/'.$config->getKey('stylesheets_directory').'/'.$stylename.'"></link>';
     }
     protected function loadTemplateScript (Config $config, string $scriptname) :string
     {
      return '<script src="'.PROJECTROOT.'/'.$config->getKey('scripts_directory').'/'.$scriptname.'"/></script>';
     }
   
 }