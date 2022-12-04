<?php


/**
 * returns true if range A contains range B
 **/
function rangeContained($startA, $endA, $startB, $endB)
{
	return ($startA<=$startB && $endA>=$endB);
}


function go()
{

	$fp = fopen('data/input.txt','r');
	//$fp = fopen('data/example.txt','r');
	$total = 0;
	while($line = trim(fgets($fp)))
	{
		$aParts=explode(',',$line);
		$rangeA = explode('-', $aParts[0]);
		$rangeB = explode('-',$aParts[1]);
		if(rangeContained($rangeA[0], $rangeA[1], $rangeB[0], $rangeB[1])
			||
			rangeContained($rangeB[0], $rangeB[1], $rangeA[0], $rangeA[1]))
		{
			$total++;
		}
	}
	print $total;
}
go();
