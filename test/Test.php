<?php

include dirname(__DIR__) . "/vendor/autoload.php";

use Sb\PhpClassGenerator\AbstractClass;
use Sb\PhpClassGenerator\AbstractClassMethod;
use Sb\PhpClassGenerator\AbstractMethodParam;
use Sb\PhpClassGenerator\AbstractClassField;

$class = new AbstractClass("Coupon");
$class->setNamespace("ns");
$class->setExtends("BasicCoupon");
$class->addImplements("BasicInterface");
$class->addUse("\\Something\\Class", "SClass");

$method = new AbstractClassMethod("test");
$param = new AbstractMethodParam("param1");
$param2 = new AbstractMethodParam("param2");
$param2->setType("ParamClass");
$param2->setDefaultValue(1);
$method->setContent(AbstractClass::tab(2) . "echo 1;");
$method->addParam($param);
$method->addParam($param2);
$method->setReturn("ReturnClass");

$class->addMethod($method);

$field = new AbstractClassField("field");
$field->setDefault('"123"');
$field2 = new AbstractClassField("field2");
$field2->setDefault(array('"123"',4));
$field2->setStatic();
$class->addField($field);
$class->addField($field2);

$class->generateSettersAndGetters();

echo $class;