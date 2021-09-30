<?php

/**
 * Helper functions for loading template files
 */

 namespace Framework\Traits;

use Framework\Config;

trait TemplateHelpers
 {
     protected function loadTemplate (Config $config, string $tplname) :string
     {
        return $config->getKey('root_directory').'/'.$config->getKey('template_directory').'/'.$tplname.'.tpl';
     }
     protected function getCompiledTemplateDirectory (Config $config) :string 
     {
        return $config->getKey('root_directory').'/'.$config->getKey('compiled_templates_directory');
     }
     protected function loadTemplateStyle (Config $config, string $stylename) :string
     {
         return '<link rel="stylesheet" href="'.$config->getKey('root_directory').'/'.$config->getKey('stylesheets_directory').'/'.$stylename.'"></link>';
     }
     protected function loadTemplateScript (Config $config, string $scriptname) :string
     {
      return '<script src="'.$config->getKey('root_directory').'/'.$config->getKey('scripts_directory').'/'.$scriptname.'"/></script>';
     }
   
 }