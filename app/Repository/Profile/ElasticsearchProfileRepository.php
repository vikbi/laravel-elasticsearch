<?php

namespace App\Repository\Profile;

use App\Profile;
use Elasticsearch\Client;
use Illuminate\Database\Eloquent\Collection;

class ElasticsearchProfileRepository implements ProfileRepository
{
    private $search;

    public function __construct(Client $client) {
        $this->search = $client;
    }

    public function search( $query = "")
    {
        $items = $this->searchOnElasticsearch( $query);

        return $this->buildCollection($items);
    }

    private function searchOnElasticsearch( $query)
    {
    	$instance = new Profile;

        $items = $this->search->search([
            'index' => $instance->getSearchIndex(),
            'type' => $instance->getSearchType(),
            'body' => [
                'query' => [
                    'multi_match' => [
                    	'fields' => ['name', 'title', 'company_name', 'location', 'education'],
                        'query' => $query,
                    ],
                ],
            ],
        ]);

        return $items;
    }

    private function buildCollection(array $items)
    {
        $hits = array_pluck($items['hits']['hits'], '_source') ?: [];
        
        $sources = array_map(function ($source) {
            $source['tags'] = json_encode($source['tags']);
            return $source;
        }, $hits);

        return Profile::hydrate($sources);
    }
}