<?php

include('test04_form.php');


$form = new Test04Form();
$form->start();

$_SESSION['data'] = $form->getData();

if ($form->validate()) {
	header('Location: test04_saved.php');
}
else {
	header('Location: test04.php');
}

exit();

?>