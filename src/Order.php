<?php namespace ATDev\Viva;

/**
 * Order class
 */
class Order extends RequestAbstract  {
    
        protected $maxInstallments;

	/**
	 * Class constructor
	 *
	 * @param string $sourceCode Order sourceCode
         * @param string $password Order password
         * @param string $amount 
         * @param int $maxInstallments Order maxInstallments
	 * @param bool|null $isPreAuth 
	 */
	public function __construct($sourceCode, $password, $amount, $maxInstallments = 0, $isPreAuth = null) {

		$this->setSourceCode($sourceCode);
                $this->setApiPassword($password);
                $this->setAmount($amount);
                $this->setMaxInstallments($maxInstallments);

		if ( ! empty($isPreAuth)) {

			$this->setIsPreAuth($isPreAuth);
                        
		}
	}
        
        /**
	 * Gets full api url for the request
	 *
	 * @return string
	 */
	private function getRequestUrl() {
            return $this->url.$this->paymentsUrl;
	}

        /**
	 * Sets order maxInstallments
	 *
	 * @param int $maxInstallments
	 *
	 * @return \ATDev\Viva\Order
	 */
	public function setMaxInstallments($maxInstallments) {

		$this->maxInstallments = $maxInstallments;

		return $this;
	}

        /**
	 * Gets order maxInstallments
	 *
	 * @return string
	 */
	public function getMaxInstallments() {

		return $this->maxInstallments;
	}
        
	/**
	 * Specifies what has to be returned on serialization to json
	 *
	 * @return array Data to serialize
	 */
	public function jsonSerialize() {

		$result = [
			"SourceCode" => $this->sourceCode,
                        "Amount" => $this->amount,
                        "MaxInstallments" => $this->maxInstallments
		];
                
                if ( ! empty($this->isPreAuth) ) {

			$result["IsPreAuth"] = $this->isPreAuth;
		}

		return $result;
	}
}