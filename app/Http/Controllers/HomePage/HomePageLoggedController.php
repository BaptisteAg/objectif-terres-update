<?php
namespace App\Http\Controllers\HomePage;

use App\Http\Controllers\Controller;


class HomePageLoggedController extends Controller
{

	public function index()
	{
		return view('pages.account.showAccount');

	}
}