<?php

declare(strict_types=1);

namespace HPT;

use RuntimeException;
use Symfony\Component\DomCrawler\Crawler;

class CzcHttpGrabber implements Grabber
{

	public const URL = 'https://www.czc.cz/%s/hledat';

	private HttpClient $httpClient;

	public function __construct(HttpClient $httpClient)
	{
		$this->httpClient = $httpClient;
	}

	public function getProduct(string $keyword): StolenData
	{
		$url = sprintf(self::URL, $keyword);
		$crawler = $this->httpClient->request(HttpClient::METHOD_GET, $url);

		if (!$crawler instanceof Crawler) {
			throw new RuntimeException(sprintf('Can\'t parse url "%s"', $url));
		}

		$results = $crawler->filter('#tiles .tile-link');

		if ($results->count() === 0) {
			return new StolenData($keyword, '', 0);
		}

		$link = $results->first()->link();
		$productPageCrawler = $this->httpClient->click($link);

		if (!$productPageCrawler instanceof Crawler) {
			throw new RuntimeException(sprintf('Can\'t parse url "%s"', $link->getUri()));
		}

		$uselessInfo = $productPageCrawler
			->filter('.pd-next-in-category .pd-next-in-category__item')
			->each(
				function (Crawler $crawler) {
					$text = $crawler->text();

					if (mb_strpos($text, 'Kód výrobce') === 0) {
						return $crawler->filter('span')->text();
					}

					return false;
				}
			);

		$filteredUselessInfo = array_filter($uselessInfo) + [''];
		$manufacturerCode = (string) array_shift($filteredUselessInfo);

		$priceText = $productPageCrawler->filter('#product-price-and-delivery-section .price-vatin')->text();
		$price = (float) preg_replace('~\D+~', '', $priceText);

		return new StolenData($keyword, $manufacturerCode, $price);
	}

	public function getPrice(string $productId): float
	{
		return $this->getProduct($productId)->getPrice();
	}
}
