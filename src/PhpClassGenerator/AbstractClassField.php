<?php

namespace Sb\PhpClassGenerator;

use Sb\Utils as SbUtils;

class AbstractClassField
{

    private $name;
    private $scope = 'public';
    private $isStatic;
    private $default;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function setScope($scope)
    {
        $this->scope = $scope;
    }

    public function getSetterName()
    {
        return "set" . SbUtils::wordUnderscoreToCamelCase($this->name);
    }

    public function getGetterName()
    {
        return "get" . SbUtils::wordUnderscoreToCamelCase($this->name);
    }

    public function getName()
    {
        return $this->name;
    }

    public function setDefault($default)
    {
        $this->default = $default;
    }

    public function setStatic()
    {
        $this->isStatic = true;
    }

    public function __toString()
    {
        $content = AbstractClass::tab() . $this->scope;

        if ($this->isStatic) {
            $content .= ' static';
        }

        $content .= ' $' . $this->name;

        if ($this->default) {
            if (is_array($this->default)) {

                $defaults = $this->default;
                foreach ($defaults as $key => $default) {
                    $defaults[$key] = is_string($default) ? '"' . $default . '"' : $default;
                }

                $content .= ' = array(' . "\n" . AbstractClass::tab(2);
                $content .= implode(",\n" . AbstractClass::tab(2), $defaults);
                $content .= "\n" .  AbstractClass::tab() . ")";
            } else {
                $content .= ' = ' . (is_string($this->default) ? '"' . $this->default . '"' : $this->default);
            }
        }

        $content .= ";\n";

        return $content;
    }
} 