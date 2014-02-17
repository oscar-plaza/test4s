<?php
App::uses('AppController', 'Controller');
/**
 * Categories Controller
 *
 * @property Category $Category
 * @property PaginatorComponent $Paginator
 */
class PlacesController extends AppController {

/**
 * use
 *
 * @var array
 */
	public $uses = false;

	public $defaultParams = array(
			'catid' => '',
			'q' => '',
			'latitude' => false, //'3.36942',
			'longitude' => false, //'-76.53497',
			'sort' => 'relevance'
		);


/**
 * Components
 *
 * @var array
 */
	public $components = array('RequestHandler', 'Foursquare');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		//$this->Category->recursive = 0;
		//$this->set('categories', $this->paginate());
	}


/**
 * explore method
 *
 * @return void
 */
	public function explore() {

		if ( !isset($this->request->query['latitude'] ) || !isset($this->request->query['longitude'] ) ) {
			throw new NotFoundException(__('Must provide latitude and longitude'));
		}


		$options = array_merge($this->defaultParams, $this->request->query);

		$places = $this->Foursquare->getRecomended($options['latitude'], $options['longitude'], 10, $options['sort']);

		$this->RequestHandler->setContent('json', 'application/json' ); 
		$this->set('results', $places);  
		$this->set('_serialize', 'results');
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id) {

		if ( !$id ) {
			throw new NotFoundException(__('Invalid venue'));
		}

		$place = $this->Foursquare->getInfo($id);

		if ( $place === false ) {
			throw new NotFoundException(__('Invalid venue'));
		}	

		if ( $this->request->isAjax()) {
			$this->layout = 'ajax';
		}

		$this->RequestHandler->setContent('json', 'application/json' ); 
		$this->set('result', $place);  
		$this->set('_serialize', 'result');
	}



/**
 * near method
 *
 * @return void
 */
	public function near() {
		
		if ( !isset($this->request->query['q'] ) && !isset($this->request->query['catid'] ) ) {
			throw new NotFoundException(__('Must use a q or catid'));
		}

		if ( !isset($this->request->query['latitude'] ) || !isset($this->request->query['longitude'] ) ) {
			throw new NotFoundException(__('Must provide lat and longitude'));
		}


		$options = array_merge($this->defaultParams, $this->request->query);

		$places = $this->Foursquare->search($options['q'], $options['catid'], $options['latitude'], $options['longitude'], 10, $options['sort']);

		$this->RequestHandler->setContent('json', 'application/json' ); 
		$this->set('results', $places);  
		$this->set('_serialize', 'results');

	}
}
