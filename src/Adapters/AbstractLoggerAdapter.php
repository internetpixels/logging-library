<?php

namespace InternetPixels\LoggingLibrary\Adapters;

use InternetPixels\LoggingLibrary\Entities\LogEntity;

/**
 * Class AbstractLoggerAdapter
 * @package InternetPixels\LoggingLibrary\Adapters
 */
abstract class AbstractLoggerAdapter {

	/**
	 * @var string
	 */
	protected $format = '%datetime% | %type% | %message%';

	/**
	 * Build a log message from a log entity.
	 *
	 * @param LogEntity $logEntity
	 *
	 * @return string
	 */
	public function buildLogMessage( LogEntity $logEntity ) {
		$message = $this->format;
		$message = str_replace( '%datetime%', $logEntity->getCreated()->format( 'Y-m-d H:i:s' ), $message );
		$message = str_replace( '%type%', $logEntity->getType(), $message );
		$message = str_replace( '%message%', $logEntity->getMessage(), $message );

		return $message;
	}

}