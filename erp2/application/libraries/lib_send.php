<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
header("Content-type:text/html; charset=UTF-8");

class Lib_send {

	const API_SEND_URL = 'http://sms.253.com/msg/send';
	//创蓝短信余额查询接口URL, 如无必要，该参数可不用修改
	const API_BALANCE_QUERY_URL = 'http://sms.253.com/msg/balance';
	const API_ACCOUNT = 'N416303_N8247501'; //创蓝账号 替换成你自己的账号
	const API_PASSWORD = 'pJEVTH457Qaeed'; //创蓝密码 替换成你自己的密码

	/**
	 * 发送短信
	 *
	 * @param string $mobile 		手机号码
	 * @param string $msg 			短信内容
	 * @param string $needstatus 	是否需要状态报告
	 */

	public function sendSMS($mobile, $msg, $needstatus = 1) {

		//创蓝接口参数
		$postArr = array(
			'un' => self::API_ACCOUNT,
			'pw' => self::API_PASSWORD,
			'msg' => $msg,
			'phone' => $mobile,
			'rd' => $needstatus
		);

		$result = $this->curlPost(self::API_SEND_URL, $postArr);
		return $result;
	}

	/**
	 * 查询额度
	 *
	 *  查询地址
	 */
	public function queryBalance() {

		//查询参数
		$postArr = array(
			'un' => self::API_ACCOUNT,
			'pw' => self::API_PASSWORD,
		);
		$result = $this->curlPost(self::API_BALANCE_QUERY_URL, $postArr);
		return $result;
	}

	/**
	 * 处理返回值
	 *
	 */
	public function execResult($result) {
		$result = preg_split("/[,\r\n]/", $result);
		return $result;
	}

	/**
	 * 通过CURL发送HTTP请求
	 * @param string $url  //请求URL
	 * @param array $postFields //请求参数
	 * @return mixed
	 */
	private function curlPost($url, $postFields) {
		$postFields = http_build_query($postFields);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
		$result = curl_exec($ch);
		curl_close($ch);
		return $result;
	}

	//魔术获取
	public function __get($name) {
		return $this->$name;
	}

	//魔术设置
	public function __set($name, $value) {
		$this->$name = $value;
	}

}