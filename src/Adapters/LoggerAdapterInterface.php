<?php

namespace InternetPixels\LoggingLibrary\Adapters;

use InternetPixels\LoggingLibrary\Entities\LogEntity;

/**
 * Interface LoggerAdapterInterface
 * @package InternetPixels\LoggingLibrary\Adapters
 */
interface LoggerAdapterInterface {

	/**
	 * Save a log entity.
	 *
	 * @param LogEntity $logEntity
	 *
	 * @return mixed
	 */
	public function save( LogEntity $logEntity );

	/**
	 * Get the last n records.
	 *
	 * @param int $limit
	 *
	 * @return mixed
	 */
	public function get( $limit = 10 );

}