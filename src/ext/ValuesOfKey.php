<?php
class ValuesOfKey
{
	private $fileNum = 2;
	private $key;
	private $firstValue;
	private $valueSetFlags;
	private $values;
	
	public function __construct($key, $firstValue)
	{
		$this->key = $key;
		$this->firstValue = $firstValue;
		$this->valueSetFlags = array_pad([], $this->fileNum, FALSE);
		$this->values = array_pad([], $this->fileNum, NULL);
	}
	
	public function addValue($fileIndex, $value)
	{
		$this->valueSetFlags[$fileIndex] = TRUE;
		$this->values[$fileIndex] = $value;
	}
	
	/**
	 * Check wether all values are set and are same.
	 * @return boolean
	 */
	public function sameValues()
	{
		$result = TRUE;
		foreach ($this->values as $index => $value) {
			if (!$this->valueSetFlags[$index] || $value != $this->firstValue) {
				$result = FALSE;
				break;
			}
		}
		return $result;
	}
}