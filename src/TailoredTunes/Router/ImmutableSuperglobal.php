<?php
namespace TailoredTunes\Router;

final class ImmutableSuperglobal extends SuperglobalAdapter {

	/**
	 * @param string $key
	 * @param mixed  $value
	 *
	 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
	 *
	 * @throws CannotWriteToImmutableSuperglobalException Cannot modify.
	 *
	 * @return void
	 */
	public function set($key, $value) {
		throw new CannotWriteToImmutableSuperglobalException();
	}

}

?>
