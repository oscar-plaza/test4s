<?php

App::uses('Component', 'Controller');
App::import('Vendor', 'FoursquareAPI', array('file' => 'foursquare' . DS .'src' . DS . 'FoursquareAPI.class.php'));


class FoursquareComponent extends Component {

	public $fsConnection;
	public $lastMeta = array();

    public function initialize() {

    	$client_key = Configure::read('Foursquare.client');
    	$client_secret = Configure::read('Foursquare.secret');

    	$this->fsConnection = new FoursquareAPI( $client_key, $client_secret );
    }

    public function getCategories() {

		$response = $this->fsConnection->GetPublic("venues/categories");
		$venues = json_decode($response, true);

		$this->lastMeta = $venues['meta'];
		return $venues['response'];
    }


    public function getRecomended( $lat, $lng, $limit = 10, $sort = 'relevance' ) {

		$params = array( 
			"ll" => "$lat,$lng",
			'limit' => $limit,
			'sortByDistance' => $sort != 'relevance'
		);

		$response = $this->fsConnection->GetPublic("venues/explore", $params);
		$venues = json_decode($response, true);

		$this->lastMeta = $venues['meta'];

		return $venues['response'];
    }


    public function search(	$param, $category, $lat, $lng, $limit = 10, $sort = 'relevance' ) {

		$params = array( 
			"ll" => "$lat,$lng",
			'limit' => $limit,
			'intent' => 'browse',
			'query' => $param,
			'categoryId' => $category,
			'sortByDistance' => $sort != 'relevance'
		);

		$response = $this->fsConnection->GetPublic("venues/explore", $params);
		$venues = json_decode($response, true);

		$this->lastMeta = $venues['meta'];
		return $venues['response'];
    }



    public function getInfo( $id ) {

		$response = $this->fsConnection->GetPublic("venues/".$id );
		$venue = json_decode($response, true);

		$this->lastMeta = $venue['meta'];

		if ( $venue['meta']['code'] != 200 ) {
			return false;
		} else {
			return $venue['response'];
		}
    }

}