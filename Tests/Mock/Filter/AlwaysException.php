<?php
	
	
	namespace PhalApi\Tests\Mock\Filter;
	
	
	use PhalApi\Filter\IFilter;
	
	class AlwaysException implements IFilter {
		public function check() {
			throw new \Exception( 'just for test' );
		}
	}