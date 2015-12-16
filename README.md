[![Build Status](https://travis-ci.org/renq/Impreso.svg?branch=master)](https://travis-ci.org/renq/Impreso)
[![Coverage Status](https://coveralls.io/repos/renq/Impreso/badge.png)](https://coveralls.io/r/renq/Impreso)

Impreso
=======

Impreso ("Form" en español o esperanto) is form library.

# Usage

This is a basic example of using Impreso. There are quite a lot of code.
The library will have simpler (and faster) interface to create forms, but at this moment, this element of library does not yet exists.

```php
<?php

use Impreso\Container\Form;
use Impreso\Element\Button;
use Impreso\Element\Text;
use Impreso\Element\TextArea;
use Impreso\Filter\LowerCaseFilter;
use Impreso\Filter\TrimFilter;
use Impreso\Renderer\DivRenderer;
use Impreso\Validator\EmailValidator;
use Impreso\Validator\RequiredFieldValidator;
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
$name->addValidator(new RequiredFieldValidator('What is your name?'));
$name->addFilter(new TrimFilter());

$email = new Text('email');
$email->setLabel('Your e-mail');
$email->addValidator(new RequiredFieldValidator('Do you have email? No? But you must have!'));
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
```

## Alternatives

- [ZF2 Form Component](https://github.com/zendframework/zf2/tree/master/library/Zend/Form)
- [Aura.Input](http://auraphp.com/packages/Aura.Input/)
- [Symfony2 Forms](http://symfony.com/doc/current/book/forms.html)
