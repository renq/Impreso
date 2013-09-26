<?php

require_once(dirname(__FILE__) . '/../../simpletest/autorun.php');

//qrequire_once('CheckedValidator.php');
    
class AllTests extends TestSuite {
	
    public function AllTests() {
        parent::__construct();
        $this->addFile(dirname(__FILE__).'/IntegerValidator.php');
        $this->addFile(dirname(__FILE__).'/EmailValidator.php');
    }
    
    
}

?>