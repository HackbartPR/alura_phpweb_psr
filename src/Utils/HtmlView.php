<?php

namespace HackbartPR\Utils;

trait HtmlView
{
    private const TEMPLATE_PATH = __DIR__ . '/../../view/';
    
    private function renderTemplate(string $templateName, array $context = []): string
    {
        extract($context);
        
        ob_start();        
        require_once self::TEMPLATE_PATH . $templateName . '.php';        
        return ob_get_clean();
    }
}