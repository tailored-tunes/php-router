<?php
namespace TailoredTunes\Router;

class RequestParams {

	/**
	 * @var ImmutableSuperglobal;
	 */
	private $request;

	/**
	 * @var MutableSuperglobal;
	 */
	private $session;

	/**
	 * @var ImmutableSuperglobal;
	 */
	private $server;

	/**
	 * @var MutableSuperglobal;
	 */
	private $cookies;

	/**
	 * @var ImmutableSuperglobal;
	 */
	private $files;

	/**
	 * @var array
	 */
	private $extraParameters = [];

	/**
	 * @var ImmutableSuperglobal
	 */
	private $env;

	/**
	 * @param RequestParamBuilder $builder
	 */
	public function __construct(RequestParamBuilder $builder) {
		$this->request = $builder->request();
		$this->session = $builder->session();
		$this->server = $builder->server();
		$this->cookies = $builder->cookies();
		$this->files = $builder->files();
		$this->env = $builder->env();
	}

	/**
	 * @return ImmutableSuperglobal
	 */
	public function request() {
		return $this->request;
	}

	/**
	 * @return MutableSuperglobal
	 */
	public function session() {
		return $this->session;
	}

	/**
	 * @return ImmutableSuperglobal
	 */
	public function server() {
		return $this->server;
	}

	/**
	 * @return MutableSuperglobal
	 */
	public function cookies() {
		return $this->cookies;
	}

	/**
	 * @return ImmutableSuperglobal
	 */
	public function files() {
		return $this->files;
	}

	/**
	 * @return ImmutableSuperglobal
	 */
	public function env() {
		return $this->env;
	}

	/**
	 * @param string $key
	 * @param mixed  $value
	 *
	 * @return void
	 */
	public function add($key, $value) {
		$this->extraParameters[$key] = $value;
	}

	/**
	 * @param string $key
	 * @param mixed  $fallback
	 *
	 * @return mixed
	 */
	public function get($key, $fallback) {
		if (!$this->has($key)) {
			if (is_callable($fallback)) {
				return $fallback($key);
			}

			return $fallback;
		}

		return $this->extraParameters[$key];
	}

	/**
	 * @param string $key
	 *
	 * @return boolean
	 */
	public function has($key) {
		return array_key_exists($key, $this->extraParameters);
	}

}

?>
