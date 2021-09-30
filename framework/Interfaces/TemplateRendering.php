<?php
/**
 * Defines functionality necessary for rendering templates
 */

namespace Framework\Interfaces;

interface TemplateRendering
{
    public static function getRenderer();

    public function getRenderedTemplateString(string $template, array $variables);

    public function renderAndDisplayTemplate(string $template, array $variables);
}