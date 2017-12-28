<?php

namespace InternetPixels\LoggingLibrary\Entities;

/**
 * Class NoticeLogEntity
 * @package InternetPixels\LoggingLibrary\Entities
 */
class NoticeLogEntity extends LogEntity {

	/**
	 * @var string
	 */
	protected $type = 'notice';

	/**
	 * @var int
	 */
	protected $priority = 20;

}