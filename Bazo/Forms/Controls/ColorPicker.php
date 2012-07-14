<?php
namespace Bazo\Forms\Controls;

use Nette\Forms\Controls\BaseControl;
use Nette,
	Nette\Forms\IControl,
	Nette\Utils\Html,
	Nette\Forms\Form,
	Nette\Forms\Rule;

/**
 * Description of ColorPicker
 *
 * @author martin.bazik
 */
class ColorPicker extends BaseControl
{

	private
			$side,
			$border,
			$defaultValue = '#000000',
			$linkedElement,
			$linkedProperty,
			$opacityConnect = false

	;

	public function __construct($caption = NULL, $side, $border)
	{
		$this->monitor('Nette\Forms\Form');
		parent::__construct($caption);

		$this->side = $side;
		$this->border = $border;
	}

	public function setLinkedElement($linkedElement, $property)
	{
		$this->linkedElement = $linkedElement;
		$this->linkedProperty = $property;
		return $this;
	}

	public function setOpacityConnect($opacityConnect)
	{
		$this->opacityConnect = $opacityConnect;
		return $this;
	}

	private function decodeRgb($rgb)
	{
		if (!is_object($rgb))
			return $rgb;
		else
			return sprintf('rgb(%s, %s, %s)', $rgb->r, $rgb->g, $rgb->b);
	}

	private function encodeRgb($rgb)
	{
		if (!is_object($rgb))
			return $rgb;
		return json_encode($rgb);
	}

	/**
	 * Generates control's HTML element.
	 * @return Nette\Utils\Html
	 */
	public function getControl()
	{
		$control = Html::el('div');
		$control->id = $this->getHtmlId();
		$rgb = $this->value;
		$this->value = $this->value != null ? $this->encodeRgb($this->value) : $this->encodeRgb($this->defaultValue);
		$control->style(sprintf('background-color: %s;', $this->decodeRgb($rgb)));
		$control->class('colorpicker');
		$control->{'data-defaultcolor'} = $this->value;
		$input = Html::el('input')->type('hidden');
		$input->value($this->encodeRgb($rgb));
		$input->name = $this->getHtmlName('color');
		$input->id = $this->getHtmlId() . '-color';

		$control->{'data-inputid'} = '#' . $input->id;
		if (isset($this->linkedElement))
		{
			$control->{'data-linkedelement'} = $this->linkedElement;
			$control->{'data-linkedproperty'} = $this->linkedProperty;
		}
		$control->{'data-opacityconnect'} = (int) $this->opacityConnect;
		$control->add($input);
		return $control;
	}

	/**
	 * Returns control's value.
	 * @return mixed
	 */
	public function getValue()
	{
		return $this->value;
	}

}
