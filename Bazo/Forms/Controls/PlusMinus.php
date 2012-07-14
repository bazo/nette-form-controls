<?php
namespace Bazo\Forms\Controls;

use Nette\Forms\Controls\BaseControl;
use Nette,
	Nette\Forms\IControl,
	Nette\Utils\Html,
	Nette\Forms\Form,
	Nette\Forms\Rule;

/**
 * Description of SizePicker
 *
 * @author martin.bazik
 */
class PlusMinus extends BaseControl
{

	private
			$min,
			$max,
			$defaultValue = 16,
			$linkedElement,
			$linkedProperty,
			$increment,
			$hideText = false

	;

	public function __construct($caption = NULL, $min, $max)
	{
		$this->monitor('Nette\Forms\Form');
		parent::__construct($caption);
		$this->min = $min;
		$this->max = $max;
	}

	public function setLinkedElement($linkedElement, $property)
	{
		$this->linkedElement = $linkedElement;
		$this->linkedProperty = $property;
		return $this;
	}

	public function setIncrement($increment)
	{
		$this->increment = $increment;
		return $this;
	}

	public function getControl()
	{
		$control = Html::el('div');

		$control->id = $this->getHtmlId();
		$this->value = $this->value != null ? $this->value : $this->defaultValue;

		$control->class('plusminus');
		$control->{'data-min'} = $this->min;
		$control->{'data-max'} = $this->max;
		$control->{'data-value'} = $this->value;
		$control->{'data-step'} = $this->increment;

		$input = Html::el('input')->type('hidden')->value($this->value);
		$input->name = $this->getHtmlName('value');
		$input->id = $this->getHtmlId() . '-value';

		$control->{'data-inputid'} = '#' . $input->id;
		if (isset($this->linkedElement))
		{
			$control->{'data-linkedelement'} = $this->linkedElement;
			$control->{'data-linkedproperty'} = $this->linkedProperty;
		}

		$plus = Html::el('span')->class('plus button small');
		if (!$this->hideText)
			$plus->add(Html::el('span')->setText('+'));
		$minus = Html::el('span')->class('minus button small');
		if (!$this->hideText)
			$minus->add(Html::el('span')->setText('-'));

		/*
		  $valuePreview = Html::el('span');
		  $valuePreview->id = $this->getHtmlId().'-preview';
		  $valuePreview->setText($this->value.$this->units);

		  $slider->{'data-previewelement'} = '#'.$valuePreview->id;
		 */
		$control->add($plus);
		$control->add($minus);
		$control->add($input);
		return $control;
	}

	public function hideText()
	{
		$this->hideText = true;
		return $this;
	}

	/**
	 * Returns control's value.
	 * @return mixed
	 */
	public function getValue()
	{
		return (int) $this->value;
	}

}