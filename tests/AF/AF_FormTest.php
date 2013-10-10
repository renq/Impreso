<?php
use Impreso\Renderer\DivRenderer;

/**
 * Created by JetBrains PhpStorm.
 * User: Michał Lipek
 * Date: 10.10.13
 * Time: 13:33
 */

class AF_FormTest extends PHPUnit_Framework_TestCase
{

    /**
     * Example from AgataMeble.pl
     */
    public function testLegacyUsage()
    {
        $form = new AF_Form();
        $form->method = 'post';
        $form->action = '';
        $form->add('hidden', 'mod')->value = 'module';
        $form->add('hidden', 'action')->value = 'save';
        $form->add('hidden', 'id')->value = 0;
        $form->add('text', 'name', 'Nazwa ikonki', new AF_RequiredFieldValidator('Podaj nazwę ikonki, która będzie widoczna dla wyszukiwarek i czytników ekranowych.'));
        $form->add('text', 'photo', 'Ikonka', new AF_RequiredFieldValidator('Wybierz ikonkę.'))->class = 'filemanager';
        $form->add('text', 'photo_small', 'Mała ikonka na listę produktów')->class = 'filemanager';
        $form->add('checkbox', 'main_icon', 'Ikona główna (wyświetlaj ikonę w edycji produktu)');
        $form->add('select', 'type', 'Typ ikonki')->setOptions(array(
            'top' => 'Górna',
            'bottom' => 'Dolna',
        ));
        $form->add('hidden', 'active')->value = 1;

        $form->add('submit', 'save')->value = 'Zapisz';
        $form->add('button', 'back')->set('value', 'Powrót')->set('onclick', 'history.back(); return false;');

        $form->setRenderer(new DivRenderer());
        $html = $form->render();

        $this->assertTrue(strpos($html, 'name="name"') !== false);
        $this->assertTrue(strpos($html, 'Nazwa ikonki</label>') !== false);
        $this->assertTrue(strpos($html, 'Typ ikonki') !== false);
        $this->assertTrue(strpos($html, '>Górna<') !== false);

        // now put some data
        $this->assertFalse($form->isSent());
        $this->assertFalse($form->validate());

        // put some request data
        $_REQUEST = $_REQUEST + array(
            'mod' => 'module',
            'action' => 'save',
            'id' => 1,
            'name' => 'Name',
            'photo' => 'photo.jpg',
            'photo_small' => 'thumb.jpg',
            'main_icon' => 1,
            'type' => 'top',
            'hidden' => 'active'
        );

        $this->assertTrue($form->isSent());
        $this->assertTrue($form->validate());
    }

}
