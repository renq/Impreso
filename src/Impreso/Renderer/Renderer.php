<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Michał Lipek
 * Date: 04.10.13
 * Time: 15:07
 */

namespace Impreso\Renderer;


use Impreso\Container\Base;

interface Renderer
{

    public function render(Base $container);

}