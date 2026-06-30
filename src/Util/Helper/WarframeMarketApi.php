<?php

declare(strict_types=1);

namespace App\Util\Helper;

use App\UniqueNameInterface\WarframeApiInterface;

class WarframeMarketApi
{
    private array $headers = [
        'Language' => 'en',
        'Crossplay' => true,
        'Content-Type' => 'application/json',
    ];

    private array $requestTimes = [];

    public function fetchList(string $slug): array
    {
        $item = strtolower(preg_replace('/\s+/', '_', $slug));
        $url = WarframeApiInterface::URL. WarframeApiInterface::URL_ITEM_ORDER. $item;
        $data = $this->_curlRequest($url, []);
//        if (str_ends_with($item, "set")) {
//            $item = str_replace('_set', '', $item);
//            $url = WarframeApiInterface::URL. WarframeApiInterface::URL_ITEMS. $item. WarframeApiInterface::URL_ORDER;
//            $data = file_get_contents($url);
//        }

        return $data[WarframeApiInterface::DATA];
    }

    public function fetchItemData(string $name): array
    {
        $item = strtolower(preg_replace('/\s+/', '_', $name));
        $url = WarframeApiInterface::URL . WarframeApiInterface::URL_ITEM . $item;
        $data = $this->_curlRequest($url, []);

        return $data[WarframeApiInterface::DATA];
    }

    public function fetchRiven(string $name): array {
        $url = WarframeApiInterface::URL . WarframeApiInterface::URL_AUCTION. $name;
        // i don't know why it's blocking without it, other endpoints works fine
        ini_set('user_agent','Mozilla/4.0 (compatible; MSIE 6.0)');
        return json_decode(file_get_contents($url), true)[WarframeApiInterface::FETCHED_PAYLOAD][WarframeApiInterface::PAYLOAD_AUCTIONS];

    }

    public function fetchRivenAttributes(): array {
        $url = WarframeApiInterface::URL . WarframeApiInterface::URL_ATTRIBUTES;

        return json_decode(file_get_contents($url), true)[WarframeApiInterface::DATA];

    }

    /**
     * @throws \Exception
     */
    private function _curlRequest ($url, $headers = [], $method = 'GET')
    {
        $this->waitForRateLimit();
        $curl = curl_init();
        $headers = array_merge($this->headers, $headers);
        $curlHeaders = [];
        foreach ($headers as $name => $value) {
            $curlHeaders[] = sprintf('%s: %s', $name, $value);
        }

        curl_setopt($curl, CURLOPT_URL, $url);
        if ($method == 'POST') {
            curl_setopt($curl, CURLOPT_POST, 1);
        }
        curl_setopt($curl, CURLOPT_HTTPHEADER, $curlHeaders);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
//        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
//        curl_setopt($curl, CURLOPT_USERPWD, "$this->username:$this->password");

        $result = json_decode(curl_exec($curl), true);
        curl_close($curl);

        if (
            (isset($result['error']) && !empty($result['error']))
            || !isset($result['data'])
        ) {
            $curlInfo = curl_getinfo($curl);
            if ($curlInfo['http_code'] != 200) {
                throw new \Exception('Unexpected exception occurred during cURL request: ' . $curlInfo['http_code']);
            }

            if (!empty($result['error'])) {
                throw new \Exception('Error:'. $result['error']);
            }
        }

        return $result;
    }

    public function fetchItems (): array
    {
        $url = WarframeApiInterface::URL . WarframeApiInterface::URL_ITEMS;
        $data = $this->_curlRequest($url, []);

        return $data[WarframeApiInterface::DATA];
    }

    private function waitForRateLimit(): void
    {
        $now = microtime(true);

        // Remove requests older than 1 second
        while (
            !empty($this->requestTimes)
            && $this->requestTimes[0] <= $now - 1
        ) {
            array_shift($this->requestTimes);
        }

        // Already made 3 requests during the last second?
        if (count($this->requestTimes) >= 3) {
            $sleep = ($this->requestTimes[0] + 1) - $now;

            if ($sleep > 0) {
                usleep((int)($sleep * 1_000_000));
            }

            // Start over after sleeping
            $this->waitForRateLimit();
            return;
        }

        $this->requestTimes[] = microtime(true);
    }
}
