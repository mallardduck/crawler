<?php

namespace Spatie\Crawler\Test;

use Spatie\Crawler\CrawlUrl;
use Spatie\Crawler\CrawlObserver;

class CrawlLogger implements CrawlObserver
{
    /**
     * Called when the crawler will crawl the url.
     *
     * @param \Spatie\Crawler\CrawlUrl   $url
     */
    public function willCrawl(CrawlUrl $url)
    {
        CrawlerTest::log("willCrawl: {$url->url}");
    }

    /**
     * Called when the crawler has crawled the given url.
     *
     * @param \Spatie\Crawler\CrawlUrl $url
     * @param \Psr\Http\Message\ResponseInterface|null $response
     */
    public function hasBeenCrawled(CrawlUrl $url, $response)
    {
        $logText = "hasBeenCrawled: {$url->url}";

        if ($url->foundOnUrl) {
            $logText .= " - found on {$url->foundOnUrl}";
        }

        if ($response->hasHeader('X-Guzzle-Redirect-History')) {
            $redirectHeaders = $response->getHeader('X-Guzzle-Redirect-History');
            $finalUrl = end($redirectHeaders);
            $logText .= " - redirects to {$finalUrl}";
        }

        CrawlerTest::log($logText);
    }

    /**
     * Called when the crawl has ended.
     */
    public function finishedCrawling()
    {
        CrawlerTest::log('finished crawling');
    }
}
