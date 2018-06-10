<?php
include('ext/CommandLineOptions.php');
include('ext/CsvWithHeader.php');
include('ext/ValuesOfKey.php');
include('ext/CompareCsv.php');

$commandOptions = new CommandLineOptions('compareCsv.php');
$config = $commandOptions->optionValues;
$config['files'] = [$config['csv1'], $config['csv2']];
$config['separator'] = "\t";
unset($config['csv1']);
unset($config['csv2']);

CompareCsv::compare($config);