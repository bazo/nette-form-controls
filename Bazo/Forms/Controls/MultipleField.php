<?php

namespace Bazo\Forms\Controls;


use Nette\Utils\Html;
use Nette\Forms\Controls\TextInput;
use Nette\Utils\Arrays;
use Nette\Application\UI\Form;

/**
 * multipleDateField
 *
 * @author Martin Bažík
 * @package Core
 */
class MultipleField extends TextInput
{

	/**
	 * Generates control's HTML element.
	 * @return Html
	 */
	public function getControl()
	{
		$fromControl = $this->getControlPart('from');
		$toControl	 = $this->getControlPart('to');

		$control			 = Html::el('span')->add($fromControl)->add($toControl)->class('range-input');
		$control->disabled	 = $this->disabled;
		return $control;
	}


	public function getControlPart($part)
	{
		$partControl			 = Html::el('input')->autocomplete('on');
		$partControl->name		 = $this->getHtmlName() . '[' . $part . ']';
		$partControl->disabled	 = $this->disabled;
		$partControl->id		 = $this->getHtmlId() . '-' . $part;
		if (isset($this->value[$part])) {
			$partControl->value($this->value[$part]);
		}

		return $partControl;
	}


	/**
	 * Sets control's value.
	 * @param  string
	 * @return TextBase  provides a fluent interface
	 */
	public function setValue($value)
	{
		$this->value = \is_array($value) ? $value : ['from' => NULL, 'to' => NULL];
		return $this;
	}


	/**
	 * Returns control's value.
	 * @return string
	 */
	public function getValue()
	{
		return $this->value;
	}


	public function loadHttpData()
	{
		$data	 = $this->getHttpData(Form::DATA_TEXT, '[]');
		$value	 = array(
			'from'	 => $data[0],
			'to'	 => $data[1]
		);
		$this->setValue($value);
	}


}
