<?php

namespace InternetPixels\LoggingLibrary\Adapters;

use InternetPixels\LoggingLibrary\Entities\CustomLogEntity;
use InternetPixels\LoggingLibrary\Entities\ErrorLogEntity;
use InternetPixels\LoggingLibrary\Entities\InfoLogEntity;
use InternetPixels\LoggingLibrary\Entities\LogEntity;
use InternetPixels\LoggingLibrary\Entities\NoticeLogEntity;
use InternetPixels\LoggingLibrary\Entities\WarningLogEntity;

/**
 * Class MysqlLoggerAdapter
 * @package InternetPixels\LoggingLibrary\Adapters
 */
class MysqlLoggerAdapter extends AbstractLoggerAdapter implements LoggerAdapterInterface {

	/**
	 * @var \Mysqli
	 */
	private $connection;

	/**
	 * @var string
	 */
	private $tableName = 'logging';

	/**
	 * MysqlLoggerAdapter constructor.
	 *
	 * @param \Mysqli $mysqli
	 * @param string  $tableName
	 */
	public function __construct( \Mysqli $mysqli, $tableName = 'logging' ) {
		$this->connection = $mysqli;
		$this->tableName  = $tableName;

		$this->validateDatabase();
	}

	/**
	 * Save a log entity.
	 *
	 * @param LogEntity $logEntity
	 *
	 * @return mixed
	 */
	public function save( LogEntity $logEntity ) {
		$query = 'INSERT INTO %s (created, log_type, message, priority, ip_address, url) VALUES ("%s","%s","%s",%d,"%s","%s")';
		$query = sprintf(
			$query,
			$this->tableName,
			$logEntity->getCreated()->format( 'Y-m-d H:i:s' ),
			$logEntity->getType(),
			$this->connection->real_escape_string( $logEntity->getMessage() ),
			$logEntity->getPriority(),
			$logEntity->getIp(),
			$this->connection->real_escape_string( $logEntity->getUrl() )
		);

		$result = $this->connection->query( $query );

		if ( $result === false ) {
			return false;
		}

		return true;
	}

	/**
	 * Get the last n records.
	 *
	 * @param int $limit
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	public function get( $limit = 10 ) {
		$query = "SELECT * FROM %s ORDER BY created DESC LIMIT %d";
		$query = sprintf( $query, $this->tableName, $limit );

		$result = $this->connection->query( $query );

		if ( $result === false ) {
			throw new \Exception( 'Could not fetch latest data from Mysql database table: ' . $this->tableName );
		}

		$results = [];

		while ( $row = $result->fetch_assoc() ) {
			if ( $row['log_type'] === 'error' ) {
				$logEntity = new ErrorLogEntity();
			} elseif ( $row['log_type'] === 'warning' ) {
				$logEntity = new WarningLogEntity();
			} elseif ( $row['log_type'] === 'notice' ) {
				$logEntity = new NoticeLogEntity();
			} elseif ( $row['log_type'] === 'info' ) {
				$logEntity = new InfoLogEntity();
			} else {
				$logEntity = new CustomLogEntity();
			}

			$logEntity->setType( $row['log_type'] );
			$logEntity->setPriority( $row['priority'] );
			$logEntity->setMessage( $row['message'] );
			$logEntity->setCreated( new \DateTime( $row['created'] ) );
			$logEntity->setIp( $row['ip_address'] );
			if ( !empty( $row['url'] ) ) {
				$logEntity->setUrl( $row['url'] );
			}
			if ( !empty( $row['http_method'] ) ) {
				$logEntity->setHttpMethod( $row['http_method'] );
			}

			$results[] = $logEntity;
		}

		return $results;
	}

	/**
	 * Create table if it isn't created.
	 */
	private function validateDatabase() {
		$query = "CREATE TABLE IF NOT EXISTS %s (
		  `created` datetime NOT NULL,
		  `log_type` varchar(100) NOT NULL,
		  `message` text NOT NULL,
		  `priority` tinyint(5) NOT NULL DEFAULT '10',
		  `ip_address` varchar(100) NOT NULL,
		  `url` varchar(250) NOT NULL,
		  `http_method` varchar(10) NOT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

		$query = sprintf( $query, $this->tableName );

		if ( $this->connection->query( $query ) === false ) {
			throw new \Exception( 'Could not create logging table: ' . $this->tableName );
		}
	}
}