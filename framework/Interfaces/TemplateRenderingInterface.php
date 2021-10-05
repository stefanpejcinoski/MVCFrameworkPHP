<?php
/**
 * Defines functionality necessary for rendering templates
 */

namespace Framework\Interfaces;

interface TemplateRenderingInterface
{
    /* Get an instance of the renderer, allows for chaining instantiation and method calls in cases where storing an instance is not required*/
    public static function getRenderer();

    /* Get a rendered template html in string format */
    public function getRenderedTemplateString(string $template, array $variables);

    /* Render and display a template */
    public function renderAndDisplayTemplate(string $template, array $variables);
}