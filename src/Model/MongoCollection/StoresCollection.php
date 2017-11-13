<?php
namespace App\Model\MongoCollection;

use CakeMonga\MongoCollection\BaseCollection;

class StoresCollection extends BaseCollection
{
	public function insertTo($store)
    {
        return $this->insert(
        	[
	        	'id' => $store['id'], 
	        	'location' => [
	        		'type' => "Point",
	        		'coordinates' => [
	        			(float)$store['latitude'], 
	        			(float)$store['longitude']
	        		]
	        	],
	        	'products' => []
	        ]
        );
    }

    public function updateTo($store)
    {
    	return $this->update(
    		[
    			'$set' => [
		        	'location' => [
		        		'type' => "Point",
		        		'coordinates' => [
		        			(float)$store['latitude'], 
		        			(float)$store['longitude']
		        		]
		        	]
		        ]
	        ],
	        [
	        	'id' => $store['id']
	        ]/*,
	        [
	        	'upsert' => true
	        ]*/
    	);
    }

    public function updateProductTo($warehouse)
    {
    	return $this->update(
    		[
	        	'$push' => [
	        		'products' => [
	        			'id' => $warehouse['product_id'],
	        			'active' => $warehouse['active']
	        		] 
	        	]
	        ],
	        [
	        	'id' => $warehouse['store_id']
	        ]
    	);	
    }

    public function changeActiveProductTo($warehouse)
    {
    	return $this->update(
    		[
	        	'$set' => [
	        		'products.$.active' => $warehouse['active']
	        	]
	        ],
	        [
	        	'id' => $warehouse['store_id'],
	        	'products.id' =>  $warehouse['product_id']
	        ]
    	);	
    }

    public function removeProductTo($warehouse)
    {
    	return $this->update(
    		[
	        	'$pull' => [
	        		'products' => [
	        			'id' => $warehouse['product_id']
	        		] 
	        	]
	        ],
	        [
	        	'id' => $warehouse['store_id']
	        ]
    	);
    }

    public function removeTo($idStore)
    {
    	return $this->remove(
    		[
    			'id' => (int)$idStore
    		]
    	);
    }
}