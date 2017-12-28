<?php

namespace InternetPixels\LoggingLibrary\Tests;

use InternetPixels\LoggingLibrary\Adapters\MysqlLoggerAdapter;
use InternetPixels\LoggingLibrary\Entities\ErrorLogEntity;
use InternetPixels\LoggingLibrary\Entities\LogEntity;
use InternetPixels\LoggingLibrary\Factory\LoggerFactory;
use mysqli;
use PHPUnit\Framework\TestCase;

/**
 * Class MysqlLoggerTest
 * @package InternetPixels\LoggingLibrary\Tests
 */
class MysqlLoggerTest extends TestCase {

	public function testInstance() {
		$mysqlAdapter = $this->getMockBuilder( MysqlLoggerAdapter::class )
			->disableOriginalConstructor()
			->setMethods( [ 'save' ] )
			->getMock();

		$logger = new LoggerFactory();
		$logger->setAdapter( $mysqlAdapter );

		$this->assertInstanceOf( LoggerFactory::class, $logger );
		$this->assertInstanceOf( MysqlLoggerAdapter::class, $logger->getAdapter() );
	}

	public function testSave() {
		$mysqliMock = $this->getMockBuilder( Mysqli::class )
			->disableOriginalConstructor()
			->setMethods( [ 'real_escape_string', 'query' ] )
			->getMock();

		$mysqliMock->expects( $this->exactly( 2 ) )
			->method( 'query' )
			->willReturn( true );

		$mysqlAdapter = new MysqlLoggerAdapter( $mysqliMock );

		$logger = new LoggerFactory();
		$logger->setAdapter( $mysqlAdapter );

		$errorLog = new ErrorLogEntity();
		$errorLog->setMessage( 'Test message' );
		$errorLog->setCreated( new \DateTime() );

		$result = $logger->save( $errorLog );
		$this->assertTrue( $result );
	}

	public function testGet() {
		$mysqliMock = $this->getMockBuilder( Mysqli::class )
			->disableOriginalConstructor()
			->setMethods( [ 'query', 'fetch_assoc' ] )
			->getMock();

		$mysqliMock->expects( $this->at( 2 ) )
			->method( 'fetch_assoc' )
			->willReturn( [
				'log_type'   => 'error',
				'priority'   => 50,
				'message'    => 'Lorem ipsum error message',
				'created'    => '2018-01-01 01:00:24',
				'ip_address' => '127.0.0.1',
			] );

		$mysqliMock->expects( $this->at( 3 ) )
			->method( 'fetch_assoc' )
			->willReturn( [
				'log_type'   => 'notice',
				'priority'   => 10,
				'message'    => 'Lorem ipsum notice message',
				'created'    => '2018-01-01 01:34:24',
				'ip_address' => '127.0.0.1',
			] );

		$mysqliMock->expects( $this->at( 0 ) )
			->method( 'query' )
			->willReturn( true );

		$mysqliMock->expects( $this->at( 1 ) )
			->method( 'query' )
			->will( $this->returnValue( $mysqliMock ) );

		$mysqlAdapter = new MysqlLoggerAdapter( $mysqliMock );

		$logger = new LoggerFactory();
		$logger->setAdapter( $mysqlAdapter );

		$result = $logger->get( 2 );
		$this->assertCount( 2, $result );
		$this->assertInstanceOf( LogEntity::class, $result[0] );
		$this->assertInstanceOf( LogEntity::class, $result[1] );
	}

	/**
	 * @expectedException \Exception
	 * @expectedExceptionMessage Could not create logging table: logging
	 */
	public function testSave_WITHOUT_table() {
		$mysqliMock = $this->getMockBuilder( Mysqli::class )
			->disableOriginalConstructor()
			->setMethods( [ 'query' ] )
			->getMock();

		$mysqliMock->expects( $this->once() )
			->method( 'query' )
			->willReturn( false );

		$mysqlAdapter = new MysqlLoggerAdapter( $mysqliMock );

		$logger = new LoggerFactory();
		$logger->setAdapter( $mysqlAdapter );

		$errorLog = new ErrorLogEntity();
		$errorLog->setMessage( 'Test message' );
		$errorLog->setCreated( new \DateTime() );

		$logger->save( $errorLog );
	}

}