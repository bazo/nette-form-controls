<?php
namespace Bazo\Forms\Controls;
/**
 * CaptchaResult
 *
 * @author martin.bazik
 */
class CaptchaResult
{
	private 
		$result,
		$error
	;
	
	function __construct($result, $error = null)
	{
		$this->result = $result;
		$this->error = $error;
	}
	
	public function isOK()
	{
		return $this->result;
	}
	
	public function getError()
	{
		return $this->error;
	}
}