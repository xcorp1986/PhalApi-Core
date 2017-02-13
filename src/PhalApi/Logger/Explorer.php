<?php
	namespace PhalApi\Logger;
	
	use PhalApi\Logger;
	
	/**
	 * Explorer 直接输出日记到控制台的日记类
	 *
	 * - 测试环境下使用
	 *
	 * @package     PhalApi\Logger
	 * @license     http://www.phalapi.net/license GPL 协议
	 * @link        http://www.phalapi.net/
	 * @author      dogstar <chanzonghuang@gmail.com> 2015-02-09
	 */
	class Explorer extends Logger {
		
		public function log( $type, $msg, $data ) {
			$msgArr   = [];
			$msgArr[] = date( 'Y-m-d H:i:s', $_SERVER['REQUEST_TIME'] );
			$msgArr[] = strtoupper( $type );
			$msgArr[] = str_replace( PHP_EOL, '\n', $msg );
			if ( $data !== null ) {
				$msgArr[] = is_array( $data ) ? json_encode( $data ) : $data;
			}
			
			$content = implode( '|', $msgArr ) . PHP_EOL;
			
			echo "\n", $content, "\n";
		}
	}
