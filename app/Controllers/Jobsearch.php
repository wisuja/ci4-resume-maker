<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Libraries\Careerjet_API;

class Jobsearch extends ResourceController
{
	private $careerJet;
	protected $format = 'json';
	
	public function __construct()
	{
		$this->careerJet = new Careerjet_API();
	}

	public function search($keywords, $location = "indonesia", $page = 1) {
		$result = $this->careerJet->search(array(
			'keywords' => $keywords,
			'location' => $location,
			'page' => $page ,
			'affid' => CAREETJET_AFFID,
		));

		return $this->respond($result, 200);
	}
}
