<?php

namespace App;

use Goutte\Client;

class WebsiteScraper
{
    public function scrape($url)
    {
        $client = new Client();
        $crawler = $client->request('GET', $url);

        // Wait for the page to load by sleeping for a few seconds
        sleep(15);

        $title = $crawler->filter('title')->text();
        $description = $crawler->filter('meta[name="description"]')->attr('content');

        return [
            'title' => $title,
            'description' => $description,
        ];
    }
}
