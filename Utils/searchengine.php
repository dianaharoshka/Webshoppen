<?php


require_once("vendor/autoload.php");
require_once("Models/Product.php");

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

require_once("Models/Database.php");
$dotenv = Dotenv\Dotenv::createImmutable(".");
$dotenv->load();




class SearchEngine
{
    private $accessKey;
    private $secretKey;
    private $url;
    private $index_name;
    private $client;

    function __construct()
    {
        $this->accessKey = getenv('ACCESS_KEY');
        $this->secretKey = getenv('SECRET_KEY');
        $this->url = getenv('SEARCH_URL');
        $this->index_name = getenv('INDEX_NAME');




        $this->client = new Client([
            'base_uri' => $this->url,
            'verify' => false,
            'headers' => [
                'Authorization' => 'Basic ' . base64_encode($this->accessKey . ':' . $this->secretKey),
                'Content-Type' => 'application/json'
            ]
        ]);


    }

    function getDocumentIdOrUndefined(string $webId): ?string
    {
        $query = [
            'query' => [
                'term' => [
                    'webid' => $webId
                ]
            ]
        ];


        try {
            $response = $this->client->post("/api/index/v1/{$this->index_name}/_search", [
                'json' => $query
            ]);

            $data = json_decode($response->getBody(), true);

            if (empty($data['hits']['total']['value'])) {
                return null;
            }

            return $data['hits']['hits'][0]['_id'];
        } catch (RequestException $e) {
            // Hantera eventuella fel här
            echo $e->getMessage();
            return null;
        }
    }

    function search(string $query, string $sortCol, string $sortOrder)
    {
        $aa = "";

        $aa = $aa . "combinedsearchtext:" . $query . '*';

        $query = [
            'query' => [
                'query_string' => [
                    'query' => $aa
                ],

            ],

            'sort' => [
                $sortCol . '.keyword' => [
                    'order' => $sortOrder
                ]

            ],

        ];


        try {
            $response = $this->client->post("/api/index/v1/{$this->index_name}/_search", [
                'json' => $query
            ]);

            $data = json_decode($response->getBody(), true);

            if (empty($data['hits']['total']['value'])) {
                return null;
            }

            $data["hits"]["hits"] = $this->convertSearchEngineArrayToProduct($data["hits"]["hits"]);

            return [
                "data" => $data["hits"]["hits"],
            ];
        } catch (RequestException $e) {
            echo $e->getMessage();
            return null;
        }
    }


    function convertSearchEngineArrayToProduct($searchengineResults)
    {
        $newarray = [];
        foreach ($searchengineResults as $hit) {
            // var_dump($hit);
            $prod = new Product();
            $prod->searchengineid = $hit["_id"];
            $prod->id = $hit["_source"]["webid"];
            $prod->title = $hit["_source"]["title"];
            $prod->description = $hit["_source"]["description"] ?? '';
            $prod->price = $hit["_source"]["price"];
            $prod->categoryName = $hit["_source"]["categoryName"];
            $prod->image_url = $hit["_source"]["image_url"] ?? '';
            $prod->category_id = $hit["_source"]["category_id"] ?? null;




            array_push($newarray, $prod);
        }
        return $newarray;

    }





}



