<?php

namespace InternetPixels\LoggingLibrary\Entities;

/**
 * Class WarningLogEntity
 * @package InternetPixels\LoggingLibrary\Entities
 */
class WarningLogEntity extends LogEntity {

	/**
	 * @var string
	 */
	protected $type = 'warning';

	/**
	 * @var int
	 */
	protected $priority = 30;

}