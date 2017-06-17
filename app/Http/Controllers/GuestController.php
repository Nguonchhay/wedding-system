<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateGuestRequest;
use App\Http\Requests\UpdateGuestRequest;
use App\Repositories\GuestRepository;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class GuestController extends AppBaseController
{
    /** @var GuestRepository */
    private $guestRepository;



	/**
	 * @param GuestRepository $guestRepository
	 */
    public function __construct(GuestRepository $guestRepository) {
		parent::__construct();
        $this->guestRepository = $guestRepository;
		$this->activeMenu = ['active' => 'guest', 'subMenu' => ''];
		$this->viewPath = 'guests.';
		$this->routePath = 'guests.';
    }

    /**
     * Display a listing of the Guest.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->guestRepository->pushCriteria(new RequestCriteria($request));
        $guests = $this->guestRepository->all();

		return $this->assignToView('Guest List', 'index', [
			'guests' => $guests
		]);
    }

    /**
     * Show the form for creating a new Guest.
     *
     * @return Response
     */
    public function create()
    {
		
        return view('guests.create');
    }

    /**
     * Store a newly created Guest in storage.
     *
     * @param CreateGuestRequest $request
     *
     * @return Response
     */
    public function store(CreateGuestRequest $request)
    {
        $input = $request->all();

        $guest = $this->guestRepository->create($input);

        Flash::success('Guest saved successfully.');

        return redirect(route('guests.index'));
    }

    /**
     * Display the specified Guest.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $guest = $this->guestRepository->findWithoutFail($id);

        if (empty($guest)) {
            Flash::error('Guest not found');

            return redirect(route('guests.index'));
        }

        return view('guests.show')->with('guest', $guest);
    }

    /**
     * Show the form for editing the specified Guest.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $guest = $this->guestRepository->findWithoutFail($id);

        if (empty($guest)) {
            Flash::error('Guest not found');

            return redirect(route('guests.index'));
        }

        return view('guests.edit')->with('guest', $guest);
    }

    /**
     * Update the specified Guest in storage.
     *
     * @param  int              $id
     * @param UpdateGuestRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateGuestRequest $request)
    {
        $guest = $this->guestRepository->findWithoutFail($id);

        if (empty($guest)) {
            Flash::error('Guest not found');

            return redirect(route('guests.index'));
        }

        $guest = $this->guestRepository->update($request->all(), $id);

        Flash::success('Guest updated successfully.');

        return redirect(route('guests.index'));
    }

    /**
     * Remove the specified Guest from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $guest = $this->guestRepository->findWithoutFail($id);

        if (empty($guest)) {
            Flash::error('Guest not found');

            return redirect(route('guests.index'));
        }

        $this->guestRepository->delete($id);

        Flash::success('Guest deleted successfully.');

        return redirect(route('guests.index'));
    }
}
