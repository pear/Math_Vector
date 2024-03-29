<?php
/**
 * Test program to ensure class Math/Tuple working properly.
 * php version 5.0
 *
 * @category Math
 * @package  Math_Vector
 * @author   Brimbard <brimbard@web.de>
 * @license  https://www.php.net/license/3_01.txt PHP3.01
 * @version  GIT: @0.0.1@ alpha
 * @link     https://github.com/Brimbard/Math_Vector
 */

use PHPUnit\Framework\TestCase;

require_once "Math/Tuple.php";

/**
 * Minimal class to be used as a wrong parameter
 *
 * @category Math
 * @package  Math_Vector
 * @author   Jesus M. Castagnetto <jmcastagnetto@php.net>
 * @license  https://www.php.net/license/2_02.txt PHP2.02
 * @version  Release: 0.9.0 beta
 * @link     https://github.com/Brimbard/Math_Vector
 */
class A
{
}

/**
 * Test class
 *
 * @category Math
 * @package  Math_Vector
 * @author   Brimbard <brimbard@gmx.de>
 * @license  https://www.php.net/license/3_01.txt PHP3.01
 * @version  Release: 0.0.1 alpha
 * @link     https://github.com/Brimbard/Math_Vector
 *
 * @arg array elements
 */


class Math_TupleTest extends TestCase
{

    /**
     * Set test parameter/data
     *
     * @return void
     */
    function setup(): void
    {
    }

    /**
     * Test constructor
     *
     * @return void
     */
    function testConstructor() : void
    {
        // from array
        $t = new Math_Tuple(array(1,2,3));
        $this->assertTrue(get_class($t) == "Math_Tuple");

        // list of numbers
        $t = new Math_Tuple(2, 3, 4);
        $this->assertTrue(get_class($t) == "Math_Tuple");

        // without parameter, empty tuple
        $t = new Math_Tuple();
        $this->assertTrue(get_class($t) == "Math_Tuple");

        // single value
        $t = new Math_Tuple(3);
        $this->assertTrue(get_class($t) == "Math_Tuple");

        // from tuple
        $s = new Math_Tuple($t);
        $this->assertTrue(get_class($s) == "Math_Tuple");
    }

    /**
     * Test constructor Exception
     *
     * @return void
     */
    function testFail1() : void
    {

        // raise Exception, single arg not numeric
        $this->expectException(InvalidArgumentException::class);
        $t = new Math_Tuple('foo');
    }

    /**
     * Test constructor Exception
     *
     * @return void
     */
    function testFail2() : void
    {
        // raise Exception, single arg unknown object
        $this->expectException(InvalidArgumentException::class);
        $t = new Math_Tuple(new A());
    }

    /**
     * Test constructor Exception
     *
     * @return void
     */
    function testFail3() : void
    {
        // raise Exception, mixed parameters
        $this->expectException(InvalidArgumentException::class);
        $t = new Math_Tuple(array(4,5), 2, 3);
    }

    /**
     * Test squeezeHoles()
     *
     * @return void
     */
    function testSqueezeHoles() : void
    {
        $this->markTestIncomplete(
            "This test has not been implemented yet."
        );
    }

    /**
     * Test getSize()
     *
     * @return void
     */
    function testGetSize() : void
    {
        $this->markTestIncomplete(
            "This test has not been implemented yet."
        );
    }

    /**
     * Test setElement()
     *
     * @return void
     */
    function testsetElement() : void
    {
        $this->markTestIncomplete(
            "This test has not been implemented yet."
        );
    }

    /**
     * Test addElement()
     *
     * @return void
     */
    function testAddElement() : void
    {
        $this->markTestIncomplete(
            "This test has not been implemented yet."
        );
    }

    /**
     * Test delElement()
     *
     * @return void
     */
    function testDelElement() : void
    {
        $this->markTestIncomplete(
            "This test has not been implemented yet."
        );
    }

    /**
     * Test getElement()
     *
     * @return void
     */
    function testGetElement() : void
    {
        $this->markTestIncomplete(
            "This test has not been implemented yet."
        );
    }

    /* remaining methods in Tuple to test:

    public function getData()
    public function getMin()
    public function getMax()
    public function getMinMax()
    public function getValueIndex($val)
    public function getMinIndex()
    public function getMaxIndex()
    public function getMinMaxIndex()
    public function isZero()
    public function toString()
    public function __toString()
    public function toHTML()

    */

}
?>
