<?php

function getFile($filename)
{
	$fp = fopen($filename,'r');
	$aFile=[];
	while($line = fgets($fp, 2048))
	{
		//remove last "\n"
		$line = substr($line, 0,strlen($line)-1);
		$aFile[]=$line;
	}
	fclose($fp);
	return $aFile;
}
function go($filename)
{
	$aFile = getFile($filename);
}


print "Example\n";
go('data/example.txt');
print "Input\n";
go('data/input.txt');

