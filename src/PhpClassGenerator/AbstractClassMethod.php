<?php

namespace Sb\PhpClassGenerator;

class AbstractClassMethod
{

    /**
     * @var AbstractMethodParam[]
     */
    private $params = array();

    private $content;

    private $scope = "public";

    private $isStatic = false;

    private $name;

    private $return;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function addParam(AbstractMethodParam $param)
    {
        $this->params[] = $param;
    }

    public function setScope($scope)
    {
        $this->scope = $scope;
    }

    public function setContent($content)
    {
        $this->content = $content . "\n";
    }

    public function addContentLine($line)
    {
        $this->content .= AbstractClass::tab(2) . $line . "\n";
    }

    public function setStatic()
    {
        $this->isStatic = true;
    }

    public function getStatic()
    {
        if ($this->isStatic) {
            return " static ";
        }
        return " ";
    }

    /**
     * @param string $return
     * @return string
     */
    public function setReturn($return)
    {
        $this->return = $return;
    }

    public function __toString()
    {
        $content = "";

        if ($this->return) {
            $content .= AbstractClass::tab() . "/**\n";
            foreach ($this->params as $param) {
                $content .= AbstractClass::tab() . ' * @param';
                if ($param->getType()) {
                    $content .= " " . $param->getType();
                }
                $content .= ' $' . $param->getName() . "\n";
            }

            $content .= AbstractClass::tab() . ' * @return ' . $this->return . "\n";
            $content .= AbstractClass::tab() . " */\n";
        }

        $params = implode(", ", $this->params);

        $content .= AbstractClass::tab() . $this->scope . $this->getStatic() . "function " . $this->name ;
        $content .= "(".$params.")\n";
        $content .= AbstractClass::tab() . '{' . "\n";
        $content .= $this->content;
        $content .= AbstractClass::tab() . '}' . "\n";

        return $content;
    }
} 