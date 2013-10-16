<?php
/**
 * Created by JetBrains PhpStorm.
 * User: renq
 * Date: 16.10.13
 * Time: 21:57
 * To change this template use File | Settings | File Templates.
 */

namespace Tests\Impreso\Renderer;


use Impreso\Container\Form;
use Impreso\Element\Text;
use Impreso\Renderer\DivRenderer;
use Impreso\Validator\EmailValidator;

class DivRendererTest extends \PHPUnit_Framework_TestCase
{

    public function testRenderer()
    {
        $msg = 'E-mail address is incorrect';
        $label = 'Enter e-mail';
        $form = new Form();
        $form->setRenderer(new DivRenderer());

        $email = new Text('email');
        $email->addValidator(new EmailValidator($msg));
        $form->addElement($email);


        $this->assertNotContains($msg, (string)$form->render());
        $form->validate();
        $this->assertContains($msg, (string)$form->render());

        $this->assertNotContains($label, (string)$form->render());
        $email->setLabel($label);
        $this->assertContains($label, (string)$form->render());
    }
}
