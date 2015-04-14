<?php

namespace Bazo\Forms\Controls;


use Nette\Utils\Html;

/**
 * multipleDateField
 *
 * @author Martin Bažík
 * @package Core
 */
class MultipleDateField extends MultipleField
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
		$partControl			 = Html::el('input')->class('datepicker')->autocomplete('on');
		$partControl->name		 = $this->getHtmlName() . '[' . $part . ']';
		$partControl->disabled	 = $this->disabled;
		$partControl->id		 = $this->getHtmlId() . '-' . $part;
		if (isset($this->value[$part])) {
			$from = $this->value[$part];
			if ($from instanceof \DateTime) {
				$partControl->value($this->value[$part]->format('d.m.Y'));
			} else {
				$partControl->value($this->value[$part]);
			}
		}

		return $partControl;
	}


	/**
	 * Loads HTTP data.
	 * @return void
	 */
	/*
	  public function loadHttpData()
	  {
	  $path = \explode('[', \strtr(\str_replace(array('[]', ']'), '', $this->getHtmlName()), '.', '_'));

	  $origValue = Arrays::get($this->getForm()->getHttpData(), $path);

	  $from = isset($origValue['from']) ? $origValue['from'] : '';
	  $to = isset($origValue['to']) ? $origValue['to'] : '';
	  $value = array(
	  'from' => $from,
	  'to' => $to
	  );
	  //		/var_dump($value);exit;
	  $this->setValue($value);
	  }
	 *
	 */
}
