<?php

namespace InternetPixels\LoggingLibrary\Adapters;

use InternetPixels\LoggingLibrary\Entities\LogEntity;

/**
 * Class FileLoggerAdapter
 * @package InternetPixels\LoggingLibrary\Adapters
 */
class FileLoggerAdapter extends AbstractLoggerAdapter implements LoggerAdapterInterface {

	/**
	 * @var string
	 */
	private $path = '/tmp/application.log';

	/**
	 * LoggerFactory constructor.
	 *
	 * @param string $path Overwrite the default path
	 * @param string $format
	 */
	public function __construct( $path = '/tmp/application.log', $format = null ) {
		$this->path = $path;

		if ( !is_null( $format ) ) {
			$this->format = $format;
		}

		$this->validatePath();
	}

	/**
	 * Save a log entity.
	 *
	 * @param LogEntity $logEntity
	 *
	 * @return mixed
	 */
	public function save( LogEntity $logEntity ) {
		$result = file_put_contents( $this->path, $this->buildLogMessage( $logEntity ) . "\n", FILE_APPEND | LOCK_EX );

		if ( $result !== false ) {
			return true;
		}

		return false;
	}

	/**
	 * Get the last n records.
	 *
	 * @param int $limit
	 *
	 * @return mixed
	 */
	public function get( $limit = 10 ) {
		$result = [];
		$fp     = fopen( $this->path, 'r' );

		while ( !feof( $fp ) ) {
			$line = trim( fgets( $fp, 4096 ) );

			array_push( $result, $line );

			if ( count( $result ) > ( $limit + 1 ) ) {
				array_shift( $result );
			}
		}

		unset( $result[$limit] );

		fclose( $fp );

		return $result;
	}

	/**
	 * Validate the logging path
	 *
	 * @throws \Exception
	 */
	private function validatePath() {
		if ( empty( $this->path ) ) {
			throw new \Exception( 'The logging path is empty' );
		}

		if ( !is_writable( $this->path ) ) {
			if ( !touch( $this->path ) ) {
				throw new \Exception( 'The logging path is not writable!' );
			}
		}
	}

}