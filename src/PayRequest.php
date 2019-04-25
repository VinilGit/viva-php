<?php namespace ATDev\Viva;

/**
 * An abstract class to init the transaction
 */
abstract class PayRequestAbstract extends RequestAbstract {



	/**
	 * Specifies what has to be returned on serialization to json
	 *
	 * @return array Data to serialize
	 */
	public function jsonSerialize() {

		$result = [
			"apiOperation" => $this->apiOperation,
			"order" => $this->order
		];

		if ( ! empty($this->sourceOfFunds) ) {

			$result["sourceOfFunds"] = $this->sourceOfFunds;
		}

		return $result;
	}
}

/**
 * Class to authorize the transaction
 */
class AuthorizeRequest extends PayRequestAbstract {

	protected $apiOperation = 'AUTHORIZE';
}

/**
 * Class to make payment transaction
 */
class PayRequest extends PayRequestAbstract {

	protected $apiOperation = 'PAY';
}

/**
 * Class to capture transaction
 */
class CaptureRequest extends PayRequestAbstract {

	protected $apiOperation = 'CAPTURE';
}

/**
 * Class to cancel the transaction
 */
class CancelRequest extends PayRequestAbstract {

	protected $apiOperation = 'CANCEL';
}