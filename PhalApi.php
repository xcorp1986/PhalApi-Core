<?php
	namespace PhalApi;
	
	use PhalApi\Api\ApiFactory;
	use PhalApi\Exception\BaseException;
	use function PhalApi\Helper\DI;
	
	/**
	 * PhalApi 应用类
	 *
	 * - 实现远程服务的响应、调用等操作
	 *
	 * <br>使用示例：<br>
	 * ```
	 * $api = new PhalApi();
	 * $rs = $api->response();
	 * $rs->output();
	 * ```
	 *
	 * @package     PhalApi
	 * @license     http://www.phalapi.net/license GPL 协议
	 * @link        http://www.phalapi.net/
	 * @author      dogstar <chanzonghuang@gmail.com> 2014-12-17
	 */
	class PhalApi {
		
		const VERSION = '1.3.5';
		
		/**
		 * 响应操作
		 *
		 * 通过工厂方法创建合适的控制器，然后调用指定的方法，最后返回格式化的数据。
		 * @return mixed 根据配置的或者手动设置的返回格式，将结果返回
		 *  其结果包含以下元素：
		 * ```
		 * array(
		 * 'ret'   => 200,                //服务器响应状态
		 * 'data'  => array(),            //正常并成功响应后，返回给客户端的数据
		 * 'msg'   => '',                //错误提示信息
		 * );
		 * ```
		 * @throws \Exception
		 */
		public function response() {
			/**
			 * @var $rs \PhalApi\Response\Response
			 */
			$rs      = DI()->response;
			$service = DI()->request->get( 'service', 'Default.Index' );
			
			try {
				// 接口响应
				$api = ApiFactory::generateService();
				list( $apiClassName, $action ) = explode( '.', $service );
				$data = call_user_func( [ $api, $action ] );
				
				$rs->setData( $data );
			} catch ( BaseException $ex ) {
				// 框架或项目的异常
				$rs->setRet( $ex->getCode() );
				$rs->setMsg( $ex->getMessage() );
			} catch ( \Exception $ex ) {
				// 不可控的异常
				DI()->logger->error( $service, strval( $ex ) );
				throw $ex;
			}
			
			return $rs;
		}
		
	}
