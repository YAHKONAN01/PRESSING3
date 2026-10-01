<?php
require_once BASE_PATH . '/app/core/Controller.php';
require_once BASE_PATH . '/app/models/TableauModel.php';

class TableauController extends Controller {
	public function index(): void {
		$this->requireAuth();
		
	}
}