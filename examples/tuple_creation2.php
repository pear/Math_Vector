<?php
/**
 * Test alternative parameters for Tuple creation
 *
 * old Tuple version:
 *      php5.6: Warnings with "false" tuples, errors on usage
 *      php8.3: PHP Fatal Error
 */
require_once "Math/Tuple.php";
echo "1. Creating empty tuple: ";
try{
    $t1 = new Math_Tuple();
    echo $t1->toString();
    echo " size: ".$t1->getSize()."\n";
} catch (Exception $e) {
    echo $e->getMessage();
}

echo "2. Creating tuple from list (2,3,4): ";
$t2 = new Math_Tuple(2,3,4);
echo $t2->toString();
echo " size: ".$t2->getSize()."\n";

echo "3. Creating tuple from array(5,6): ";
$a = array(5,6);
$t3 = new Math_Tuple($a);
$a[1] = 2;
echo $t3->toString();
echo " size: ".$t3->getSize()."\n";

echo "4. Creating tuple single element: ";
$t4 = new Math_Tuple(3);
echo $t4->toString();
echo " size: ".$t4->getSize()."\n";


echo "5. Creating tuple from 2.tuple: ";
try {
    $t5 = new Math_Tuple($t2);
    echo $t5->toString()."\n";
} catch (Exception $e) {
    echo $e->getMessage();
}
echo "Changing 2. tuple: ";
$t2->data[1] = 0;
echo $t2->toString()."\n";
echo "The 5. tuple is still: ";
echo $t5->toString()."\n";

echo "\n6. Not creating tuple with single string 'foo': ";
try {
    $t6 = new Math_Tuple('foo');
} catch (Exception $e) {
    echo $e->getMessage()."\n";
}

echo "7. Not creating tuple with some object not class Tuple: ";
class A
{
}
try {
    $t7 = new Math_Tuple(new A);
} catch (Exception $e) {
    echo $e->getMessage()."\n";
}

echo "8. Not creating tuple with mixed elements (array(4,5),2,3): ";
try {
    $t8 = new Math_Tuple(array(4,5),2,3);
} catch (Exception $e) {
    echo $e->getMessage()."\n";
}

echo "\n9. Creating tuple with non-numerics (4,'foo', 'bar', 5): ";
$t9 = new Math_Tuple(4, 'foo', 'bar', 5);
echo $t9->toString()."\n";
echo "is it numeric?: ";
if ($t9->isNumeric()) {
    echo " Yes!\n";
} else {
    echo " No!\n";
}

echo "A. Creating tuple with array(4,'foo', 'bar', 5): ";
$tA = new Math_Tuple(array(4, 'foo', 'bar', 5));
echo $tA->toString()."\n";
echo "is it numeric?: ";
if ($tA->isNumeric()) {
    echo " Yes!\n";
} else {
    echo " No!\n";
}

echo "\n";
?>
