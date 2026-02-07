<?php

use Michelf\MarkdownExtra;
use Twig\Extension\AbstractExtension;
use Twig\Extra\Markdown\MichelfMarkdown;
use Twig\TwigFilter;
use Twig\TwigFunction;

class Monextension extends AbstractExtension {
 

    public function getFilters () {
        return [
            new TwigFilter("markdown", [$this, "markdownParse"], ["is_safe" => ["html"]])
        ];
    }

    public function markdownParse ($value) {
        return MarkdownExtra::defaultTransform($value);
    }

    public function getFunctions () {
        return [
            new TwigFunction("activeClass" ,[$this, "activeClass"])
        ];
    }

    public function activeClass ($page) {
        
    }

}