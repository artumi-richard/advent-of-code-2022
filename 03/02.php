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
	$groupNumber = 0;
	$counter = 0;
	$aBags=[];
	while($line = trim(fgets($fp,2048)))
	{
		$iElf= $counter%3;
		$aBags[$iElf] = str_split($line);
		if($counter%3==2)
		{

			var_dump($aBags);
			$bagA= array_unique($aBags[0]);
			$bagB= array_unique($aBags[1]);
			$bagC= array_unique($aBags[2]);
			$aCommonToAAndB=[];

			foreach($bagB as $thing)
			{
				print "looking for $thing\n";
				$r = array_search($thing, $bagA);
				if($r!==false)
				{
					$aCommonToAAndB[]=$thing;
					continue;
				}

			}

			foreach($aCommonToAAndB as $thing)
			{
				$r = array_search($thing, $bagC);
				if($r!==false)
				{
					$total+=getPrio($thing);
					continue;
				}

			}

			$aBags=[];
			$groupNumber++;
		}
		$counter++;
	}
	print $total;

};
go();
