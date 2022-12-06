<?php

function getFile($filename)
{
	$fp = fopen($filename,'r');
	$aFile=[];
	while($line = fgets($fp, 6000))
	{
		//remove last "\n"
		$line = substr($line, 0,strlen($line)-1);
		$aFile[]=$line;
	}
	fclose($fp);
	return $aFile;
}
function findRepeatingPattern($line)
{

	$len = strlen($line);
	$lenCheckingFor = 14;
	for($i=0;$i<$len-$lenCheckingFor; $i++)
	{
		$sub = substr($line, $i, $lenCheckingFor);
		$a=str_split($sub);
		$a=array_unique($a);
		if(count($a)==$lenCheckingFor)
			return $i+$lenCheckingFor;
	}
	return false;
}
function go($filename)
{
	$aFile = getFile($filename);
	$line = $aFile[0];
	$r = findRepeatingPattern($line);
	print $r."\n";


}


print "Example1 expecting 19 \n";
go('data/example1.txt');
print "Example2 expecting 23\n";
go('data/example2.txt');
print "Example3 expecting 23\n";
go('data/example3.txt');
print "Example4 expecting 29\n";
go('data/example4.txt');
print "Example5 expecting 26\n";
go('data/example5.txt');
print "Input\n";
go('data/input.txt');

