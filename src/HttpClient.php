<?php

declare(strict_types=1);

namespace HPT;


use Nette\Caching\Cache;
use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\BrowserKit\Response;

class HttpClient extends HttpBrowser
{

	public const METHOD_GET = 'GET';
	private ?Cache $cache = null;

	public function setCache(?Cache $cache): void
	{
		$this->cache = $cache;
	}

	protected function doRequest($request): Response
	{
		assert($request instanceof Request);

		if ($this->cache === null) {
			return parent::doRequest($request);
		}

		return $this->cache->load(serialize($request), function () use ($request) {
			return parent::doRequest($request);
		});
	}

}
