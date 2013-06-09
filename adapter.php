<?php

//The Adapter Design Pattern simply adapts one object’s interfaces to what another object
//expects.

class errorObject
{
	private $_error;
	public function __construct($error)
	{
		$this->_error = $error;
	}
	public function getError()
	{
		return $this->_error;
	}
}

class logToConsole
{
	private $_errorObject;
	public function __construct($errorObject)
	{
		$this->_errorObject = $errorObject;
	}
	public function write()
	{
		fwrite(fopen('log.csv', 'a'), $this->_errorObject->getError());
	}
}

/** create the new 404 error object **/
$error = new errorObject("404:Not Found");
/** write the error to the console **/
$log = new logToConsole($error);
$log->write();

class logToCSV
{
	const CSV_LOCATION = 'log.csv';
	private $_errorObject;
	public function __construct($errorObject)
	{
		$this->_errorObject = $errorObject;
	}
	public function write()
	{
		$line = "\n";
		$line .= $this->_errorObject->getErrorNumber();
		$line .= ',';
		$line .= $this->_errorObject->getErrorText();
		$line .= "\n";
		file_put_contents(self::CSV_LOCATION, $line, FILE_APPEND);
	}
}
//We adapt errorObject class to logToCSV class easy to consume, because it already expects methods getErrorNumber(), getErrorText(), but 
//class errorObject doesn't have them

class logToCSVAdapter extends errorObject
{
	private $_errorNumber, $_errorText;
	public function __construct($error)
	{
		parent::__construct($error);
		$parts = explode(':', $this->getError());
		$this->_errorNumber = $parts[0];
		$this->_errorText = $parts[1];
	}
	public function getErrorNumber()
	{
		return $this->_errorNumber;
	}
	public function getErrorText()
	{
		return $this->_errorText;
	}
}

/** create the new 404 error object adapted for csv **/
$error = new logToCSVAdapter("404:Not Found");
/** write the error to the csv file **/
$log = new logToCSV($error);
$log->write();
?>