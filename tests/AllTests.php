<?php

if (!defined('PHPUnit_MAIN_METHOD')) {
    define('PHPUnit_MAIN_METHOD', 'Math_Vector_AllTests::main');
}

require_once 'PHPUnit/TextUI/TestRunner.php';

require_once 'Math_VectorTest.php';

class Math_Vector_AllTests
{
    public static function main()
    {
        PHPUnit_TextUI_TestRunner::run(self::suite());
    }

    public static function suite()
    {
        $suite = new PHPUnit_Framework_TestSuite('PEAR - Math_Vector');

        $suite->addTestSuite('Math_VectorTest');
        $suite->addTestSuite('Math_TupleTest');

        return $suite;
    }
}

if (PHPUnit_MAIN_METHOD == 'Math_Vector_AllTests::main') {
    Math_Vector_AllTests::main();
}