<?php
/**
 * Get command line options.
 */
class CommandLineOptions
{
    /**
     * The php file name to run the command.This is used to display syntax.
     * @var string
     */
	private $command;

	protected $optionSamples = [
		'csv1' => '<csv1.csv>',
		'csv2' => '<csv2.csv>',
		'keyColumn' => '<keyColumn>',
		'compareColumn' => '<valueColumn>',
	];
	
	protected $defaultValues = [
		'outputCsv' => 'output.csv',
		'separator' => ',',
		'nullEqualEmpty' => FALSE,
	];

	protected $optionDefinitions = [
	    'csv1:' => '1st CSV file',
		'csv2:' => '2nd CSV file',
		'keyColumn:' => 'Index of key column, zero-based. Default is 0 (zero).',
		'compareColumn:' => 'Index of column to be compared, zero-based. Default is 1.',
		'outputCsv::' => 'Output of different values if exist. Default is "output.csv"',
		'separator::' => 'CSV separator character. Default to comma (,).',
		'nullEqualEmpty' => 'Allow string "NULL" and empty string are equal. Default to NO.',
	];

    /**
     * @var array
     */
	public $optionValues;
	
	public function __construct($command)
	{
		$this->command = $command;
		$this->optionValues = getopt('', array_keys($this->optionDefinitions));
		if (!$this->optionValues) {
			echo $this->helpString();
		} else {
			$this->optionValues += $this->defaultValues;
		}
	}

	private function commandRequiredParameters()
	{
		$str = [];
		foreach ($this->optionDefinitions as $option => $description) {
			$optionName = trim($option, ':');
			if ($this->isRequired($option, $optionName)) {
				$str[] = "--{$optionName}=" . $this->optionSamples[$optionName];
			}
		}
		return join(' ', $str);
	}
	
	/**
	 * @return boolean
	 */
	private function isRequired($longOpt, $optWithoutColon = NULL)
	{
		$optionName = $optWithoutColon ? $optWithoutColon : trim($option, ':');
		$required = str_replace($optionName, '', $longOpt);
		return $required == ':';
	}
	
	/**
	 * @return string
	 */
	public function helpString()
	{
		$str = [];
		$str[] = "php {$this->command} " . $this->commandRequiredParameters() . ' [options]';
		$str[] = "Parameters are";
		foreach ($this->optionDefinitions as $option => $description) {
			$optionName = trim($option, ':');
			$help = "  --$optionName";
			if ($this->isRequired($option, $optionName)) {
				$help .= ' [required]';
			}
			$help .= " $description";
			$str[] = $help;
		}
		$str = join("\n", $str);
		return $str;
	}
}