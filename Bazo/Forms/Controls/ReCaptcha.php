<?php
namespace Bazo\Forms\Controls;

use Nette\Forms\Controls\BaseControl;
use Nette,
	Nette\Forms\IControl,
	Nette\Utils\Html,
	Nette\Forms\Form,
	Nette\Forms\Rule;
use Nette\Utils\Arrays;

/**
 * ReCaptcha
 *
 * @author martin.bazik
 */
class ReCaptcha extends BaseControl
{

	private
			$publicKey,
			$privateKey,
			$challenge,
			$response
	;

	public static
			$host = 'www.google.com',
			$port = 80,
			$path = '/recaptcha/api/verify'

	;

	public function __construct($caption, $publicKey, $privateKey)
	{
		$this->monitor('Nette\Forms\Form');
		parent::__construct($caption);
		$this->publicKey = $publicKey;
		$this->privateKey = $privateKey;
	}

	/*
	 * <script type="text/javascript"
	  src="http://www.google.com/recaptcha/api/challenge?k=your_public_key">
	  </script>
	  <noscript>
	  <iframe src="http://www.google.com/recaptcha/api/noscript?k=your_public_key"
	  height="300" width="500" frameborder="0"></iframe><br>
	  <textarea name="recaptcha_challenge_field" rows="3" cols="40">
	  </textarea>
	  <input type="hidden" name="recaptcha_response_field"
	  value="manual_challenge">
	  </noscript>

	 * 
	 * 
	 * 
	 * 
	 */

	public function getControl()
	{
		$container = Html::el('div')->class('reCaptcha');

		$script = Html::el('script')->src(sprintf('http://www.google.com/recaptcha/api/challenge?k=%s', $this->publicKey));

		//$container->add($script);
		//return $container;

		return $script;
	}

	public function loadHttpData()
	{
		$data = $this->getForm()->getHttpData();

		$this->challenge = $data['recaptcha_challenge_field'];
		$this->response = $data['recaptcha_response_field'];

		$this->value = $this->verify($this->challenge, $this->response);
	}

	private function _recaptcha_qsencode($data)
	{
		$req = "";
		foreach ($data as $key => $value)
			$req .= $key . '=' . urlencode(stripslashes($value)) . '&';

		// Cut the last '&'
		$req = substr($req, 0, strlen($req) - 1);
		return $req;
	}

	private function verify($challenge, $response)
	{
		$data = array(
			'privatekey' => $this->privateKey,
			'remoteip' => $this->getForm()->getPresenter()->getContext()->getService('httpRequest')->getRemoteAddress(),
			'challenge' => $challenge,
			'response' => $response
		);

		$host = 'www.google.com';
		$path = '/recaptcha/api/verify';
		$port = 80;

		$req = $this->_recaptcha_qsencode($data);

		$request = sprintf("POST %s HTTP/1.0\r\n", self::$path);
		$request .= sprintf("Host: %s\r\n", self::$host);
		$request .= "Content-Type: application/x-www-form-urlencoded;\r\n";
		$request .= "Content-Length: " . strlen($req) . "\r\n";
		$request .= "User-Agent: reCAPTCHA/PHP\r\n";
		$request .= "\r\n";
		$request .= $req;

		$response = '';
		if (false == ( $fs = fsockopen($host, $port, $errno, $errstr, 10) ))
		{
			die('Could not open socket');
		}

		fwrite($fs, $request);

		while (!feof($fs))
		{
			$response .= fgets($fs, 1160); // One TCP-IP packet
		}
		fclose($fs);
		$response = explode("\r\n\r\n", $response, 2);

		$answers = explode("\n", $response [1]);

		if (trim($answers [0]) == 'true')
		{
			$valid = true;
			$error = null;
		}
		else
		{
			$valid = false;
			$error = $answers [1];
		}

		return new CaptchaResult($valid, $error);
	}

	public function getValue()
	{
		return $this->value;
	}

}