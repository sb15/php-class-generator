<?php

namespace Sb\PhpClassGenerator;

class AbstractClass
{
    private $name;
    private $namespace;
    private $extend;
    private $implements = array();
    private $isAbstract;

    /**
     * @var AbstractClassField[]
     */
    private $fields = array();
    /**
     * @var AbstractClassMethod[]
     */
    private $methods = array();

    public function addMethod(AbstractClassMethod $method)
    {
        $this->methods[] = $method;
    }

    public function addField(AbstractClassField $field)
    {
        $this->fields[] = $field;
    }

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;
    }

    public function setExtends($extends)
    {
        $this->extend = $extends;
    }

    public function addImplements($implements)
    {
        $this->implements[] = $implements;
    }

    public function sortMethods()
    {

    }

    public function sortFields()
    {

    }

    public function setAbstract()
    {
        $this->isAbstract = true;
    }

    public function generateSettersAndGetters()
    {
        foreach ($this->fields as $field) {
            $fieldName = $field->getName();
            $setFieldMethod = new AbstractClassMethod($field->getSetterName());

            $param = new AbstractMethodParam($field->getName());
            $setFieldMethod->addParam($param);
            $setFieldMethod->addContentLine(AbstractClass::tab(2) . '$this->' . $fieldName . ' = $' . $fieldName . ';');

            $this->addMethod($setFieldMethod);

            $getFieldMethod = new AbstractClassMethod($field->getGetterName());
            $getFieldMethod->addContentLine(AbstractClass::tab(2) . "return \${$fieldName};");
            $this->addMethod($getFieldMethod);
        }
    }

    public function __toString()
    {
        $content = '<?php' . "\n\n";

        if ($this->namespace) {
            $content .= "namespace " . $this->namespace . ";\n\n";
        }

        if ($this->isAbstract) {
            $content .= "abstract ";
        }

        $content .= "class " . $this->name;

        if ($this->extend) {
            $content .= " extends " . $this->extend;
        }

        if ($this->implements) {
            $content .= " implements " . implode("," , $this->implements);
        }

        $content .= "\n" . '{' . "\n";

        $innerContent = "";
        foreach ($this->fields as $field) {
            $innerContent .= $field->__toString() . "\n";
        }

        foreach ($this->methods as $method) {
            $innerContent .= $method->__toString() . "\n";
        }

        $content .= $innerContent;

        $content .= "}";

        return $content;
    }

    public static function tab($amount = 1)
    {
        return str_repeat(" ", 4 * $amount);
    }
} 