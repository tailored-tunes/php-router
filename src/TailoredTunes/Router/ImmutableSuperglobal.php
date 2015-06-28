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

	/**
	 * @param string $key
	 *
	 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
	 *
	 * @return void
	 * @throws CannotWriteToImmutableSuperglobalException Cannot modify.
	 */
	public function delete($key) {
		throw new CannotWriteToImmutableSuperglobalException();
	}

}

?>
