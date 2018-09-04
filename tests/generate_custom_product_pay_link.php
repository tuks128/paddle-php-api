<?php

require_once __DIR__ . '/test_case.php';

class Generate_Custom_Product_Pay_Link extends Test_Case {

	private $title = 'test title';
	private $price = 10;
	private $image_url = 'http://example.com';
	private $webhook_url = 'http://example.com';

	public function test_valid_arguments() {
		$data = array(
			'return_url' => 'http://example.com',
			'locker_visible' => true,
			'quantity_variable' => true,
			'paypal_cancel_url' => 'http://example.com',
			'expires' => strtotime('10 December 2030'),
			'is_popup' => true,
			'parent_url' => 'http://example.com',
			'affiliates' => array(
				$this->affiliate_id => $this->affiliate_commission
			),
			'stylesheets' => array(
				$this->vendor_stylesheet_type => $this->vendor_stylesheet_identifier
			)
		);

		// check if valid paylink was returned by api
		$url = $this->api->generate_custom_product_pay_link($this->title, $this->price, $this->image_url, $this->webhook_url, $data);
		$this->assertEquals($url, filter_var($url, FILTER_VALIDATE_URL));
	}

	/**
	 * @dataProvider invalid_url_data_provider
	 */
	public function test_invalid_return_url($url) {
		$data = array(
			'return_url' => $url
		);

		$this->setExpectedException('InvalidArgumentException', \Paddle\Api::ERR_305, 305);
		$this->api->generate_custom_product_pay_link($this->title, $this->price, $this->image_url, $this->webhook_url, $data);
	}

	/**
	 * @dataProvider invalid_url_data_provider
	 */
	public function test_invalid_paypal_cancel_url($url) {
		$data = array(
			'paypal_cancel_url' => $url
		);

		$this->setExpectedException('InvalidArgumentException', \Paddle\Api::ERR_306, 306);
		$this->api->generate_custom_product_pay_link($this->title, $this->price, $this->image_url, $this->webhook_url, $data);
	}

	public function invalid_expires_data_provider() {
		return array(
			array('string'),
			array(true),
			array(false)
		);
	}

	/**
	 * @dataProvider invalid_expires_data_provider
	 */
	public function test_invalid_expires($expires) {
		$data = array(
			'expires' => $expires
		);

		$this->setExpectedException('InvalidArgumentException', \Paddle\Api::ERR_307, 307);
		$this->api->generate_custom_product_pay_link($this->title, $this->price, $this->image_url, $this->webhook_url, $data);
	}

	public function test_past_expires() {
		$data = array(
			'expires' => 100
		);

		$this->setExpectedException('InvalidArgumentException', \Paddle\Api::ERR_308, 308);
		$this->api->generate_custom_product_pay_link($this->title, $this->price, $this->image_url, $this->webhook_url, $data);
	}

	/**
	 * @dataProvider invalid_url_data_provider
	 */
	public function test_invalid_parent_url($url) {
		$data = array(
			'parent_url' => $url
		);

		$this->setExpectedException('InvalidArgumentException', \Paddle\Api::ERR_309, 309);
		$this->api->generate_custom_product_pay_link($this->title, $this->price, $this->image_url, $this->webhook_url, $data);
	}

	public function not_array_affiliates_data_provider() {
		return array(
			array('string'),
			array(true),
			array(false),
			array(1)
		);
	}

	/**
	 * @dataProvider not_array_affiliates_data_provider
	 */
	public function test_not_array_affiliates($affiliates) {
		$data = array(
			'affiliates' => $affiliates
		);

		$this->setExpectedException('InvalidArgumentException', \Paddle\Api::ERR_310, 310);
		$this->api->generate_custom_product_pay_link($this->title, $this->price, $this->image_url, $this->webhook_url, $data);
	}

	public function invalid_array_affiliates_data_provider() {
		return array(
			array(array(1))
		);
	}

	/**
	 * @dataProvider invalid_array_affiliates_data_provider
	 */
	public function test_invalid_array_affiliates($affiliates) {
		$data = array(
			'affiliates' => $affiliates
		);

		$this->setExpectedException('InvalidArgumentException', \Paddle\Api::ERR_311, 311);
		$this->api->generate_custom_product_pay_link($this->title, $this->price, $this->image_url, $this->webhook_url, $data);
	}

	public function not_array_stylesheets_data_provider() {
		return array(
			array('string'),
			array(true),
			array(false),
			array(1)
		);
	}

	/**
	 * @dataProvider not_array_stylesheets_data_provider
	 */
	public function test_not_array_stylesheets($stylesheets) {
		$data = array(
			'stylesheets' => $stylesheets
		);

		$this->setExpectedException('InvalidArgumentException', \Paddle\Api::ERR_312, 312);
		$this->api->generate_custom_product_pay_link($this->title, $this->price, $this->image_url, $this->webhook_url, $data);
	}

	public function invalid_array_stylesheets_data_provider() {
		return array(
			array(array(1))
		);
	}

	/**
	 * @dataProvider invalid_array_stylesheets_data_provider
	 */
	public function test_invalid_array_stylesheets($stylesheets) {
		$data = array(
			'stylesheets' => $stylesheets
		);

		$this->setExpectedException('InvalidArgumentException', \Paddle\Api::ERR_313, 313);
		$this->api->generate_custom_product_pay_link($this->title, $this->price, $this->image_url, $this->webhook_url, $data);
	}

	/**
	 * @dataProvider invalid_url_data_provider
	 */
	public function test_invalid_webhook_url($url) {
		$this->setExpectedException('InvalidArgumentException', \Paddle\Api::ERR_315, 315);
		$this->api->generate_custom_product_pay_link($this->title, $this->price, $this->image_url, $url, array());
	}

	public function test_forbidden_discountable() {
		$this->setExpectedException('InvalidArgumentException', \Paddle\Api::ERR_316, 316);
		$data = array(
			'discountable' => true
		);
		$this->api->generate_custom_product_pay_link($this->title, $this->price, $this->image_url, $this->webhook_url, $data);
	}

	public function test_forbidden_coupon_code() {
		$this->setExpectedException('InvalidArgumentException', \Paddle\Api::ERR_317, 317);
		$data = array(
			'coupon_code' => true
		);
		$this->api->generate_custom_product_pay_link($this->title, $this->price, $this->image_url, $this->webhook_url, $data);
	}

	public function test_forbidden_product_id() {
		$this->setExpectedException('InvalidArgumentException', \Paddle\Api::ERR_318, 318);
		$data = array(
			'product_id' => true
		);
		$this->api->generate_custom_product_pay_link($this->title, $this->price, $this->image_url, $this->webhook_url, $data);
	}

}
