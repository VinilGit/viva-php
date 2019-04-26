<?php namespace ATDev\Viva;

/**
 * Order class
 */
class Order extends RequestAbstract  {

	private $maxInstallments;
        private $isPreAuth;

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
	 * Gets order isPreAuth
	 *
	 * @return bool
	 */
	public function getIsPreAuth() {

		return $this->isPreAuth;
	}
        
        /**
	 * Sets order isPreAuth
	 *
	 * @param bool $isPreAuth
	 *
	 * @return \ATDev\Viva\Order
	 */
	public function setIsPreAuth($isPreAuth) {

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