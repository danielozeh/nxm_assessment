<?php
namespace App\Http\Traits;

use GuzzleHttp\Client;

/**
 * @author Daniel Ozeh hello@danielozeh.com.ng
 * 
 * Used to consume external resources
 */

/**
 * 
 */
trait ApiCalls
{
    /**
     * Send a request to any service
     * @return string
     */
    public function makeRequest($method, $requestUrl, $queryParams = [], $data = [], $hasFile = false) {
        $client = new Client([
            'base_uri' => $this->baseUri,
            'headers' => $this->headers,
            'verify' => false
        ]);

        $bodyType = 'json';
        if($hasFile) {
            $bodyType = 'multipart';
            $multipart = [];

            foreach($data as $name => $contents) {
                $multipart[] = [
                    'name' => $name,
                    'contents' => $contents
                ];
            }
        }
        $response = $client->request($method, $requestUrl, [
            'query' => $queryParams,
            $bodyType => $hasFile ? $multipart : $data
        ]);

        $response = $response->getBody()->getContents();

        return $response;
    }
}
