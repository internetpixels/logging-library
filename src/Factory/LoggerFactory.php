<?php

namespace InternetPixels\LoggingLibrary\Factory;

use InternetPixels\LoggingLibrary\Adapters\LoggerAdapterInterface;
use InternetPixels\LoggingLibrary\Entities\CustomLogEntity;
use InternetPixels\LoggingLibrary\Entities\ErrorLogEntity;
use InternetPixels\LoggingLibrary\Entities\LogEntity;
use InternetPixels\LoggingLibrary\Entities\NoticeLogEntity;
use InternetPixels\LoggingLibrary\Entities\WarningLogEntity;

/**
 * Class LoggerFactory
 * @package InternetPixels\LoggingLibrary\Factory
 */
class LoggerFactory {

	/**
	 * @var LoggerAdapterInterface
	 */
	private $adapter;

	/**
	 * @return LoggerAdapterInterface
	 */
	public function getAdapter(): LoggerAdapterInterface {
		return $this->adapter;
	}

	/**
	 * @param LoggerAdapterInterface $adapter
	 */
	public function setAdapter( LoggerAdapterInterface $adapter ) {
		$this->adapter = $adapter;
	}

	/**
	 * Save a log entity
	 *
	 * @param LogEntity $logEntity
	 *
	 * @return bool
	 * @throws \Exception
	 */
	public function save( LogEntity $logEntity ) {
		if ( !$this->adapter instanceof LoggerAdapterInterface ) {
			throw new \Exception( 'Logger adapter is missing, use the setAdapter!' );
		}

		return $this->adapter->save( $logEntity );
	}

	/**
	 * Log an error message
	 *
	 * @param $message
	 *
	 * @return bool
	 * @throws \Exception
	 */
	public function error( $message ) {
		$logEntity = new ErrorLogEntity();
		$logEntity->setCreated( new \DateTime() );
		$logEntity->setMessage( $message );

		return $this->save( $logEntity );
	}

	/**
	 * Log an warning message
	 *
	 * @param $message
	 *
	 * @return bool
	 * @throws \Exception
	 */
	public function warning( $message ) {
		$logEntity = new WarningLogEntity();
		$logEntity->setCreated( new \DateTime() );
		$logEntity->setMessage( $message );

		return $this->save( $logEntity );
	}

	/**
	 * Log an notice message
	 *
	 * @param $message
	 *
	 * @return bool
	 * @throws \Exception
	 */
	public function notice( $message ) {
		$logEntity = new NoticeLogEntity();
		$logEntity->setCreated( new \DateTime() );
		$logEntity->setMessage( $message );

		return $this->save( $logEntity );
	}

	/**
	 * Log an info message
	 *
	 * @param $message
	 *
	 * @return bool
	 * @throws \Exception
	 */
	public function info( $message ) {
		$logEntity = new NoticeLogEntity();
		$logEntity->setCreated( new \DateTime() );
		$logEntity->setMessage( $message );

		return $this->save( $logEntity );
	}

	/**
	 * Log a custom message
	 *
	 * @param $message
	 *
	 * @return bool
	 * @throws \Exception
	 */
	public function custom( $message ) {
		$logEntity = new CustomLogEntity();
		$logEntity->setCreated( new \DateTime() );
		$logEntity->setMessage( $message );

		return $this->save( $logEntity );
	}

	/**
	 * Get the latest error messages
	 *
	 * @param int $limit
	 *
	 * @return LogEntity[]
	 * @throws \Exception
	 */
	public function get( $limit = 10 ) {
		if ( !$this->adapter instanceof LoggerAdapterInterface ) {
			throw new \Exception( 'Logger adapter is missing, use the setAdapter!' );
		}

		return $this->adapter->get( $limit );
	}

}