<?php

namespace App\Services\Rss;

use Carbon\Carbon;
use SimplePie_Category;
use SimplePie_Enclosure;
use SimplePie_Item;
use Vedmant\FeedReader\FeedReader;

class RssService
{
    /**
     * @var FeedReader
     */
    private $feedReader;

    public function __construct(FeedReader $feedReader)
    {
        $this->feedReader = $feedReader;
    }

    public function getTdlNews()
    {
        $simplePie = $this->feedReader->read('https://terredeliens.org/spip.php?page=backend&id_rubrique=7');

        $simplePieItems = collect($simplePie->get_items());

        $defaultImage = $simplePie->get_image_url();

        $items = $simplePieItems->map(function (SimplePie_Item $item) use ($defaultImage) {
            return [
                'title' => $item->get_title(),
                'categories' => collect($item->get_categories())->map(function (SimplePie_Category $category) {
                    return $category->get_term();
                }),
                'description' => strip_tags($item->get_description()),
                'link_rubrique' => $this->extractUrlFromHtmlLink($this->getTagData($item, 'lien_rubrique')),
                'link_region' => $this->extractUrlFromHtmlLink($this->getTagData($item, 'lien_region')),
                'html_content' => $item->get_content(),
                'link' => $item->get_link(),
                'thumbnail' => $this->getTagData($item, 'illustration') ?: $defaultImage,
                'attachments' => collect($item->get_enclosures())->map(function (SimplePie_Enclosure $enclosure) {
                    return collect([
                        'url' => $enclosure->get_link(),
                        'type' => $enclosure->get_type(),
                    ]);
                }),
                'date' => new Carbon($item->get_date()),
            ];
        });

        return $items;
    }

    private function getTagData(SimplePie_Item $item, $tag, $namespace = '')
    {
        return $item->get_item_tags($namespace, $tag)[0]['data'] ?? '';
    }

    private function extractUrlFromHtmlLink($html)
    {
        preg_match('/href="(.*?)"/i', $html, $matches);

        return $matches['1'] ?? '';
    }
}
