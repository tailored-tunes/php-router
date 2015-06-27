<?php
namespace TailoredTunes\Router;

/**
 * @SuppressWarnings(PHPMD.TooManyMethods)
 */
class RequestParamBuilder {

	/**
	 * @var ImmutableSuperglobal
	 */
	private $request;

	/**
	 * @var MutableSuperglobal
	 */
	private $session;

	/**
	 * @var ImmutableSuperglobal
	 */
	private $server;

	/**
	 * @var MutableSuperglobal
	 */
	private $cookies;

	/**
	 * @var ImmutableSuperglobal
	 */
	private $files;

	/**
	 * @var ImmutableSuperglobal
	 */
	private $env;

	/**
	 * @return ImmutableSuperglobal
	 */
	public function request() {
		return $this->getData('request', 'withRequest');
	}

	/**
	 * @return MutableSuperglobal
	 */
	public function session() {
		return $this->getData('session', 'withSession');
	}

	/**
	 * @return ImmutableSuperglobal
	 */
	public function server() {
		return $this->getData('server', 'withServer');
	}

	/**
	 * @return MutableSuperglobal
	 */
	public function cookies() {
		return $this->getData('cookies', 'withCookies');
	}

	/**
	 * @return ImmutableSuperglobal
	 */
	public function files() {
		return $this->getData('files', 'withFiles');
	}

	/**
	 * @return ImmutableSuperglobal
	 */
	public function env() {
		return $this->getData('env', 'withEnv');
	}

	/**
	 * @param array $data
	 *
	 * @return RequestParamBuilder
	 */
	public function withRequest(array $data) {
		$this->request = new ImmutableSuperglobal($data);

		return $this;
	}

	/**
	 * @param array $data
	 *
	 * @return RequestParamBuilder
	 */
	public function withSession(array $data) {
		$this->session = new MutableSuperglobal($data);

		return $this;
	}

	/**
	 * @param array $data
	 *
	 * @return RequestParamBuilder
	 */
	public function withServer(array $data) {
		$this->server = new ImmutableSuperglobal($data);

		return $this;
	}

	/**
	 * @param array $data
	 *
	 * @return RequestParamBuilder
	 */
	public function withCookies(array $data) {
		$this->cookies = new MutableSuperglobal($data);

		return $this;
	}

	/**
	 * @param array $data
	 *
	 * @return RequestParamBuilder
	 */
	public function withFiles(array $data) {
		$this->files = new ImmutableSuperglobal($data);

		return $this;
	}

	/**
	 * @param array $data
	 *
	 * @return RequestParamBuilder
	 */
	public function withEnv(array $data) {
		$this->env = new ImmutableSuperglobal($data);

		return $this;
	}

	/**
	 * @param string $name
	 * @param string $setFunction
	 *
	 * @return SuperglobalAdapter
	 */
	private function getData($name, $setFunction) {
		if ($this->$name === null) {
			$emptyArray = [];
			call_user_func([$this, $setFunction], [$emptyArray]);
		}

		return $this->$name;
	}

}

?>
