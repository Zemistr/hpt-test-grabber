<?php

declare(strict_types=1);

namespace Tests\HPT;

use HPT\CzcHttpGrabber;
use HPT\HttpClient;
use PHPUnit\Framework\TestCase;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\BrowserKit\Response;

final class CzcHttpGrabberTest extends TestCase
{

	/**
	 * @dataProvider dataProviderForTestCanParseProductData
	 */
	public function testCanParseProductData(
		string $keyword,
		?float $price,
		?string $manufacturerCode,
		?string $name,
		?int $rating
	): void
	{
		$httpClient = new class extends HttpClient {

			public string $key;

			protected function doRequest($request): Response
			{
				assert($request instanceof Request);

				$type = $request->getUri() === sprintf(CzcHttpGrabber::URL, $this->key) ? 'Search' : 'Product';
				$content = file_get_contents(__DIR__ . '/data/czc' . $type . 'Mock_' . $this->key . '.html');

				return new Response($content, 200, []);
			}
		};

		$httpClient->key = $keyword;

		$grabber = new CzcHttpGrabber($httpClient);
		$stolenData = $grabber->getProduct($httpClient->key);

		self::assertSame($keyword, $stolenData->getKeyword());
		self::assertSame($price, $stolenData->getPrice());
		self::assertSame($manufacturerCode, $stolenData->getManufacturerCode());
		self::assertSame($name, $stolenData->getName());
		self::assertSame($rating, $stolenData->getRating());
	}

	public function dataProviderForTestCanParseProductData(): array
	{
		return [
			['NH-U9S', 1552.0, 'NH-U9S', 'Noctua NH-U9S', 98],
			['AA-46-BFGCD12443', null, null, null, null],
			['MCB-NR600-KG5N', 1899.0, 'MCB-NR600-KG5N-S00', 'Cooler Master MasterBox NR600, černá', 90],
		];
	}
}
