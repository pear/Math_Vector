<?php
/**
 * Base class Tuple
 * php version 5.0
 *
 * @category Math
 * @package  Math_Vector
 * @author   Jesus M. Castagnetto <jmcastagnetto@php.net>
 * @license  https://www.php.net/license/2_02.txt PHP2.02
 * @version  GIT: @0.9.0@ beta
 * @link     https://github.com/pear/Math_Vector
 *
 * standards checked with CodeSniffer 3.9.0
 * tested with PHPUnit 11.0.7 + PHP8.3
 * Backwards compability: examples run in CLI with PHP5.6
 *
 * Old documentation:
 * +----------------------------------------------------------------------+
 * | PHP Version 5                                                        |
 * +----------------------------------------------------------------------+
 * | Copyright (c) 1997-2003 The PHP Group                                |
 * +----------------------------------------------------------------------+
 * | This source file is subject to version 2.0 of the PHP license,       |
 * | that is bundled with this package in the file LICENSE, and is        |
 * | available at through the world-wide-web at                           |
 * | http://www.php.net/license/2_02.txt.                                 |
 * | If you did not receive a copy of the PHP license and are unable to   |
 * | obtain it through the world-wide-web, please send a note to          |
 * | license@php.net so we can mail you a copy immediately.               |
 * +----------------------------------------------------------------------+
 * | Authors: Jesus M. Castagnetto <jmcastagnetto@php.net>                |
 * +----------------------------------------------------------------------+
 */

// $Id$


/**
 * General Tuple class
 * A Tuple represents a general unidimensional list of n numeric elements
 * Originally this class was part of NumPHP (Numeric PHP package)
 *
 * @category Math
 * @package  Math_Vector
 * @author   Jesus M. Castagnetto <jmcastagnetto@php.net>
 * @license  https://www.php.net/license/2_02.txt PHP2.02
 * @version  Release: 0.9.0 beta
 * @link     https://github.com/pear/Math_Vector
 */
class Math_Tuple
{

    /**
     * Array of numeric elements
     *
     * @data array of elements
     *
     * @todo check if all elements are numeric
     */
    public $data = null;

    /**
     * Constructor of Math_Tuple
     *
     * This class is the data basis for the Vector class.
     * It should only contain numeric values. For performance reasons
     * not every element is checked on default.
     * Use $this->isNumeric() if you deem necessary.
     *
     * @param ...$data array starting with a numeric
     *                 list starting with a numeric
     *                 empty
     *                 tuple
     *
     * @throws InvalidArgumentException
     */
    public function __construct(...$data)
    {
        $num_args = func_num_args();
        $args = func_get_args();
        if ($num_args < 1) {                    // no argument: empty
            $this->data = array();
        } elseif ($num_args < 2) {              // single argument
            if (is_a($args[0], "Math_Tuple")) { // another Tuple
                $this->data = $args[0]->data;
            } elseif (is_array($args[0])) {     // an array
                $this->data = $args[0];
            } elseif (is_numeric($args[0])) {   // single numeric
                $this->data = array($args[0]);
            } else {
                throw new InvalidArgumentException(
                    "Unsupported parameter object."
                );
            }
        } elseif (is_numeric($args[0])) {       // multiple arguments
                                                // first is numeric
            // Warning only testing 1. arg, so (1, 'foo') is accepted
            // For performance reasons use $this->isNumeric() when needed
            $this->data = $args;
        } else {
            throw new InvalidArgumentException(
                "Unrecognized parameters."
            );
        }
    }

    /**
     * Squeezes out holes in the tuple sequence
     *
     * @return void
     */
    public function squeezeHoles()
    {
        $this->data = array_values($this->data);
    }

    /**
     * Returns the size (number of elements) in the tuple
     *
     * @return integer
     */
    public function getSize()
    {
        return count($this->data);
    }

    /**
     * Sets the value of an element
     *
     * @param integer $elindex element index
     * @param numeric $elvalue element value
     *
     * @return mixed   true if successful
     * @throws InvalidArgumentException
     */
    public function setElement($elindex, $elvalue)
    {
        if ($elindex >= $this->getSize()) {
            throw new InvalidArgumentException(
                "Wrong index: $elindex for element: $elvalue"
            );
        }
        $this->data[$elindex] = $elvalue;
        return true;
    }

    /**
     * Appends an element to the tuple
     *
     * @param numeric $elvalue element value
     *
     * @return mixed  index of appended element on success
     */
    public function addElement($elvalue)
    {
        if (!is_numeric($elvalue)) {
            throw new InvalidArgumentException(
                "Error, a numeric value is needed. You used: $elvalue"
            );
        }
        $this->data[$this->getSize()] = $elvalue;
        return ($this->getSize() - 1);
    }

    /**
     * Remove an element from the tuple
     *
     * @param integer $elindex element index
     *
     * @return mixed   true on success
     * @throws InvalidArgumentException
     */
    public function delElement($elindex)
    {
        if ($elindex >= $this->getSize()) {
            throw new InvalidArgumentException(
                "Wrong index: $elindex, element not deleted"
            );
        }

        unset($this->data[$elindex]);

        $this->squeezeHoles();
        return true;
    }

    /**
     * Returns the value of an element in the tuple
     *
     * @param integer $elindex element index
     *
     * @return mixed   numeric on success
     * @throws InvalidArgumentException
     */
    public function getElement($elindex)
    {
        if ($elindex >= $this->getSize()) {
            throw new InvalidArgumentException(
                "Wrong index: $elindex, Tuple size is: ".$this->getSize()
            );
        }
        return $this->data[$elindex];
    }

    /**
     * Returns an array with all the elements of the tuple
     *
     * @return array
     */
    public function getData()
    {
        $this->squeezeHoles();
        return $this->data;
    }

    /**
     * Returns the minimum value of the tuple
     *
     * @return numeric
     */
    public function getMin()
    {
        return min($this->getData());
    }

    /**
     * Returns the maximum value of the tuple
     *
     * @return numeric
     */
    public function getMax()
    {
        return max($this->getData());
    }

    /**
     * Returns an array of the minimum and maximum values of the tuple
     *
     * @return array of the minimum and maximum values
     */
    public function getMinMax()
    {
        return array ($this->getMin(), $this->getMax());
    }

    /**
     * Gets the first position of the given value in the tuple
     *
     * @param numeric $val value for which the index is requested
     *
     * @return mixed integer position or false
     */
    public function getValueIndex($val)
    {
        for ($i=0; $i < $this->getSize(); $i++) {
            if ($this->data[$i] == $val) {
                return $i;
            }
        }
        return false;
    }

    /**
     * Gets the position of the minimum value in the tuple
     *
     * @return integer
     */
    public function getMinIndex()
    {
        return $this->getValueIndex($this->getMin());
    }

    /**
     * Gets the position of the maximum value in the tuple
     *
     * @return integer
     */
    public function getMaxIndex()
    {
        return $this->getValueIndex($this->getMax());
    }

    /**
     * Gets an array of the positions of the minimum
     * and maximum values in the tuple
     *
     * @return array of integers=indeces
     */
    public function getMinMaxIndex()
    {
        return array($this->getMinIndex(), $this->getMaxIndex());
    }

    /**
     * Checks if the tuple is a a Zero tuple
     *
     * @return boolean
     */
    public function isZero()
    {
        for ($i=0; $i < $this->getSize(); $i++) {
            if ($this->data[$i] != 0) {
                return false;
            }
        }
        return true;
    }

    /**
     * Checks if the tuple only contains numeric values
     *
     * It is possible to create a Tupe with a list or array(1, 'foo', ...)
     * For performance reasons not every element is checked on default.
     *
     * @return boolean
     */
    public function isNumeric()
    {
        for ($i=0; $i < $this->getSize(); $i++) {
            if (!is_numeric($this->data[$i])) {
                return false;
            }
        }
        return true;
    }

    /**
     * Returns an string representation of the tuple
     *
     * @return string
     */
    public function toString()
    {
        return "{ ".implode(", ", $this->data)." }";
    }

    /**
     * Returns an string representation of the tuple
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toString();
    }

    /**
     * Returns an HTML representation of the tuple
     *
     * @return string
     */
    public function toHTML()
    {
        $out = "<table border>\n\t<caption align=\"top\"><b>Vector</b></caption>\n";
        $out .= "\t<tr align=\"center\">\n\t\t<th>i</th><th>value</th>\n\t</tr>\n";
        for ($i=0; $i < $this->getSize(); $i++) {
            $out .= "\t<tr align=\"center\">\n\t\t<th>".$i."</th>";
            $out .= "<td bgcolor=\"#dddddd\">".$this->data[$i]."</td>\n\t</tr>\n";
        }
        return $out."\n</table>\n";
    }

}
