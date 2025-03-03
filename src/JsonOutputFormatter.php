<?php

declare(strict_types=1);

namespace HPT;

class JsonOutputFormatter implements Output
{

	/**
	 * @var array<string, null|int|float|string>
	 */
	private array $data = [];

	public function addData(StolenData $data): void
	{
		$this->data[$data->getKeyword()] = [
			'price' => $data->getPrice(),
			'manufacturer_code' => $data->getManufacturerCode(),
			'name' => $data->getName(),
			'rating' => $data->getRating(),
		];
	}

	public function getJson(): string
	{
		return json_encode($this->data, JSON_THROW_ON_ERROR);
	}
}
