<?php

require_once "Math/Vector/Vector.php";
require_once "Math/Vector/Vector2.php";
require_once "Math/Vector/Vector3.php";
require_once "PHPUnit/PHPUnit.php";

class VectorCreationTest extends PHPUnit_TestCase {
	var $v;
	var $w;
	var $z;
	var $x;
	var $y;
	var $a;
	var $t;
	var $bad;

	function VectorCreationTest($name) {
		$this->PHPUnit_TestCase($name);
	}

	function setup() {
		$this->a = array(2,3,4);
		$this->t = new Math_Tuple(array(2,6,8));
		$this->v = new Math_Vector($this->a);
		$this->w = new Math_Vector($this->t);
		$this->z = new Math_Vector(new Math_Vector(range(2,5)));
		$this->y = new Math_Vector2(array(1,2));
		$this->x = new Math_Vector3(new Math_Tuple(array(1,0,1)));
		$this->bad = new Math_Vector("foo");
	}

	// Vector from array
	function testFromArray() {
		$this->assertTrue(Math_VectorOp::isVector($this->v) && $this->v->isValid());
	}

	//Vector from tuple
	function testFromTuple() {
		$this->assertTrue(Math_VectorOp::isVector($this->w) && $this->w->isValid());
	}

	function testFromVector() {
		$this->assertTrue(Math_VectorOp::isVector($this->z) && $this->z->isValid());
	}

	function test2DVector() {
		$this->assertTrue(Math_VectorOp::isVector2($this->y) && $this->y->isValid());
	}

	function test3DVector() {
		$this->assertTrue(Math_VectorOp::isVector3($this->x) && $this->x->isValid());
	}

	function testBadVector() {
		$this->assertTrue(Math_VectorOp::isVector($this->bad) && !$this->bad->isValid());
	}
	
	function testLength() {
		$l = number_format($this->v->length(), 8);
		$this->assertTrue($l == 5.38516481);
	}
	
	function testToString() {
		$this->assertTrue($this->v->toString() == "Vector: < 2, 3, 4 >");
	}

	function testNormalize() {
		$this->v->normalize();
		$this->assertTrue($this->v->length() == 1);
	}

	function testReverse() {
		$this->v->reverse();
		$this->assertTrue($this->v->toString() == "Vector: < -2, -3, -4 >");
	}
}

echo date("Y-m-d H:i:s")."\n";
echo "Vector creation and methods\n";

$suite = new PHPUnit_TestSuite('VectorCreationTest');
$result = PHPUnit::run($suite);
echo $result->toString();

?>
