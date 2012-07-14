<?php
namespace Bazo\Forms\Controls;
use Nette\Utils\Html;
use Nette\Forms\Controls\TextInput;
use Nette\Utils\Arrays;
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
		$fromControl = Html::el('input')->autocomplete('on');
		$fromControl->name = $this->getHtmlName().'[from]';
		$fromControl->disabled = $this->disabled;
		$fromControl->id = $this->getHtmlId().'-from';
		if(isset($this->value['from'])) $fromControl->value($this->value['from']);

		$toControl = Html::el('input')->autocomplete('on');
		$toControl->name = $this->getHtmlName().'[to]';
		$toControl->disabled = $this->disabled;
		$toControl->id = $this->getHtmlId().'-to';
		if(isset($this->value['to'])) $toControl->value($this->value['to']);


		$control = Html::el('span')->add($fromControl)->add($toControl)->class('range-input');
		$control->disabled = $this->disabled;
		return $control;
	}

	/**
	 * Sets control's value.
	 * @param  string
	 * @return TextBase  provides a fluent interface
	 */
	public function setValue($value)
	{
            $this->value = \is_array($value) ? $value : array('from' => null, 'to' => null);
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

        /**
	 * Loads HTTP data.
	 * @return void
	 */
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
		$this->setValue($value);
	}
}