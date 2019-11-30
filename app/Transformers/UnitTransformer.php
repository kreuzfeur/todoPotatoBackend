<?php

namespace App\Transformers;

class UnitTransformer extends Transformer
{
	public function transform($unit)
	{
		$unitArr = $unit->toArray();
		// dd($todoArr);
		return [
			'id' => $unitArr['id'],
			'name' => $unitArr['name'],
			'short_name' => $unitArr['short_name'],
			'type' => $unitArr['type'],
		];
	}
}
