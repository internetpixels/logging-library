<?php

namespace InternetPixels\LoggingLibrary\Entities;

/**
 * Class LogEntity
 * @package InternetPixels\LoggingLibrary\Entities
 */
abstract class LogEntity {

	/**
	 * @var string
	 */
	protected $message;

	/**
	 * @var \DateTime
	 */
	protected $created;

	/**
	 * @var string
	 */
	protected $type;

	/**
	 * @var int
	 */
	protected $priority;

	/**
	 * @var string
	 */
	protected $url;

	/**
	 * @var string
	 */
	protected $ip;

	/**
	 * @var string
	 */
	protected $httpMethod;

	/**
	 * LogEntity constructor.
	 */
	public function __construct() {
		if ( !empty( $_SERVER['REMOTE_ADDR'] ) ) {
			$this->setIp( $_SERVER['REMOTE_ADDR'] );
		} else {
			$this->setIp( '127.0.0.1' );
		}

		if ( !empty( $_SERVER['REQUEST_URI'] ) ) {
			$this->setUrl( $_SERVER['REQUEST_URI'] );
		}
	}

	/**
	 * @return string
	 */
	public function getMessage(): string {
		return $this->message;
	}

	/**
	 * @param string $message
	 */
	public function setMessage( string $message ) {
		$this->message = $message;
	}

	/**
	 * @return \DateTime
	 */
	public function getCreated(): \DateTime {
		return $this->created;
	}

	/**
	 * @param \DateTime $created
	 */
	public function setCreated( \DateTime $created ) {
		$this->created = $created;
	}

	/**
	 * @return string
	 */
	public function getType(): string {
		return $this->type;
	}

	/**
	 * @param string $type
	 */
	public function setType( string $type ) {
		$this->type = $type;
	}

	/**
	 * @return int
	 */
	public function getPriority(): int {
		return $this->priority;
	}

	/**
	 * @param int $priority
	 */
	public function setPriority( int $priority ) {
		$this->priority = $priority;
	}

	/**
	 * @return string
	 */
	public function getUrl() {
		return $this->url;
	}

	/**
	 * @param string $url
	 */
	public function setUrl( string $url ) {
		$this->url = $url;
	}

	/**
	 * @return string
	 */
	public function getIp(): string {
		return $this->ip;
	}

	/**
	 * @param string $ip
	 */
	public function setIp( string $ip ) {
		$this->ip = $ip;
	}

	/**
	 * @return string
	 */
	public function getHttpMethod(): string {
		return $this->httpMethod;
	}

	/**
	 * @param string $httpMethod
	 */
	public function setHttpMethod( string $httpMethod ) {
		$this->httpMethod = $httpMethod;
	}

}