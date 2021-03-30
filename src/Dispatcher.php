<?php

declare(strict_types=1);

namespace HPT;

class Dispatcher
{

	private Grabber $grabber;
	private Output $output;

	public function __construct(Grabber $grabber, Output $output)
	{
		$this->grabber = $grabber;
		$this->output = $output;
	}

	public function run(): string
	{
		while ($keyword = fgets(STDIN)) {
			$keyword = trim($keyword);

			if ($keyword !== '') {
				$this->output->addData($this->grabber->getProduct($keyword));
			}
		}

		return $this->output->getJson();
	}
}
