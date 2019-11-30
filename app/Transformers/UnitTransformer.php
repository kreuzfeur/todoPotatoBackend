<?php

namespace App\Transformers;

class UnitTransformer extends Transformer
{
	public function transform($unit)
	{
		// $unitArr = $unit->toArray();
		// dd($todoArr);
		return [
			'id' => $unit['id'],
			'name' => $unit['name'],
			'short_name' => $unit['short_name'],
			'type' => $unit['type'],
		];
	}
}
