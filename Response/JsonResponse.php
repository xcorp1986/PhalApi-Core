<?php
	namespace PhalApi\Response;
	
	/**
	 * Json JSON响应类
	 *
	 * @package     PhalApi\Response
	 * @license     http://www.phalapi.net/license GPL 协议
	 * @link        http://www.phalapi.net/
	 * @author      dogstar <chanzonghuang@gmail.com> 2015-02-09
	 */
	class JsonResponse extends Response {
		
		public function __construct() {
			$this->addHeaders( 'Content-Type', 'application/json;charset=utf-8' );
		}
		
		/**
		 * @param array $result
		 *
		 * @return string
		 */
		protected function formatResult( $result ) {
			return json_encode( $result );
		}
		
	}
