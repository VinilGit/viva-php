<?php namespace ATDev\Viva;

/**
 * An abstract class to init the transaction
 */
abstract class PayRequestAbstract extends RequestAbstract {

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
	private function getRequestUrl() {
            return $this->url.$this->paymentsUrl;
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