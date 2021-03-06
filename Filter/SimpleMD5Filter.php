<?php
	namespace PhalApi\Filter;
	
	use PhalApi\Exception\BadRequest;
	use PhalApi\Translator\Translator;
	use function PhalApi\Helper\DI;
	
	/**
	 * SimpleMD5 简单的MD5拦截器
	 *
	 * - 签名的方案如下：
	 *
	 * + 1、排除签名参数（默认是sign）
	 * + 2、将剩下的全部参数，按参数名字进行字典排序
	 * + 3、将排序好的参数，全部用字符串拼接起来
	 * + 4、进行md5运算
	 *
	 * 注意：无任何参数时，不作验签
	 *
	 * @package     PhalApi\Filter
	 * @license     http://www.phalapi.net/license GPL 协议
	 * @link        http://www.phalapi.net/
	 * @author      dogstar <chanzonghuang@gmail.com> 2015-10-23
	 */
	class SimpleMD5Filter implements IFilter {
		
		protected $signName;
		
		public function __construct( $signName = 'sign' ) {
			$this->signName = $signName;
		}
		
		public function check() {
			$allParams = DI()->request->getAll();
			if ( empty( $allParams ) ) {
				return;
			}
			
			$sign = isset( $allParams[ $this->signName ] ) ? $allParams[ $this->signName ] : '';
			unset( $allParams[ $this->signName ] );
			
			$expectSign = $this->encryptAppKey( $allParams );
			
			if ( $expectSign != $sign ) {
				DI()->logger->debug( 'Wrong Sign', [ 'needSign' => $expectSign ] );
				throw new BadRequest( Translator::get( 'wrong sign' ), 6 );
			}
		}
		
		/**
		 * @param $params
		 *
		 * @return string
		 */
		protected function encryptAppKey( array $params ) {
			ksort( $params );
			
			$paramsStrExceptSign = '';
			foreach ( $params as $val ) {
				$paramsStrExceptSign .= $val;
			}
			
			return md5( $paramsStrExceptSign );
		}
	}
