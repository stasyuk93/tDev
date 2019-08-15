<?php

namespace App\Services;

use Carbon\Carbon;

class ArticleParser
{
    /**
     * @var string
     */
    protected $xml;

    /**
     * @var array
     */
    protected $items;

    /**
     * @var array
     */
    protected $parsedData;

    /**
     * @var int
     */
    protected $count = 10;

    /**
     * ArticleParser constructor.
     * @param string $xml
     */
    public function __construct(string $xml)
    {
        $this->xml = $xml;
    }

    /**
     * @param string $xml
     * @return array|null
     */
    public static function parse(string $xml): ?array
    {
        $parser = new static($xml);
        return $parser->parseXml()->getParsedData();
    }

    /**
     * @return $this
     */
    public function parseXml()
    {
        $array = XmlToArray::convert($this->xml);
        $this->items = $this->getItemValue($array, ['rss','channel',0, 'item']);
        unset($array);

        for ($x = 0; $x < $this->count; $x++ ){
            $this->parsedData[] = $this->parseItem($this->items[$x]);
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getParsedData()
    {
        return $this->parsedData;
    }

    /**
     * @param array $item
     * @return array
     */
    public function parseItem(array $item)
    {

        $result = [
            'title' => $this->getItemValue($item,['title',0,'_cdata']),
            'description' => $this->removeTags($this->getItemValue($item, ['description',0,'_cdata'])),
            'url' => $this->getItemValue($item,['link', 0,'_cdata']),
            'date' => $this->parseDate( $this->getItemValue($item, ['pubDate',0,'_cdata'])),
            'image' => $this->getLinkImage($this->getItemValue($item, ['image', 0, '_cdata'])),
        ];
        return $result;
    }

    /**
     * @param string $date
     * @return string
     */
    public function parseDate(string $date)
    {
        return Carbon::parse($date)->format('Y-m-d H:i:s');
    }

    /**
     * @param string $text
     * @return null|string|string[]
     */
    public function removeTags(string $text)
    {
        return preg_replace('/<.*>/', '', $text);
    }

    /**
     * @param string $image
     * @return bool|\Exception|mixed
     */
    public function getLinkImage(string $image)
    {
        preg_match('#src=\"(.*?)\"#', $image, $matches);
        return $this->getItemValue($matches,[1]);
    }

    /**
     * @param array $item
     * @param array $key
     * @return bool|\Exception|mixed
     */
    public function getItemValue(array $item, array $key)
    {
        try{
            foreach ($key as $k => $v){
                if(array_key_exists($v,$item)){
                    unset($key[$k]);
                    if(count($key) > 0) return $this->getItemValue($item[$v],$key);
                    return $item[$v];
                } else {
                    return false;
                }
            }
        } catch (\Exception $e)
        {
            return $e;
        }

    }
}