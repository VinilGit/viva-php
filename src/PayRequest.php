<?php namespace ATDev\Viva;

/**
 * An abstract class to init the transaction
 */
class PayRequest extends RequestAbstract {

        private $order;
	private $orderCode;
        private $cardToken;
        private $installments;
        private $paymentMethodId;
               
        /**
	 * Gets full api url for the request
	 *
	 * @return string
	 */
	protected function getRequestUrl() {
            return $this->url.$this->paymentsUrl;
	}
        
        /**
	 * Sets order $order
	 *
	 * @param object $order
	 *
	 * @return \ATDev\Viva\Order
	 */
	protected function setOrder($order) {

		$this->order = $order;

		return $this;
	}

        /**
	 * Gets order $order
	 *
	 * @return object
	 */
	protected function getOrder() {

            if (empty($this->order)) {

                $this->order = (new Order($this->sourceCode, $this->password, $this->amount, $this->installments, $this->isPreAuth))
                        ->send();     
            }
            
            return $this->order;
	}
        
        /**
	 * Sets order $orderCode
	 *
	 * @param string $orderCode
	 *
	 * @return \ATDev\Viva\Order
	 */
	public function setOrderCode($orderCode) {

		$this->orderCode = $orderCode;

		return $this;
	}

        /**
	 * Gets order $orderCode
	 *
	 * @return string
	 */
	public function getOrderCode() {

            if ( ! empty($this->orderCode)) {
                return $this->orderCode;
            } else {
                return $this->getOrder()->orderCode;
            }
	}
         
        /**
	 * Sets order $cardToken
	 *
	 * @param string $cardToken
	 *
	 * @return \ATDev\Viva\Order
	 */
	public function setCardToken($cardToken) {

		$this->cardToken = $cardToken;

		return $this;
	}

        /**
	 * Gets order $cardToken
	 *
	 * @return string
	 */
	public function getCardToken() {

                return $this->cardToken;
	}
             
        /**
	 * Sets order $installments
	 *
	 * @param string $installments
	 *
	 * @return \ATDev\Viva\Order
	 */
	public function setInstallments($installments) {

		$this->installments = $installments;

		return $this;
	}

        /**
	 * Gets order $installments
	 *
	 * @return string
	 */
	public function getInstallments() {

                return $this->installments;
	}
        
                     
        /**
	 * Sets order $paymentMethodId
	 *
	 * @param string $paymentMethodId
	 *
	 * @return \ATDev\Viva\Order
	 */
	public function setPaymentMethodId($paymentMethodId) {

		$this->paymentMethodId = $paymentMethodId;

		return $this;
	}

        /**
	 * Gets order $installments
	 *
	 * @return string
	 */
	public function getPaymentMethodId() {

                return $this->paymentMethodId;
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
			"OrderCode" => $this->orderCode,
                        "CreditCard" => ["Token" => $this->cardToken],
                        "Installments" => $this->installments,
		];
                
                if ( ! empty($this->paymentMethodId) ) {

			$result["PaymentMethodId"] = $this->paymentMethodId;
		}

		return $result;
	}
}