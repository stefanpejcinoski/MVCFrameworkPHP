<?php
/**
 * Defines functionality necessary for rendering templates
 */

namespace Framework\Interfaces;

interface TemplateRenderer
{    
    /**
     * Method getInstance
     * 
     * Get an instance of the class
     *
     * @return TemplateRenderer
     */
    public static function getInstance() :TemplateRenderer;
    
    /**
     * Method getRenderedTemplateString
     * 
     * Return the rendered template as a string
     *
     * @param string $template The template file name(without extension)
     * @param array $variables Variables to assign to the template
     *
     * @return string The rendered template string
     */
    public function getRenderedTemplateString(string $template, array $variables) :string;
    
    /**
     * Method renderAndDisplayTemplate
     * 
     * Render and display the template
     *
     * @param string $template The template file name (witohut extension)
     * @param array $variables Variables to assign to the template
     *
     * @return void
     */
    public function renderAndDisplayTemplate(string $template, array $variables);
}