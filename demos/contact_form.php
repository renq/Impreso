<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Michał Lipek
 * Date: 08.10.13
 * Time: 15:10
 */

use Impreso\Container\Form;
use Impreso\Element\Button;
use Impreso\Element\Text;
use Impreso\Element\TextArea;
use Impreso\Filter\LowerCaseFilter;
use Impreso\Filter\TrimFilter;
use Impreso\Renderer\DivRenderer;
use Impreso\Validator\EmailValidator;
use Impreso\Validator\RequiredValidator;
use Impreso\Validator\StringLengthValidator;

include('../vendor/autoload.php');

/* Create form, set basic stuff */
$form = new Form();
$form->setMethod('post');
$form->setAction($_SERVER['REQUEST_URI']);

/* Renderer is a object that's create render form into HTML */
$form->setRenderer(new DivRenderer());

/* Now we're creating some elements. Code is quite straightforward and no needs extra comment. */
$name = new Text('name');
$name->setLabel('Your name');
$name->addValidator(new RequiredValidator('What is your name?'));
$name->addFilter(new TrimFilter());

$email = new Text('email');
$email->setLabel('Your e-mail');
$email->addValidator(new RequiredValidator('Do you have email? No? But you must have!'));
$email->addValidator(new EmailValidator('Seriously? This is your e-mail?'));
$email->addFilter(new LowerCaseFilter());

$message = new TextArea('message');
$message->setLabel('Message');
$message->addValidator(new StringLengthValidator("Your message can't be too short or too long. We need something about 10 - 200 characters.", 10, 200));

$button = new Button();
$button->setText('Send');

/* Add elements to form. */
$form->addElement($name);
$form->addElement($email);
$form->addElement($message);
$form->addElement($button);

/* Magic. :) */
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $form->populate($_POST);
    if ($form->validate()) {
        /* Do something with form data, send mail, save to database. Anything you want. */
        /* $data is an array, like $_POST, but unlike raw post data, $data is filtered. */

        $data = $form->getData();
        echo "Thank you {$data['name']}! Your message has been save in /dev/null :)";
        exit();
    }
}

echo $form;
