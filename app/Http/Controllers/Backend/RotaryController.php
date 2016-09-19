<?php
/**
 * Created by liuchen.
 * User: liuchen
 * Date: 2016/6/27 0027
 * Time: 15:29
 */

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\BaseController;
use App\Models\Rotary;

class RotaryController extends BaseController
{
	public function __construct(){
		parent::__construct();
		$this->model = new Rotary();
	}

	public function index(){
		$list = $this->model->getAll();

		return view('backend.rotary.rotary', array('list' => $list));
	}

	public function edit($id){
		$info = $this->model->find($id);

		return view('backend.rotary.editRotary', array('info' => $info));
	}

	public function save(){
		$id = $this->getParam('id');
		$info = $this->model->find($id);
		$info->stock = $this->getParam('stock', 0);
		$info->no_limit = $this->getParam('no_limit', 0);
		$info->weight = $this->getParam('weight', 0);

		$info->save();

		return redirect('backend/rotary');
	}

}