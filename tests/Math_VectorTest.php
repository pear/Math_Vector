<?php
require_once "Math/Vector.php";
require_once "Math/Vector2.php";
require_once "Math/Vector3.php";

require_once 'PHPUnit/Framework/TestCase.php';

class Math_VectorTest extends PHPUnit_Framework_TestCase {
	var $v;
	var $w;
	var $z;
	var $x;
	var $y;
	var $a;
	var $t;
	var $bad;

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

    function testTuple() {
        ob_start();
?>
Creating tuple
Math_Tuple Object
(
    [data] => Array
        (
            [0] => 2
            [1] => 3
            [2] => 4
        )

)
Tuple size: 3
Adding element value 7
Tuple size: 4
Tuple toString: { 2, 3, 4, 7 }
Setting element 1 to 11
Tuple toString: { 2, 11, 4, 7 }
Maximum element value: 11
Minimum element value: 2
Index of maximum value: 1
Index of minimum value: 0
Remove element 2
Tuple toString: { 2, 11, 7 }
Get element 2: 7
Get index of element value 11: 1
<?php
        $expected = ob_get_clean();

        ob_start();

        echo "Creating tuple\n";
        $t = new Math_Tuple(array(2,3,4));
        print_r($t);
        echo "Tuple size: ".$t->getSize()."\n";
        echo "Adding element value 7\n";
        $t->addElement(7);
        echo "Tuple size: ".$t->getSize()."\n";
        echo "Tuple toString: ".$t->toString()."\n";
        echo "Setting element 1 to 11\n";
        $t->setElement(1, 11);
        echo "Tuple toString: ".$t->toString()."\n";
        echo "Maximum element value: ".$t->getMax()."\n";
        echo "Minimum element value: ".$t->getMin()."\n";
        echo "Index of maximum value: ".$t->getMaxIndex()."\n";
        echo "Index of minimum value: ".$t->getMinIndex()."\n";
        echo "Remove element 2\n";
        $t->delElement(2);
        echo "Tuple toString: ".$t->toString()."\n";
        echo "Get element 2: ".$t->getElement(2)."\n";
        echo "Get index of element value 11: ".$t->getValueIndex(11)."\n";

        $result = ob_get_clean();

        $this->assertSame($expected, $result);

    }
}
