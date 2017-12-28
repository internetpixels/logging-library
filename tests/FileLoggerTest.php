<?php

namespace InternetPixels\LoggingLibrary\Tests;

use InternetPixels\LoggingLibrary\Adapters\FileLoggerAdapter;
use InternetPixels\LoggingLibrary\Entities\ErrorLogEntity;
use InternetPixels\LoggingLibrary\Factory\LoggerFactory;
use PHPUnit\Framework\TestCase;

/**
 * Class FileLoggerTest
 * @package InternetPixels\SessionManager\Tests
 */
class FileLoggerTest extends TestCase {

	public function testInstance() {
		$fileAdapter = $this->getMockBuilder( FileLoggerAdapter::class )
			->disableOriginalConstructor()
			->setMethods( [ 'save' ] )
			->getMock();

		$logger = new LoggerFactory();
		$logger->setAdapter( $fileAdapter );

		$this->assertInstanceOf( LoggerFactory::class, $logger );
		$this->assertInstanceOf( FileLoggerAdapter::class, $logger->getAdapter() );
	}

	/**
	 * @expectedException \Exception
	 * @expectedExceptionMessage Logger adapter is missing, use the setAdapter!
	 */
	public function testSaveWithoutAdapter() {
		$wrongFactory = new LoggerFactory();

		$errorLog = new ErrorLogEntity();
		$errorLog->setCreated( new \DateTime() );

		$wrongFactory->save( $errorLog );
	}

	/**
	 * @expectedException \Exception
	 * @expectedExceptionMessage Logger adapter is missing, use the setAdapter!
	 */
	public function testGetWithoutAdapter() {
		$wrongFactory = new LoggerFactory();
		$wrongFactory->get( 5 );
	}

	public function testSaveErrorLog() {
		$fileAdapter = new FileLoggerAdapter();

		$logger = new LoggerFactory();
		$logger->setAdapter( $fileAdapter );

		$errorLog = new ErrorLogEntity();
		$errorLog->setCreated( new \DateTime() );
		$errorLog->setMessage( 'Some error message' );

		$result = $logger->save( $errorLog );
		$this->assertTrue( $result );
	}

	public function testQuickSave() {
		$fileAdapter = new FileLoggerAdapter();

		$logger = new LoggerFactory();
		$logger->setAdapter( $fileAdapter );

		$this->assertTrue( $logger->error( 'Test error message' ) );
		$this->assertTrue( $logger->warning( 'Test warning message' ) );
		$this->assertTrue( $logger->notice( 'Test notice message' ) );
	}

	public function testQuickSave_WITH_custom_path() {
		$fileAdapter = new FileLoggerAdapter( '/tmp/application-custom.log' );

		$logger = new LoggerFactory();
		$logger->setAdapter( $fileAdapter );

		$this->assertTrue( $logger->info( 'Test info message' ) );
		$this->assertTrue( $logger->custom( 'Test custom message' ) );
	}

	public function testBuildLogMessage() {
		$fileAdapter = new FileLoggerAdapter();

		$now = new \DateTime();

		$errorLog = new ErrorLogEntity();
		$errorLog->setCreated( $now );
		$errorLog->setMessage( 'Some error message' );

		$message = $fileAdapter->buildLogMessage( $errorLog );

		$this->assertEquals( $now->format( 'Y-m-d H:i:s' ) . ' | error | Some error message', $message );
	}

	public function testBuildLogMessage_WITH_customLogFormat() {
		$fileAdapter = new FileLoggerAdapter( '/tmp/application.log', '%datetime% | %message% | %type%' );

		$now = new \DateTime();

		$errorLog = new ErrorLogEntity();
		$errorLog->setCreated( $now );
		$errorLog->setMessage( 'Some error message' );

		$message = $fileAdapter->buildLogMessage( $errorLog );

		$this->assertEquals( $now->format( 'Y-m-d H:i:s' ) . ' | Some error message | error', $message );
	}

	public static function tearDownAfterClass() {
		unlink( '/tmp/application.log' );
		unlink( '/tmp/application-custom.log' );
	}

}