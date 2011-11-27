<?php
//
// +----------------------------------------------------------------------+
// | PHP Version 5                                                        |
// +----------------------------------------------------------------------+
// | Copyright (c) 1997-2003 The PHP Group                                |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.0 of the PHP license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available at through the world-wide-web at                           |
// | http://www.php.net/license/2_02.txt.                                 |
// | If you did not receive a copy of the PHP license and are unable to   |
// | obtain it through the world-wide-web, please send a note to          |
// | license@php.net so we can mail you a copy immediately.               |
// +----------------------------------------------------------------------+
// | Authors: Jesus M. Castagnetto <jmcastagnetto@php.net>                |
// +----------------------------------------------------------------------+
//
// $Id$
//

require_once "PEAR.php";
require_once "Math/Tuple.php";
require_once "Math/VectorOp.php";

/**
 * General Vector class
 * Originally this class was part of NumPHP (Numeric PHP package)
 *
 * @author  Jesus M. Castagnetto <jmcastagnetto@php.net>
 * @version 1.0
 * @access  public
 * @package Math_Vector
 */

class Math_Vector
{

    /**
     * Math_Tuple object
     *
     * @var     object  Math_Tuple
     * @access  private
     * @todo Provide getter
     */
    public $_tuple = null;

    /**
     * Constructor for Math_Vector
     *
     * @param array|Math_Tuple|Math_Vector $data A Math_Tuple object, a Math_Vector object, or an array of numeric data
     *
     * @access  public
     * @return  object  Math_Vector (or PEAR_Error on error)
     * @see setData()
     */
    public function __construct($data = null)
    {
        if (!is_null($data)) {
            $this->setData($data);
        }
    }

    /**
     * Initializes the vector
     *
     * @param array|Math_Tuple|Math_Vector $data a Math_Tuple object, a Math_Vetctor object, or an array of numeric data
     *
     * @return  boolean|PEAR_Error TRUE on success, a PEAR_Error otherwise
     */
    public function setData($data)
    {
        if (is_array($data)) {
            $tuple = new Math_Tuple($data);
        } elseif (is_object($data) && strtolower(get_class($data)) == "math_tuple") {
            $tuple = $data;
        } else if (is_object($data) && strtolower(get_class($data)) == "math_vector") {
            $tuple = $data->getTuple();
        } else {
            return PEAR::raiseError('Cannot initialize, expecting an array, tuple or vector');
        }

        $this->_tuple = $tuple;

        return true;
    }


    /**
     * Returns an array of numbers
     *
     * @return array|PEAR_Error a numeric array on success, a PEAR_Error otherwise
     */
    public function getData()
    {
        if ($this->isValid()) {
            return $this->_tuple->getData();
        }

        return PEAR::raiseError('Vector has not been initialized');
    }

    /**
     * Checks if the vector has been correctly initialized
     *
     * @return  boolean
     */
    public function isValid()
    {
        return (!is_null($this->_tuple) && is_object($this->_tuple) &&
                strtolower(get_class($this->_tuple)) == "math_tuple");
    }

    /**
     * Returns the square of the vector's length
     *
     * @return  float
     */
    public function lengthSquared()
    {
        $n = $this->size();
        $sum = 0;
        for ($i=0; $i < $n; $i++) {
            $sum += pow($this->_tuple->getElement($i), 2);
        }
        return $sum;
    }

    /**
     * Returns the length of the vector
     *
     * @return  float
     */
    public function length()
    {
        return sqrt($this->lengthSquared());
    }

    /**
     * Returns the magnitude of the vector. Alias of length
     *
     * @return  float
     */
    public function magnitude()
    {
        return $this->length();
    }

    /**
     * Normalizes the vector, converting it to a unit vector
     *
     * @return  void
     */
    public function normalize()
    {
        $n = $this->size();
        $length = $this->length();
        for ($i=0; $i < $n; $i++) {
            $this->_tuple->setElement($i, $this->_tuple->getElement($i)/$length);
        }
    }

    /**
     * returns the Math_Tuple object corresponding to the vector
     *
     * @return  object  Math_Tuple
     */
    public function getTuple()
    {
        return $this->_tuple;
    }

    /**
     * Returns the number of elements (dimensions) of the vector
     *
     * @return  float
     */
    public function size()
    {
        return $this->_tuple->getSize();
    }

    /**
     * Reverses the direction of the vector negating each element
     *
     * @return  void
     */
    public function reverse()
    {
        $n = $this->size();
        for ($i=0; $i < $n; $i++)
            $this->_tuple->setElement($i, -1 * $this->_tuple->getElement($i));
    }

    /**
     * Conjugates the vector. Alias of reverse.
     *
     * @return  void
     *
     * @see     reverse()
     */
    public function conjugate()
    {
        $this->reverse();
    }

    /**
     * Scales the vector elements by the given factor
     *
     * @param float $f scaling factor
     *
     * @return  mixed   void on success, a PEAR_Error object otherwise
     */
    public function scale($f)
    {
        if (!is_numeric($f)) {
            return PEAR::raiseError("Requires a numeric factor and a Math_Vector object");
        }

        $n = $this->size();
        $t = $this->getTuple();

        for ($i=0; $i < $n; $i++) {
            $this->set($i, $this->get($i) * $f);
        }
    }

    /**
     * Sets the value of a element
     *
     * @param integer $i     the index of the element
     * @param numeric $value the value to assign to the element
     *
     * @return  mixed   true on success, a PEAR_Error object otherwise
     */
    public function set($i, $value)
    {
        $res = $this->_tuple->setElement($i, $value);
        if (PEAR::isError($res)) {
            return $res;
        }

        return true;
    }

    /**
     * Gets the value of a element
     *
     * @param integer $i the index of the element
     *
     * @return  mixed   the element value (numeric) on success, a PEAR_Error object otherwise
     */
    public function get($i) {
        return $this->_tuple->getElement($i);
    }

    /**
     * Returns the distance to another vector
     *
     * @param   Math_Vector  $vector Math_Vector object
     * @param   string  $type   distance type: cartesian (default), manhattan or chessboard
     *
     * @return  float on success, a PEAR_Error object on failure
     */
    public function distance(Math_Vector $vector, $type = 'cartesian')
    {
        switch ($type) {
        case 'manhattan':
        case 'city':
            return $this->manhattanDistance($vector);

        case 'chessboard':
            return $this->chessboardDistance($vector);

        case 'cartesian':
        default:
            return $this->cartesianDistance($vector);
        }
    }

    /**
     * Returns the cartesian distance to another vector
     *
     * @access  public
     * @param   object  $vector Math_Vector object
     * @return  float on success, a PEAR_Error object on failure
     */
    public function cartesianDistance($vector)
    {
        $n = $this->size();
        $sum = 0;
        if (!Math_VectorOp::isVector($vector)) {
            return PEAR::raiseError("Wrong parameter type, expecting a Math_Vector object");
        }

        if ($vector->size() != $n) {
            return PEAR::raiseError("Vector has to be of the same size");
        }

        for ($i=0; $i < $n; $i++) {
            $sum += pow(($this->_tuple->getElement($i) - $vector->_tuple->getElement($i)), 2);
        }

        return sqrt($sum);
    }

    /**
     * Returns the Manhattan (aka City) distance to another vector
     * Definition: manhattan dist. = |x1 - x2| + |y1 - y2| + ...
     *
     * @param   Math_Vector  $vector Math_Vector object
     *
     * @return  float on success, a PEAR_Error object on failure
     */
    public function manhattanDistance(Math_Vector $vector)
    {
        if (!Math_VectorOp::isVector($vector)) {
            return PEAR::raiseError("Wrong parameter type, expecting a Math_Vector object");
        }
        $n = $this->size();

        if ($vector->size() != $n) {
            return PEAR::raiseError("Vector has to be of the same size");
        }

        $sum = 0;
        for ($i=0; $i < $n; $i++) {
            $sum += abs($this->_tuple->getElement($i) - $vector->_tuple->getElement($i));
        }

        return $sum;
    }

    /**
     * Returns the Chessboard distance to another vector
     * Definition: chessboard dist. = max(|x1 - x2|, |y1 - y2|, ...)
     *
     * @param Math_Vector $vector Math_Vector object
     *
     * @return  float on success, a PEAR_Error object on failure
     */
    public function chessboardDistance(Math_Vector $vector)
    {
        if (!Math_VectorOp::isVector($vector)) {
            return PEAR::raiseError("Wrong parameter type, expecting a Math_Vector object");
        }

        $n = $this->size();
        if ($vector->size() != $n) {
            return PEAR::raiseError("Vector has to be of the same size");
        }

        $sum = 0;
        $cdist = array();
        for ($i=0; $i < $n; $i++) {
            $cdist[] = abs($this->_tuple->getElement($i) - $vector->_tuple->getElement($i));
        }
        return max($cdist);
    }

    /**
     * Returns a simple string representation of the vector
     *
     * @return  string
     */
    public function toString()
    {
        return "Vector: < ".implode(", ", $this->_tuple->getData())." >";
    }

    /**
     * Returns a simple string representation of the vector
     *
     * @return  string
     */
    public function __toString()
    {
        return $this->toString();
    }
}