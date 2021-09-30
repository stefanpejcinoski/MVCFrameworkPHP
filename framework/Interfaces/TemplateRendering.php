<?php
/**
 * Defines functionality necessary for rendering templates
 */

namespace Framework\Interfaces;

interface TemplateRendering
{
    public static function getRenderer();


    public function assignVariables(array $variables);

    public function getRenderedTemplateString(array $variables, string $template);

    public function renderAndDisplayTemplate(array $variables, string $tempalte);


}