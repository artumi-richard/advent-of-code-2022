<?php

// A is Rock
// B is Paper
// C is Scissors

// X is Lose  1
// Y is Draw  2 
// Z is Win  3

// A win is worth 6
// A draw is worth 3
// A lose is worth 0


function getPointsForShape($letter)
{
	$a = [
		'A'=>1,
		'B'=>2,
		'C'=>3
	];
	return $a[$letter];
}
function outcomeForB($playA, $playB)
{
	if($playB=='X') //lose
	{
		if($playA=='A')
			return getPointsForShape('C');
		if($playA=='B')
			return getPointsForShape('A');
		if($playA=='C')
			return getPointsForShape('B');
	}

	if($playB=='Y') //draw
	{
		if($playA=='A')
			return getPointsForShape('A');
		if($playA=='B')
			return getPointsForShape('B');
		if($playA=='C')
			return getPointsForShape('C');
	}
	if($playB=='Z') //win
	{
		if($playA=='A')
			return getPointsForShape('B');
		if($playA=='B')
			return getPointsForShape('C');
		if($playA=='C')
			return getPointsForShape('A');
	}
}
function getPointsForPlay($letter)
{
	$a = [
		'X'=>0,
		'Y'=>3,
		'Z'=>6
	];
	return $a[$letter];
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
