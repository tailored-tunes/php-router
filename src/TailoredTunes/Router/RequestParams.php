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
	 * @param RequestParamBuilder $builder
	 */
	public function __construct(RequestParamBuilder $builder) {
		$this->request = $builder->request();
		$this->session = $builder->session();
		$this->server = $builder->server();
		$this->cookies = $builder->cookies();
		$this->files = $builder->files();
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

}

?>
