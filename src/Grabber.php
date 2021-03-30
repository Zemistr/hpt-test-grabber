<?php

declare(strict_types=1);

namespace HPT;

interface Grabber
{

	public function getProduct(string $keyword): StolenData;

	/** @deprecated */
	public function getPrice(string $productId): float;
}
