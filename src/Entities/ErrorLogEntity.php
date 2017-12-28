<?php

namespace InternetPixels\LoggingLibrary\Entities;

/**
 * Class ErrorLogEntity
 * @package InternetPixels\LoggingLibrary\Entities
 */
class ErrorLogEntity extends LogEntity {

	/**
	 * @var string
	 */
	protected $type = 'error';

	/**
	 * @var int
	 */
	protected $priority = 40;

}