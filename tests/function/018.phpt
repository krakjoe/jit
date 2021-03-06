--TEST--
Test load element longs
--SKIPIF--
<?php if (!extension_loaded("jitfu")) die("skip JITFu not loaded"); ?>
--FILE--
<?php
use JITFU\Context;
use JITFU\Type;
use JITFU\Signature;
use JITFU\Func;
use JITFu\Value;

$context = new Context();

$long  = new type(JIT_TYPE_LONG);
$longs = new Type($long, true);
$int   = new Type(JIT_TYPE_INT);

$function = new Func($context, new Signature($long, [$longs, $int]), function($args) {
	$this->doReturn(
		$this->doMul(
			$this->doLoadElem($args[0], $args[1]), $args[1]));	
});

/*
long function (long *n, long f) {
	return n[f] * f;
}
*/

$numbers = [0, 1, 2, 3, 4, 5];

var_dump(
	$function($numbers, 3),
	$function($numbers, 2),
	$function($numbers, 1));
?>
--EXPECT--
int(9)
int(4)
int(1)
