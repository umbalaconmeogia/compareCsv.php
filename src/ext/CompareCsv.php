<?php
/**
	    'csv1:' => '1st CSV file',
		'csv2:' => '2nd CSV file',
		'keyColumn:' => 'Index of key column, zero-based. Default is 0 (zero).',
		'compareColumn:' => 'Index of column to be compared, zero-based. Default is 1.',
		'outputCsv::' => 'Output of different values if exist. Default is "output.csv"',
		'separator::' => 'CSV separator character. Default to comma (,).',
		'nullEqualEmpty' => 'Allow string "NULL" and empty string are equal. Default to NO.',

 */
class CompareCsv
{
	private $config;

	public static $debug = FALSE;
	
	private $valuesOfKey = [];
	
	/**
	 * @param array $config
	 */
	public static function compare($config)
	{
		$compareCsv = new CompareCsv($config);
		$compareCsv->run();
		$compareCsv->output();
	}
	
	private function __construct($config)
	{
		$this->config = $config;
		print_r($config);
	}
	
	private function run()
	{
		$files = $this->config['files'];
		foreach ($files as $fileIndex => $file) {
		    CsvWithHeader::read($file, $this->config['separator'], function($csv) use($fileIndex) {
			    while ($csv->loadRow() !== FALSE) {
				    // Get attributes as an array.
				    $attr = $csv->getRowAsAttributes();
					$key = $attr[$this->config['keyColumn']];
					$value = $attr[$this->config['compareColumn']];
					if (!isset($this->valuesOfKey[$key])) {
						$this->valuesOfKey[$key] = new ValuesOfKey($key, $value);
					}
					$this->valuesOfKey[$key]->addValue($fileIndex, $value);
					if ($this->valuesOfKey[$key]->sameValues()) {
						$this->removeSameRow($key);
					}
			    }
		    });
		}
	}
	
	private function removeSameRow($key)
	{
		unset($this->valuesOfKey[$key]);
		if (self::$debug) {
			echo "Clear keyValue of key $key\n";
		}
	}
	
	private function output()
	{
		if (count($this->valuesOfKey)) {
			echo "The two CSV files are different.\n";
		} else {
			echo "The two CSV files are equal.\n";
		}
	}
}