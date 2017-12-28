<?php

namespace InternetPixels\LoggingLibrary\Entities;

/**
 * Class CustomLogEntity
 * @package InternetPixels\LoggingLibrary\Entities
 */
class CustomLogEntity extends LogEntity {

	/**
	 * @var string
	 */
	protected $type = 'custom';

	/**
	 * @var int
	 */
	protected $priority = 5;

}