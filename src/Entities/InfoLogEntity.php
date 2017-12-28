<?php

namespace InternetPixels\LoggingLibrary\Entities;

/**
 * Class InfoLogEntity
 * @package InternetPixels\LoggingLibrary\Entities
 */
class InfoLogEntity extends LogEntity {

	/**
	 * @var string
	 */
	protected $type = 'info';

	/**
	 * @var int
	 */
	protected $priority = 10;

}