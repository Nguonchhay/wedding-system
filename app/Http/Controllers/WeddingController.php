<?php
namespace App\Http\Controllers;

use App\Http\Requests\CreateWeddingRequest;
use App\Http\Requests\UpdateWeddingRequest;
use App\Models\Wedding;
use App\Repositories\WeddingRepository;
use App\Utility\Files;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class WeddingController extends AppBaseController
{
    /** @var WeddingRepository */
    private $weddingRepository;


	/**
	 * @param WeddingRepository $weddingRepository
	 */
    public function __construct(WeddingRepository $weddingRepository) {
		parent::__construct();
        $this->weddingRepository = $weddingRepository;
		$this->activeMenu = ['active' => 'wedding', 'subMenu' => ''];
		$this->viewPath = 'weddings.';
		$this->routePath = 'weddings.';
    }

    /**
     * Display a listing of the Wedding.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->weddingRepository->pushCriteria(new RequestCriteria($request));
        $weddings = $this->weddingRepository->all();
		var_dump(empty($weddings));

		return $this->assignToView('Wedding List', 'index', [
			'weddings' => $weddings
		]);
    }

    /**
     * Show the form for creating a new Wedding.
     *
     * @return Response
     */
    public function create()
    {
		return $this->assignToView('New Wedding', 'create');
    }

    /**
     * Store a newly created Wedding in storage.
     *
     * @param CreateWeddingRequest $request
     *
     * @return Response
     */
    public function store(CreateWeddingRequest $request)
    {
        $input = $request->all();
		$input['groom_image'] = Files::saveUploadImage('groom_image', Wedding::getPrefixImage(), Wedding::getBaseImagePath());
		$input['bride_image'] = Files::saveUploadImage('bride_image', Wedding::getPrefixImage(), Wedding::getBaseImagePath());

        $wedding = $this->weddingRepository->create($input);
        Flash::success('Wedding saved successfully.');

        return redirect(route('weddings.index'));
    }

    /**
     * Display the specified Wedding.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $guest = $this->weddingRepository->findWithoutFail($id);

        if (empty($guest)) {
            Flash::error('Wedding not found');

            return redirect(route('guests.index'));
        }

        return view('guests.show')->with('guest', $guest);
    }

    /**
     * Show the form for editing the specified Wedding.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $guest = $this->weddingRepository->findWithoutFail($id);

        if (empty($guest)) {
            Flash::error('Wedding not found');

            return redirect(route('guests.index'));
        }

        return view('guests.edit')->with('guest', $guest);
    }

    /**
     * Update the specified Wedding in storage.
     *
     * @param  int              $id
     * @param UpdateWeddingRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateWeddingRequest $request)
    {
        $guest = $this->weddingRepository->findWithoutFail($id);

        if (empty($guest)) {
            Flash::error('Wedding not found');

            return redirect(route('guests.index'));
        }

        $guest = $this->weddingRepository->update($request->all(), $id);

        Flash::success('Wedding updated successfully.');

        return redirect(route('guests.index'));
    }

    /**
     * Remove the specified Wedding from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $guest = $this->weddingRepository->findWithoutFail($id);

        if (empty($guest)) {
            Flash::error('Wedding not found');

            return redirect(route('guests.index'));
        }

        $this->weddingRepository->delete($id);

        Flash::success('Wedding deleted successfully.');

        return redirect(route('guests.index'));
    }
}
