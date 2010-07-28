<?php

/**
 * TimeSelect form control.
 *
 * @author     Roman Novák
 * @version    0.1
 */
class TimeSelect extends /*Nette\Forms\*/SelectBox
{
	protected $from = '00:00';
	protected $to = '23:59';
	protected $sequence = 1;
	
	/**
	 * @param  string  label
	 * @param  int  width of the control
	 * @param  int  maximum number of characters the user may enter
	 */
	public function __construct($label, $from = null, $to = null, $sequence = null, $default = null)
	{
		parent::__construct($label);
		$this->setRange($from, $to, $sequence, $default);
	}
	
	public function setRange($from = null, $to = null, $sequence = null, $default = null)
	{
		if(!empty($from)) {
			$this->from = $from;
		}
		if(!empty($to)) {
			$this->to = $to;
		}
		if(!empty($sequence)) {
			$this->sequence = $sequence;
		}

		$items = null === $default ? array() : array('' => $default);
		//$items = array();
		$step = 0;
		$toTime = strtotime($this->to);
		do {
			$item = date('G:i', strtotime($this->from . ' + ' . ($step * $this->sequence) . ' minutes'));
			$items[$item] = $item;
			$step++;
			//if(1000 === $step) {
				//die('oops');
			//}
		} while(strtotime($item) < $toTime);
		$this->items = $items;
	}
	
	public static function extend() {
		FormContainer::extensionMethod('FormContainer::addTimeSelect', array(__CLASS__, 'addTimeSelect'));
	}
	
	public static function addTimeSelect(FormContainer $sender, $name, $label, $from = null, $to = null, $sequence = null, $default = null)
	{
		return $sender[$name] = new self($label, $from, $to, $sequence, $default);
	}
}
