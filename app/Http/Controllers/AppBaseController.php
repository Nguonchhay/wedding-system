<?php
namespace App\Http\Controllers;

use InfyOm\Generator\Utils\ResponseUtil;
use Response;

/**
 * @SWG\Swagger(
 *   basePath="/api/v1",
 *   @SWG\Info(
 *     title="Laravel Generator APIs",
 *     version="1.0.0",
 *   )
 * )
 * This class should be parent class for other API controllers
 * Class AppBaseController
 */
class AppBaseController extends Controller {

    /**
     * @var array
     */
    protected $activeMenu = ['active' => '', 'subMenu' => ''];

    /**
     * @var string
     */
    protected $viewPath;

    /**
     * @var  string
     */
    protected $routePath;



    /**
     * @param string $guard
     */
    public function __construct($guard = 'auth') {
        $this->middleware($guard);
    }

    /**
     * @param $result
     * @param $message
     * @return Response
     */
    public function sendResponse($result, $message) {
        return Response::json(ResponseUtil::makeResponse($message, $result));
    }

    /**
     * @param $error
     * @param int $code
     * @return Response
     */
    public function sendError($error, $code = 404) {
        return Response::json(ResponseUtil::makeError($error), $code);
    }

    /**
     * @param $pageTitle
     * @param $route
     * @param array $values
     *
     * @return mixed
     */
    public function assignToView($pageTitle, $route, $values = array()) {
        $view = view($this->viewPath . $route)
            ->with('pageTitle', $pageTitle)
            ->with('activeMenu', $this->activeMenu)
            ->with('settings', config('settings'));
        foreach ($values as $key => $value) {
            $view = $view->with($key, $value);
        }
        return $view;
    }

    /**
     * @return Response
     */
    public function redirectToIndex()
    {
        return $this->redirectTo('index');
    }

    /**
     * @param $action
     * @return Response
     */
    public function redirectTo($action)
    {
        return redirect(route($this->routePath . $action));
    }
}
