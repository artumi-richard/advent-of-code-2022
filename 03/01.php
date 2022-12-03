<?php


global $conversion;
function makeConversion()
{
	global $conversion;
	for($i=1;$i<27; $i++)
	{
		$conversion[chr($i+96)]=$i;
	}
	$j=65-27;
	for($i=27;$i<53;$i++)
	{
		$conversion[chr($i+$j)]=$i;
	}

}
function getPrio($letter)
{
	global $conversion;
	return $conversion[$letter];
}

function go() {
	makeConversion();
	$fp = fopen('data/input.txt','r');
	$total = 0;
	while($line = trim(fgets($fp,2048)))
	{
		$len = strlen($line);
		$half = $len/2;
		if($half*2 !=$len)
		{
			die('uneven bag');
		}
		$bagA=[];
		for($i=0;$i<$half;$i++)
		{
			$bagA[]=$line[$i];
		}
		$bagB=[];
		for($i=$half; $i<$len; $i++)
		{
			$bagB[]=$line[$i];
		}
		$bagA= array_unique($bagA);
		$bagB= array_unique($bagB);

		foreach($bagB as $thing)
		{
			print "looking for $thing\n";
			$r = array_search($thing, $bagA);
			if($r!==false)
			{
				print "Found $thing adding ".getPrio($thing)."\n";
				$total+=getPrio($thing);
				continue;
			}
			
		}
	}
	print $total;

};
go();
