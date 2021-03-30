<?php

declare(strict_types=1);

namespace HPT;

class StolenData
{

	private string $keyword;
	private ?string $manufacturerCode;
	private ?float $price;
	private ?string $name;
	private ?int $rating;

	public function __construct(string $keyword, ?string $manufacturerCode, ?float $price, ?string $name, ?int $rating)
	{
		$this->keyword = $keyword;
		$this->price = $price;
		$this->manufacturerCode = $manufacturerCode;
		$this->name = $name;
		$this->rating = $rating;
	}

	public function getKeyword(): string
	{
		return $this->keyword;
	}

	public function getManufacturerCode(): ?string
	{
		return $this->manufacturerCode;
	}

	public function getPrice(): ?float
	{
		return $this->price;
	}

	public function getName(): ?string
	{
		return $this->name;
	}

	public function getRating(): ?int
	{
		return $this->rating;
	}
}
