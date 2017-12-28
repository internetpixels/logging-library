<?php

namespace InternetPixels\LoggingLibrary\Tests;

use InternetPixels\LoggingLibrary\Adapters\FileLoggerAdapter;
use InternetPixels\LoggingLibrary\Entities\ErrorLogEntity;
use InternetPixels\LoggingLibrary\Factory\LoggerFactory;
use PHPUnit\Framework\TestCase;

/**
 * Class LoggerFactoryTest
 * @package InternetPixels\LoggingLibrary\Tests
 */
class LoggerFactoryTest extends TestCase {

	public function testInstance() {
		$logger = new LoggerFactory();
		$logger->setAdapter( new FileLoggerAdapter() );

		$this->assertInstanceOf( LoggerFactory::class, $logger );
		$this->assertInstanceOf( FileLoggerAdapter::class, $logger->getAdapter() );
	}

	/**
	 * @expectedException \Exception
	 * @expectedExceptionMessage Logger adapter is missing, use the setAdapter!
	 */
	public function testSaveWithoutAdapter() {
		$wrongFactory = new LoggerFactory();

		$wrongFactory->save( $this->getErrorEntity() );
	}

	/**
	 * @expectedException \Exception
	 * @expectedExceptionMessage Logger adapter is missing, use the setAdapter!
	 */
	public function testGetWithoutAdapter() {
		$wrongFactory = new LoggerFactory();
		$wrongFactory->get( 5 );
	}

	/**
	 * @expectedException \Exception
	 * @expectedExceptionMessage Logger adapter is missing, use the setAdapter!
	 */
	public function testErrorWithoutAdapter() {
		$wrongFactory = new LoggerFactory();
		$wrongFactory->error( 'Test error message' );
	}

	/**
	 * @expectedException \Exception
	 * @expectedExceptionMessage Logger adapter is missing, use the setAdapter!
	 */
	public function testWarningWithoutAdapter() {
		$wrongFactory = new LoggerFactory();
		$wrongFactory->warning( 'Test warning message' );
	}

	/**
	 * @expectedException \Exception
	 * @expectedExceptionMessage Logger adapter is missing, use the setAdapter!
	 */
	public function testNoticegWithoutAdapter() {
		$wrongFactory = new LoggerFactory();
		$wrongFactory->notice( 'Test notice message' );
	}

	/**
	 * @expectedException \Exception
	 * @expectedExceptionMessage Logger adapter is missing, use the setAdapter!
	 */
	public function testInfoWithoutAdapter() {
		$wrongFactory = new LoggerFactory();
		$wrongFactory->warning( 'Test info message' );
	}

	/**
	 * @expectedException \Exception
	 * @expectedExceptionMessage Logger adapter is missing, use the setAdapter!
	 */
	public function testCustomWithoutAdapter() {
		$wrongFactory = new LoggerFactory();
		$wrongFactory->custom( 'Test info message' );
	}

	/**
	 * @return ErrorLogEntity
	 */
	private function getErrorEntity() {
		$errorLog = new ErrorLogEntity();
		$errorLog->setMessage( 'Test error' );
		$errorLog->setCreated( new \DateTime() );

		return $errorLog;
	}

}