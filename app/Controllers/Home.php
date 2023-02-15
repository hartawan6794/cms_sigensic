<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        if (session()->get('isLogin')) {

			$data = [
				'controller'    	=> 'dashboard',
				'title'     		=> 'Dashbord Aplikasi'
			];

			return view('dashboard', $data);
		} else {
			return view('login');
		}
    }
}
