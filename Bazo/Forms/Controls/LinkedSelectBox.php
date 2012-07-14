<?php
namespace Bazo\Forms\Controls;

use Nette\Forms\Controls\SelectBox;

/**
 * LinkedSelectBox
 *
 * @author martin.bazik
 */
class LinkedSelectBox extends SelectBox
{

	private
			$linkedElement,
			$linkedProperty

	;

	public function setLinkedElement($linkedElement, $linkedProperty)
	{
		$this->linkedElement = $linkedElement;
		$this->linkedProperty = $linkedProperty;
		return $this;
	}

	public function getControl()
	{
		$control = parent::getControl();

		$control->{'data-linkedelement'} = $this->linkedElement;
		$control->{'data-linkedproperty'} = $this->linkedProperty;

		return $control;
	}

}