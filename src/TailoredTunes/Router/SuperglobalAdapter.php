<?php

namespace TailoredTunes\Router;

abstract class SuperglobalAdapter {

	/**
	 * @var array
	 */
	private $storage;

	/**
	 * @param array $storage
	 */
	public function __construct(array &$storage) {
		$this->storage =& $storage;
	}

	/**
	 * @param string $key
	 * @param mixed  $value
	 *
	 * @return void
	 */
	public function set($key, $value) {
		$this->storage[$key] = $value;
	}

	/**
	 * @param string $key
	 * @param string $defaultValue
	 *
	 * @return mixed
	 */
	public function get($key, $defaultValue) {
		if (!$this->has($key)) {
			if (is_callable($defaultValue)) {
				return $defaultValue();
			}

			return $defaultValue;
		}

		return $this->storage[$key];
	}

	/**
	 * @param string $key
	 *
	 * @return boolean
	 */
	public function has($key) {
		return array_key_exists($key, $this->storage);
	}

	/**
	 * @return array
	 */
	public function getAll() {
		$copy = new \ArrayObject($this->storage);
		return $copy->getArrayCopy();
	}

}

?>
