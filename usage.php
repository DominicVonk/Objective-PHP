<?php
include_once 'objective.php';

$hello = new String("hello people!");
echo $hello->toCaptialize() . "<br />";

$words = $hello->split(' ');
$words->each(function($word) { echo $word . "<br />"; });

$words->exists("hello")->isTrue(
	function() { /* if true */
		echo "YEAH it does contain hello";
	}, 
	function() { /* else */
		echo "No it doesn't contains hello :(";
	});
echo "<br />";

$hello->contains("people")->equals(true, 
	function() { /* if true */
		echo "It does contain people"; 
	},
	function () { /* else */
		echo "It doesn't contain people"; 
	});

echo "<br />";

$arrayList = new ArrayList("hello", "welcome", "to","objective", "php");
$arrayList->exists("hello")->isTrue(function() {
	global $arrayList;
	$arrayList->each(function($word) {
		if ($word == "hello") {
			$s = new String($word);
			echo $s->toCaptialize() . ",";
		}
		else {
			echo " " . $word;
		}
	});
	echo ".<br />";
});


$number = new Number(10);
$number->countDown(function($i) { echo $i->multiply(2) . " "; }, 0, 5);

?>
