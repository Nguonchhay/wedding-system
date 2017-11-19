<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateGuestRequest;
use App\Http\Requests\UpdateGuestRequest;
use App\Models\Guest;
use App\Repositories\GuestGroupRepository;
use App\Repositories\GuestRepository;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class GuestController extends AppBaseController
{
    /** @var GuestRepository */
    private $guestRepository;

    /** @var GuestGroupRepository */
    private $guestGroupRepository;



    /**
     * @param GuestRepository $guestRepository
     * @param GuestGroupRepository $guestGroupRepository
     */
    public function __construct(GuestRepository $guestRepository, GuestGroupRepository $guestGroupRepository) {
        parent::__construct();
        $this->guestRepository = $guestRepository;
        $this->guestGroupRepository = $guestGroupRepository;
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
        $guestGroups = $this->guestGroupRepository->pluck('name', 'id');
        return $this->assignToView('New guest', 'create', [
            'guestGroups' => $guestGroups
        ]);
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
        $this->guestRepository->pushCriteria(new RequestCriteria($request));
        $input = $request->all();

        $guest = $this->guestRepository->create($input);
        Flash::success('Guest was saved successfully.');
        return $this->redirectToIndex();
    }

    /**
     * @param string $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $guest = $this->checkExistGuest($id);
        $guestGroups = $this->guestGroupRepository->pluck('name', 'id');
        return $this->assignToView('Edit guest', 'edit', [
            'guestGroups' => $guestGroups,
            'guest' => $guest
        ]);
    }

    /**
     * @param string $id
     * @param UpdateGuestRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateGuestRequest $request)
    {
        $guest = $this->checkExistGuest($id);
        $guest = $this->guestRepository->update($request->all(), $guest->id);
        Flash::success('Guest updated successfully.');
        return $this->redirectToIndex();
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
        $guest = $this->checkExistGuest($id);
        $this->guestRepository->delete($guest->id);

        Flash::success('Guest deleted successfully.');
        return $this->redirectToIndex();
    }

    /**
     * @param string $id
     * @return Guest|null
     */
    private function checkExistGuest($id)
    {
        /** @var Guest|null $guest */
        $guest = $this->guestRepository->findWithoutFail($id);
        if (empty($guest)) {
            return $this->redirectToIndex();
        }
        return $guest;
    }
}
