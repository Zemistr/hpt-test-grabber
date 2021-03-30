<?php

declare(strict_types=1);

namespace HPT;

class StolenData
{

	private string $keyword;
	private string $manufacturerCode;
	private float $price;

	public function __construct(string $keyword, string $manufacturerCode, float $price)
	{
		$this->keyword = $keyword;
		$this->price = $price;
		$this->manufacturerCode = $manufacturerCode;
	}

	public function getKeyword(): string
	{
		return $this->keyword;
	}

	public function getManufacturerCode(): string
	{
		return $this->manufacturerCode;
	}

	public function getPrice(): float
	{
		return $this->price;
	}
}
