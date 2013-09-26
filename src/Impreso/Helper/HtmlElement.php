<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Michał Lipek
 * Date: 25.09.13
 * Time: 15:34
 */

namespace Impreso\Helper;


class HtmlElement
{
    /**
     * @var string
     */
    private $tag;

    /**
     * @var string
     */
    private $text;

    /**
     * @var array
     */
    private $attributes;


    public function __construct($tag = null, $text = null, array $attributes = array())
    {
        if (null !== $tag) {
            $this->setTag($tag);
        }
        if (null !== $text) {
            $this->setText($text);
        }
        if (is_array($attributes)) {
            $this->setAttributes($attributes);
        }
    }

    /**
     * @param array $attributes
     */
    public function setAttributes(array $attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @param string $tag
     */
    public function setTag($tag)
    {
        $this->tag = $tag;
    }

    /**
     * @return string
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * @param string $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    protected function getAttributesString($exclude = array())
    {
        $result = '';
        $exclude = (array)$exclude;
        foreach ($this->getAttributes() as $k => $v) {
            if (!is_array($v) && !in_array($k, $exclude)) {
                $v = $this->valueEntities($v);
                $result .= "$k=\"$v\" ";
            }
        }
        return trim($result);
    }

    protected function valueEntities($text)
    {
        return htmlentities($text, ENT_COMPAT, 'UTF-8');
    }

    public function render()
    {
        $withoutClosingTag = in_array($this->getTag(), array(
            'input',
            'br'
        ));

        if ($withoutClosingTag) {
            return <<<EOD
<{$this->getTag()} {$this->getAttributesString()}>
EOD;
        }
        else {
            return <<<EOD
<{$this->getTag()} {$this->getAttributesString()}>{$this->getText()}</{$this->getTag()}>
EOD;
        }
    }

    public function __toString()
    {
        return $this->render();
    }
}