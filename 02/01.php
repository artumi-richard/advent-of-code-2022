<?php

// A is Rock
// B is Paper
// C is Scissors

// X is Rock  1
// Y is paper  2 
// Z is Scissors  3

// A win is worth 6
// A draw is worth 3
// A lose is worth 0


function getPointsForPlay($letter)
{
	$a = [
		'X'=>1,
		'Y'=>2,
		'Z'=>3
	];
	return $a[$letter];
}
function outcomeForB($playA, $playB)
{
	if($playA=='A' && $playB=='X')
		return 3;
	if($playA=='B' && $playB=='Y')
		return 3;
	if($playA=='C' && $playB=='Z')
		return 3;
	if($playA=='A' && $playB=='Z')
		return 0;
	if($playA=='B' && $playB=='X')
		return 0;
	if($playA=='C' && $playB=='Y')
		return 0;
	return 6;
}
$fp = fopen('data/input.txt','r');
//$fp = fopen('data/example.txt','r');
$total = 0;
while($line = trim(fgets($fp)))
{
	$playA = $line[0];
	$playB = $line[2];
	$total += getPointsForPlay($playB) + outcomeForB($playA, $playB);
		
}
print $total;
