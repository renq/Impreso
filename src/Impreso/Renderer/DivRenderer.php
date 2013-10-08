<?php

namespace Impreso\Renderer;

use Impreso\Container\Base;
use Impreso\Element\Hidden;

class DivRenderer implements Renderer
{

    public function render(Base $container)
    {
        $elements = $container->getElements();

        $result = '';
        foreach ($elements as $element) {
            if ($element instanceof Hidden) {
                $result .= (string)$element;
            }
            else {
                $label = '';
                if (strlen($element->getLabel())) {
                    $label = "<label for=\"{$element->getId()}\">{$element->getLabel()}</label>";
                }
                $errorList = '';
                $errors = $element->getErrors();
                if (count($errors)) {
                    foreach ($errors as $error) {
                        $errorList .= '<li>'.$error.'</li>';
                    }
                    $errorList = "<ul class=\"errorList\">$errorList</ul>";
                }
                $result .= <<<EOD
<div>
	{$label}
	{$element}
	{$errorList}
</div>

EOD;
            }
        }
        return $result;
    }
}
