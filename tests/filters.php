<?php
require_once __DIR__ . '/test_case.php';

use Paddle\Filters;

class FiltersTest extends Test_Case {

	public function test_filter_expires()
	{
		$date = Filters::filter_expires(time());
		$this->assertEquals(date('Y-m-d'), $date);
	}
}