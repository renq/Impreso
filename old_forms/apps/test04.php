<?php

include('test04_form.php');


$form = new Test04Form();
$form->start();

if (isset($_SESSION['data'])) {
	$form->setData($_SESSION['data']);	
	$form->validate();
	
	unset($_SESSION['data']);
}


echo $form->show(new AF_ParagraphLayout());

?>