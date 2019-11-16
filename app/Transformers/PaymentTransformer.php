<?php

namespace App\Transformers;

use App\Payment;

class PaymentTransformer extends Transformer
{
	public function transform($payment)
	{
		$payment = $payment->toArray();
		// dd($payment);
		return [
			'id' => $payment['id'],
			'cash' => $payment['cash'],
			'date' => $payment['date'],
			'lawyer' => $payment['lawyer']['name'],
			'lawyer_education' => $payment['lawyer_education']['name'],
			'defendant' => $payment['defendant']['name'],
			'judge' => $payment['judge']['name'],
			'type' => $payment['type']['name'],
		];
	}
}
