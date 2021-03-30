<?php

declare(strict_types=1);

namespace HPT;

interface Output
{

	public function addData(StolenData $data): void;

	public function getJson(): string;
}
