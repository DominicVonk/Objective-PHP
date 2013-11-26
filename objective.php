<?php
class Object {
	protected $data, $type;
	public function __construct() {
		$this->data = array();
		$this->type = "object";
	}
	public function __set($var, $val) {
		$this->data[$var] = $val;
	}
	public function type() {
		return $this->type;
	}
	public function __get($var) {
		if (!empty($this->data[$var])) {
			return $this->data[$var];
		}
		else {
			throw new Exception("Variable: '" . $var . "' doesn't exists.");
		}
	}
	public function isType($type, $then = null, $else = null) {
		if ($then !== null || $else !== null) {
			if ($else === null) {
				if ($this->type === $type){
					$then();
				}
			}
			else {
				if ($this->type === $type){
					$then();
				}
				else {
					$else();
				}
			}
		}
		else {
			return ($this->data === $val);
		}
	}
	public function length() {
		if (is_string($this->data)) {
			return new Number(strlen($this->data));
		}
		else {
			return new Number(count($this->data));
		}
	}
	public function __call($var, $args) {
		if (is_callable($this->data[$var])) {
			return call_user_func_array($this->data[$var], $args);
		}
		else {
			throw new Exception("Function: '" . $var . "' doesn't exists.");
		}
	}

	public function equals ($val, $then = null, $else = null) {
		if ($then !== null || $else !== null) {
			if ($else === null) {
				if ($this->data === $val){
					$then();
				}
			}
			else {
				if ($this->data === $val){
					$then();
				}
				else {
					$else();
				}
			}
		}
		else {
			return ($this->data === $val);
		}
	}

	public function __toString() {
		return strval($this->data);
	}

	public function set($val) {
		$this->data = $val;
	}
	protected function setType($val) {
		$this->type = $val;
	}
	public function get() {
		return $this->data;
	}
}

class Boolean extends Object {
	public function __construct($val) {
		parent::set($val);
		parent::setType("boolean");
	}
	public function isFalse($then = null, $else = null) {
		if ($then !== null || $else !== null) {
			if ($else === null) {
				if (parent::get() === false){
					$then();
				}
			}
			else {
				if (parent::get() === false){
					$then();
				}
				else {
					$else();
				}
			}
		}
		else {
			return (parent::get() === false);
		}
	}
	public function isTrue($then = null, $else = null) {
		if ($then !== null || $else !== null) {
			if ($else === null) {
				if (parent::get() === true){
					$then();
				}
			}
			else {
				if (parent::get() === true){
					$then();
				}
				else {
					$else();
				}
			}
		}
		else {
			return (parent::get() === true);
		}
	}
}
class Number extends Object {
	public function __construct($val) {
		parent::set(floatval($val));
		parent::setType("number");
	}
	public function add($by = 1) {
		return new Number(parent::get() + $by);
	}
	public function substract($by = 1) {
		return new Number(parent::get() - $by);
	}
	public function increment($by = 1){
		parent::set(parent::get() + $by);
		return new Number(parent::get());
	}
	public function decrement($by = 1){
		parent::set(parent::get() - $by);
		return new Number(parent::get());
	}
	public function power($pow) {
		return new Number(parent::get() ^ $pow);
	}
	public function root($root) {
		return new Number(parent::get() ^ 1/$root);
	}
	public function multiply($times) {
		return new Number(parent::get() * $times);
	}
	public function divide($of) {
		return new Number($of / parent::get());
	}
	public function divideFrom($from) {
		return new Number(parent::get() / $from);
	} 
	public function module($of) {
		return new Number($of % parent::get());
	}
	public function moduleFrom($from) {
		return new Number(parent::get() % $from);
	}
	public function round($decimals = 0) {
		return new Number(round(parent::get(), $decimals)+0);
	}
	public function floor($decimals = 0) {
		return new Number(floor(parent::get(), $decimals)+0);
	}
	public function count($func, $from = 0, $steps = 1) {
		for($i = $from; $i <= parent::get(); $i++) {
			$func(new Number($i));
			$i += $steps-1;
		}
	}
	public function countDown($func, $to = 0, $steps = 1) {
		for ($i = parent::get(); $i >= $to; $i--) {
			$func(new Number($i));
			$i -= $steps-1;
		}
	}
	public function ceil($decimals = 0) {
		return new Number(ceil(parent::get(), $decimals)+0);
	}
	public function parse($i) {
		parent::set(floatval($i));
	}
}
class String extends Object {
	public function __construct($val) {
		parent::setType("string");
		parent::set(strval($val));
	}
	public function replace($search, $replace, $ci = true, $times = 0) {
		if ($times <= 0) {
			if (!$ci) {
				return new String(str_replace($search, $replace, parent::get()));
			}
			else {
				return new String(str_ireplace($search, $replace, parent::get()));
			}
		}
		else {
			$value = parent::get();
			for ($i = 0; $i < $times; $i++) {
				if (!$ci) {
					if (($pos = strpos($value, $search)) !== false) {
						$value = substr_replace($value, $replace, $pos, strlen($search));
					}
				}
				else {
					if (($pos = stripos($value, $search)) !== false) {
						$value = substr_replace($value, $replace, $pos, strlen($search));
					}
				}
			}
			return new String($value);
		}
	}
	public function contains($search, $ci = true) {
		if (!$ci) { 
			return new Boolean(strpos(parent::get(), $search) !== false);
		}
		else {
			return new Boolean(stripos(parent::get(), $search) !== false);
		}
	}
	public function startsWith($search, $ci = true) {
		if (!$ci) { 
			return new Boolean(strpos(parent::get(), $search) === 0);
		}
		else {
			return new Boolean(stripos(parent::get(), $search) === 0);
		}
	}
	public function endsWith($search, $ci = true) {
		if (!$ci) { 
			return new Boolean((strpos(parent::get(), $search, (strlen(parent::get()) - strlen($search))) === (strlen(parent::get()) - strlen($search))));
		}
		else {
			return new Boolean((stripos(parent::get(), $search, (strlen(parent::get()) - strlen($search))) === (strlen(parent::get()) - strlen($search))));
		}
	}
	public function prepend($str) {
		if ($str instanceof String) {
			$str = $str->get() . parent::get();
		}
		else {
			$str .= parent::get();
		}
		parent::set($str);
	}
	public function append($str) {
		if ($str instanceof String) {
			$str = parent::get() . $str->get();
		}
		else {
			$str = parent::get() . $str;
		}
		parent::set($str);
	}
	public function toLower() {
		return new String(strtolower(parent::get()));
	}
	public function toUpper() {
		return new String(strtoupper(parent::get()));
	}
	public function toCaptialize() {
		$val = parent::get();
		return new String(strtoupper($val[0]) . strtolower(substr($val,1)));
	}
	public function split($on, $limit = -1) {
		if ($limit === -1) {
			$func = explode($on, parent::get());
			$testObject = array();
			foreach ($func as $str) {
				array_push($testObject, new String($str));
			}
			return new ArrayList($testObject);
		}
		else {
			$func = explode($on, parent::get(), $limit);
			$testObject = array();
			foreach ($func as $str) {
				array_push($testObject, new String($str));
			}
			return new ArrayList($testObject);
		}
	}
	public function toCharArray() {
		$chars = array();
		for($i = 0; $i < strlen($this->value); $i++) {
			array_push($chars, substr($this->value, $i, 1));
		}
		return new ArrayList($chars);
	}
}

class ArrayList extends Object {
	public function __construct($var = null) {
		if (is_array($var)) {
			$vars = $var;
		}
		else {
			$vars = func_get_args();
		}
		parent::setType("arraylist");
		parent::set($vars);
	}
	public function getChild($i) {
		$v = parent::get();
		return $v[$i];
	}
	public function exists ($v) {
		foreach(parent::get() as $a) {
			if ($a == $v) {
				return new Boolean(true);
			}
		}
		return new Boolean(false);
	}
	public function push($v) {
		$a = parent::get();
		array_push($a, $v);
		parent::set($a);
	}
	public function removeAt($i) {
		$a = parent::get();
		unset($a[$i]);
		parent::set(array_values($a));
	}
	public function remove($val) {
		$a = parent::get();
		for($i = 0; $i < count($a); $i++) {
			if ($a[$i] == $val) {
				unset($a[$i]);
			}
		}
		parent::set(array_values($a));
	}
	public function each($v) {
		foreach(parent::get() as $value) {
			$v($value);
		}
	}
}
