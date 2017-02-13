<?php
	namespace PhalApi\Cache;
	use PhalApi\Cache;
	
	/**
	 * None 空缓存 - NULL-Object空对象模式
	 *
	 * @package     PhalApi\Cache
	 * @license     http://www.phalapi.net/license GPL 协议
	 * @link        http://www.phalapi.net/
	 * @author      dogstar <chanzonghuang@gmail.com> 2015-02-04
	 */
	
	class None implements Cache {
		
		public function set( $key, $value, $expire = 600 ) {
		}
		
		public function get( $key ) {
			return null;
		}
		
		public function delete( $key ) {
		}
	}
