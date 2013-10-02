<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Michał Lipek
 * Date: 25.09.13
 * Time: 14:02
 */

namespace Impreso;


interface Validate
{
    public function addValidator(\Impreso\Validator $validator);
    public function getValidators();
    public function clearValidators();
}
