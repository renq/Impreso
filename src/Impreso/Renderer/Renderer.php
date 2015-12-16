<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Michał Lipek
 * Date: 04.10.13
 * Time: 15:07
 */

namespace Impreso\Renderer;

use Impreso\Container\Base;

/**
 * Interface Renderer
 * @package Impreso\Renderer
 */
interface Renderer
{
    /**
     * @param Base $container
     * @return $this
     */
    public function render(Base $container);
}
