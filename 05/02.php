<?php

function getInitialStacks($filename)
{
	$fp = fopen($filename,'r');
	$aInitialStacks = [];
	$aLines = [];
	$continue=true;
	while(($line = fgets($fp, 2048)) && $continue)
	{
		$line = substr($line, 0, strlen($line)-1);

		if($line)
		{
			$aLines[]=$line;
		}
		else
		{
			$continue=false;
		}
		
	}
	$lines= count($aLines);
	$cols= (strlen($aLines[$lines-1])+1)/4;


	for($col=1;$col<=$cols;$col++)
	{
		$aInitialStacks[$col]=[];
		for($row=$lines-2; $row>=0; $row--)
		{
			$chr = $aLines[$row][(($col-1)*4)+1];
			if($chr!=' ')
				array_push($aInitialStacks[$col],$chr);
		}	
	}

	fclose($fp);
	return $aInitialStacks;
}
function getMoves($filename)
{

	$fp = fopen($filename,'r');
	$aInitialStacks = [];
	$aMoves = [];
	$startedMoves=false;
	while($line = fgets($fp, 2048))
	{
		if($startedMoves)
		{
			$aMoves[]=processMove($line);
		}
		if(!trim($line))
		{
			$startedMoves=true;
		}
		
	}

	fclose($fp);
	return $aMoves;
}
function nextMove($aMoves)
{
	foreach($aMoves as $move)
	{
		yield $move;
	}
}
function applyMove(&$aStacks, $move)
{
	$moving = array_slice($aStacks[$move['from']],-1*$move['qty']);
	$len = count($aStacks[$move['from']]);
	$aStacks[$move['from']] = array_slice($aStacks[$move['from']],0,$len - $move['qty']);
	foreach($moving as $item)
	{
		array_push($aStacks[$move['to']], $item);
	}

}
function processMove($sMove)
{
	preg_match('/move (\d+) from (\d+) to (\d+)/',$sMove, $matches);
	return [
		'qty'=>$matches[1],
		'from'=>$matches[2],
		'to'=>$matches[3]
	];

}


function printTopOfStacks($aStacks)
{
	foreach($aStacks as $a)
	{
		print array_pop($a);
	}
	print "\n";
}
function go($filename)
{
	$aStacks = getInitialStacks($filename);
	$aMoves = getMoves($filename);
	foreach($aMoves as $move)
	{
		applyMove($aStacks, $move);
	}
	printTopOfStacks($aStacks);
}


print "Example\n";
go('data/example.txt');
print "Input\n";
go('data/input.txt');

