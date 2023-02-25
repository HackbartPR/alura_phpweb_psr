<?php

namespace HackbartPR\Controller;

abstract class HtmlViewController
{
    private const TEMPLATE_PATH = __DIR__ . '/../../view/';
    
    protected function renderTemplate(string $templateName, array $context = []): string
    {
        extract($context);
        
        ob_start();        
        require_once self::TEMPLATE_PATH . $templateName . '.php';        
        return ob_get_clean();
    }
}