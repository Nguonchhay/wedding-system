<?php
namespace App\Http\Controllers;

class HomeController extends AppBaseController
{

    /**
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->activeMenu = ['active' => 'home', 'subMenu' => ''];
        $this->viewPath = 'home.';
        $this->routePath = 'home.';
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return $this->assignToView('Dashboard', 'index');
    }
}
