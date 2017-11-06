<?php

namespace App\Repository\User;

use App\User;
use Elasticsearch\Client;
use Illuminate\Database\Eloquent\Collection;

class ElasticsearchUsersRepository implements UsersRepository
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
    	$instance = new User;

        $items = $this->search->search([
            'index' => $instance->getSearchIndex(),
            'type' => $instance->getSearchType(),
            'body' => [
                'query' => [
                    'multi_match' => [
                    	'fields' => ['name','email'],
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

        return User::hydrate($sources);
    }
}