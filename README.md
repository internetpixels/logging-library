# Logging library for PHP
Log errors, warnings, notices, info and custom messages with this php logging library. Log into a file, or your MySQL database.

This is a open-source library. Please consider a link to this repository when you're actively using it.

[![License](https://camo.githubusercontent.com/cf76db379873b010c163f9cf1b5de4f5730b5a67/68747470733a2f2f6261646765732e66726170736f66742e636f6d2f6f732f6d69742f6d69742e7376673f763d313032)](https://github.com/internetpixels/session-manager)
[![Build Status](https://travis-ci.org/internetpixels/logging-library.svg?branch=master)](https://travis-ci.org/internetpixels/logging-library)
[![Maintainability](https://api.codeclimate.com/v1/badges/6416d529f70682c6afd5/maintainability)](https://codeclimate.com/github/internetpixels/logging-library/maintainability)

## Installation
Install this PHP logging library by using composer:

	composer require internetpixels/logging-library

## Basic examples

There are different kind of log messages available in this library. You can log the following messages:
	
	$logger     = new LoggerFactory();
	// set your adapter in the logger factory, see examples below
	
	$logger->error('Log an error message');
	$logger->warning('Log a warning message');
	$logger->notice('Log a notice message');
	$logger->info('Log an info message');
	$logger->custom('Log a custom message');

### Log by using the File adapter
The fastest way is logging into a file. You're able to do so with the File adapter. 

	$fileLogger = new \InternetPixels\LoggingLibrary\Adapters\FileLoggerAdapter();
    $logger     = new \InternetPixels\LoggingLibrary\Factory\LoggerFactory();
    $logger->setAdapter( $fileLogger );
    
    if( $logger->info('Test error')  ) {
    	echo 'Logged succesfully';
    }
    
### Log by using the MySQL adapter
If you want to manage your logging data better, you might want to use the MySQL database adapter. This adapter will create a logging table in your given MySQLi connection.

	$connection = new \Mysqli('localhost', 'root', 'yourpass', 'logger');
    
    $mysqlLogger = new \InternetPixels\LoggingLibrary\Adapters\MysqlLoggerAdapter( $connection );
    $logger     = new \InternetPixels\LoggingLibrary\Factory\LoggerFactory();
    $logger->setAdapter( $mysqlLogger );
    
    if( $logger->info('Test info')  ) {
    	echo 'Logged succesfully';
    }
