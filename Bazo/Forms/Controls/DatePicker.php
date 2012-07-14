<?php
namespace Bazo\Forms\Controls;

use Nette\Forms\Controls\TextInput;

/**
 * DatePicker
 *
 * @author martin.bazik
 */
class DatePicker extends TextInput
{

	public function getControl()
	{
		$control = parent::getControl();
		$control->class = 'text datepicker';
		$control->autocomplete = 'off';
		return $control;
	}

}