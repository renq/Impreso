<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Michał Lipek
 * Date: 25.09.13
 * Time: 13:24
 */

namespace Impreso\Container;

use Impreso\Helper\HtmlElement;

class Form extends Base
{

    private $method;
    private $action;
    private $validateErrors = array();

    public function __construct()
    {
        parent::__construct();
        $this->addValidAttributes(
            array(
                'accept-charset',
                'autocomplete',
                'enctype',
                'name',
                'novalidate',
            )
        );
    }

    /**
     * @param string $action
     * @return $this
     */
    public function setAction($action)
    {
        $this->action = $action;
        return $this;
    }

    /**
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param string $method
     * @throws \InvalidArgumentException
     * @return $this
     */
    public function setMethod($method)
    {
        $method = strtolower($method);
        if (!in_array($method, array('post', 'get'))) {
            throw new \InvalidArgumentException("Wrong method '$method'. According to HTML5 specyfication, only POST and GET are allowed.");
        }
        $this->method = $method;
        return $this;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    public function preValidate()
    {
    }

    public function customValidator()
    {
        return true;
    }

    public function addError($error) {
        $this->validateErrors[] = $error;
    }

    public function getErrors() {
        return $this->validateErrors;
    }

    public function validate()
    {
        $this->preValidate();
        $result = true;
        foreach ($this->getElements() as $v) {
            $tmp = $v->validate();
            if (!$tmp) {
                $result = false;
            }
        }
        $resultCustom = $this->customValidator();
        $formErrors = $this->getErrors();
        return $result && $resultCustom && empty($formErrors);
    }

    public function render()
    {
        return new HtmlElement(
            'form',
            parent::render(),
            array(
                'method' => $this->getMethod(),
                'action' => $this->getAction(),
            ) + $this->getAttributes()
        );
    }
}
