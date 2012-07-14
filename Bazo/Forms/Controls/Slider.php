<?php
namespace Bazo\Forms\Controls;

use Nette\Forms\Controls\BaseControl;
use Nette,
	Nette\Forms\IControl,
	Nette\Utils\Html,
	Nette\Forms\Form,
	Nette\Forms\Rule;

/**
 * Description of Slider
 *
 * @author martin.bazik
 */
class Slider extends BaseControl
{

	private
			$min,
			$max,
			//$defaultValue,
			$linkedElement,
			$linkedProperty,
			$units = '%',
			$increment,
			$linkedInput

	;

	public function __construct($caption = NULL, $min, $max)
	{
		$this->monitor('Nette\Forms\Form');
		parent::__construct($caption);
		$this->min = $min;
		$this->max = $max;
	}

	public function getMin()
	{
		return $this->min;
	}

	public function setMin($min)
	{
		$this->min = $min;
		return $this;
	}

	public function getMax()
	{
		return $this->max;
	}

	public function setMax($max)
	{
		$this->max = $max;
		return $this;
	}

	public function setLinkedElement($linkedElement, $property)
	{
		$this->linkedElement = $linkedElement;
		$this->linkedProperty = $property;
		return $this;
	}

	public function setUnits($units)
	{
		$this->units = $units;
		return $this;
	}

	public function setIncrement($increment)
	{
		$this->increment = $increment;
		return $this;
	}

	public function setLinkedInput($linkedInput)
	{
		$this->linkedInput = $linkedInput;
		return $this;
	}

	public function getControl()
	{
		$control = Html::el('div');

		$control->id = $this->getHtmlId();
		//$this->value = $this->value != null ? $this->value : $this->defaultValue;

		$slider = Html::el('div');
		$slider->class('slider');

		$slider->{'data-min'} = $this->min;
		$slider->{'data-max'} = $this->max;
		$slider->{'data-value'} = $this->value;
		$slider->{'data-step'} = $this->increment;
		$slider->{'data-units'} = $this->units;
		$slider->{'data-linkedinput'} = $this->linkedInput;

		$input = Html::el('input')->type('hidden')->value($this->value / 100);
		$input->name = $this->getHtmlName('value');
		$input->id = $this->getHtmlId() . '-value';

		$control->{'data-inputid'} = '#' . $input->id;
		if (isset($this->linkedElement))
		{
			$slider->{'data-linkedelement'} = $this->linkedElement;
			$slider->{'data-linkedproperty'} = $this->linkedProperty;
		}
		$valuePreview = Html::el('span');
		$valuePreview->id = $this->getHtmlId() . '-preview';
		$valuePreview->setText($this->value . $this->units);

		$slider->{'data-previewelement'} = '#' . $valuePreview->id;

		$control->add($slider);
		$control->add($input);
		$control->add($valuePreview);
		return $control;
	}

	/**
	 * Returns control's value.
	 * @return mixed
	 */
	public function getValue()
	{
		return (float) $this->value;
	}

}
