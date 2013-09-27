<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Michał Lipek
 * Date: 27.09.13
 * Time: 14:16
 */

namespace Tests\Impreso\Helper;


use Impreso\Element\Text;
use Impreso\Validator\Email;

class EmailTest extends \PHPUnit_Framework_TestCase
{

    public function testValidator()
    {
        $text = new Text('test');
        $text->addValidator(new Email());
        $text->setValue('michal@lipek.net');
        $this->assertTrue($text->validate());

        $text->setValue('test@test');
        $this->assertFalse($text->validate());
    }
}
