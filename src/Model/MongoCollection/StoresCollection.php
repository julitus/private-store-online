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
	        	]
	        ]
        );
    }

    public function updateTo($store)
    {
    	return $this->update(
    		[
	        	'id' => $store['id'], 
	        	'location' => [
	        		'type' => "Point",
	        		'coordinates' => [
	        			(float)$store['latitude'], 
	        			(float)$store['longitude']
	        		]
	        	]
	        ],
	        [
	        	'id' => $store['id']
	        ],
	        [
	        	'upsert' => true
	        ]
    	);
    }

    public function updateProductTo(){
    	
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