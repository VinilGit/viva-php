<?php namespace ATDev\Viva;

/**
 * An abstract class which handles all requests to api
 */
abstract class RequestAbstract implements \JsonSerializable {

	/** @var string Request method, can be overriden at child classes if required*/
	protected $method = 'POST';
        
        protected $sourceCode;
        protected $amount;
        /** @var string Api password */
	protected $password;
        
        protected $isPreAuth;

        /** @var string Api url */
	private $url;
        protected $requestUrl;
        
                
	/** @var bool Test mode, "TEST" will be added to merchant id when sent to api */
	protected $testMode = false;
	/** @var string|null Error message, empty if no error, some text if any */
	private $error;
        
        protected $paymentsUrl = "/api/transactions";
        protected $paymentsCreateOrderUrl = "/api/orders";
        


	/**
	 * Sets api url
	 *
	 * @param string $url
	 *
	 * @return \ATDev\Viva\RequestAbstract
	 */
	public function setUrl($url) {

		$this->url = $url;

		return $this;
	}
                  
        /**
	 * Gets base url
	 *
	 * @return string
	 */
        public function getUrl()
	{
            if (empty($this->url)) {
                return $this->test_mode ? "https://demo.vivapayments.com" : "https://www.vivapayments.com";
            } else {
                return $this->url;
            }
	}
        
        /**
	 * Gets full api url for the request
	 *
	 * @return string
	 */
	protected function getRequestUrl() {
            return $this->url;
	}

	/**
	 * Set api password
	 *
	 * @param string $password
	 *
	 * @return \ATDev\Viva\RequestAbstract
	 */
	public function setApiPassword($password) {

		$this->password = $password;

		return $this;
	}

	/**
	 * Gets password for the api
	 *
	 * @return string
	 */
	public function getApiPassword() {

		return $this->password;
	}
        
	/**
	 * Sets test mode
	 *
	 * @param bool $testMode
	 *
	 * @return \ATDev\Viva\RequestAbstract
	 */
	public function setTestMode($testMode) {

		$this->testMode = $testMode;

		return $this;
	}

	/**
	 * Gets test mode
	 *
	 * @return bool
	 */
	public function getTestMode() {

		return $this->testMode;
	}
        
        /**
	 * Sets order amount
	 *
	 * @param string $amount
	 *
	 * @return \ATDev\Viva\Order
	 */
	public function setAmount($amount) {

		$this->amount = $amount;

		return $this;
	}
        
        /**
	 * Gets test mode
	 *
	 * @return string
	 */
	public function getAmount() {

		return $this->amount;
	}
        
        /**
	 * Sets sourceCode
	 *
	 * @param object $sourceCode
	 *
	 * @return \ATDev\Viva\RequestAbstract
	 */
	public function setSourceCode($sourceCode) {

		$this->sourceCode = $sourceCode;

		return $this;
	}

	/**
	 * Gets sourceCode
	 *
	 * @return object
	 */
	public function getSourceCode() {

		return $this->sourceCode;
	}
  
        /**
	 * Sets order isPreAuth
	 *
	 * @param bool $isPreAuth
	 *
	 * @return \ATDev\Viva\Order
	 */
	public function setIsPreAuth($isPreAuth) {

		$this->isPreAuth = $isPreAuth;

		return $this;
	}
        
	/**
	 * Gets order isPreAuth
	 *
	 * @return bool
	 */
	public function getIsPreAuth() {

		return $this->isPreAuth;
	}
        
	/**
	 * Gets error
	 *
	 * @return string
	 */
	public function getError() {

		return $this->error;
                
	}
              
        /**
	 * Sends request to api
	 *
	 * @return \ATDev\Viva\RequestAbstract
	 */
	public function send() {
            
		return $this->ExecuteCall($this->getRequestUrl(), $this->getApiPassword());
                
	}
        
      

        
	protected function ExecuteCall($postUrl, $password){

            $postargs=json_encode($this);

            // Get the curl session object
            $session = curl_init($postUrl);

            // Set the POST options.
            curl_setopt($session, CURLOPT_POST, true);
            curl_setopt($session, CURLOPT_POSTFIELDS, $postargs);
            curl_setopt($session, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($postargs))
            );
            curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($session, CURLOPT_USERPWD, $password);
            curl_setopt($session, CURLOPT_SSL_CIPHER_LIST, 'TLSv1');

            curl_setopt($session, CURLOPT_HEADER, true);

            // Do the POST and then close the session
            $response = curl_exec($session);

            // Separate Header from Body
            $header_len = curl_getinfo($session, CURLINFO_HEADER_SIZE);
            $resHeader = substr($response, 0, $header_len);
            $resBody =  substr($response, $header_len);

            // Parse the JSON response
            if(is_object(json_decode($resBody))){
                    $resultObj=json_decode($resBody);
            } else {
                    preg_match('#^HTTP/1.(?:0|1) [\d]{3} (.*)$#m', $resHeader, $match);

                    curl_close($session);
                    $this->error = trim($match[1]);

                    return $this;
            }

            curl_close($session);
            return $resultObj;
	}
}