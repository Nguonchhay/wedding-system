<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateGuestGroupRequest;
use App\Http\Requests\UpdateGuestGroupRequest;
use App\Repositories\GuestGroupRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class GuestGroupController extends AppBaseController
{
    /** @var GuestGroupRepository */
    private $guestGroupRepository;

    /**
     * @param GuestGroupRepository $guestGroupRepository
     */
    public function __construct(GuestGroupRepository $guestGroupRepository)
    {
        parent::__construct();
        $this->guestGroupRepository = $guestGroupRepository;
        $this->activeMenu = ['active' => 'guest_group', 'subMenu' => ''];
        $this->viewPath = 'guest_groups.';
        $this->routePath = 'guest_groups.';
    }

    /**
     * Display a listing of the GuestGroup.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->guestGroupRepository->pushCriteria(new RequestCriteria($request));
        $guestGroups = $this->guestGroupRepository->all();

        return $this->assignToView('Guest Group List', 'index', [
            'guestGroups' => $guestGroups
        ]);
    }

    /**
     * Show the form for creating a new GuestGroup.
     *
     * @return Response
     */
    public function create()
    {
        return $this->assignToView('New Guest Group', 'create');
    }

    /**
     * Store a newly created GuestGroup in storage.
     *
     * @param CreateGuestGroupRequest $request
     *
     * @return Response
     */
    public function store(CreateGuestGroupRequest $request)
    {
        $input = $request->all();
        $guestGroup = $this->guestGroupRepository->create($input);
        Flash::success('Guest Group saved successfully.');
        return $this->redirectToIndex();
    }

    /**
     * Show the form for editing the specified GuestGroup.
     *
     * @param string $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $guestGroup = $this->guestGroupRepository->findWithoutFail($id);
        if (empty($guestGroup)) {
            Flash::error('Guest Group not found');
            return $this->redirectToIndex();
        }

        return $this->assignToView('Edit Guest Group', 'edit', [
            'guestGroup' => $guestGroup
        ]);
    }

    /**
     * @param string $id
     * @param UpdateGuestGroupRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateGuestGroupRequest $request)
    {
        $guestGroup = $this->guestGroupRepository->findWithoutFail($id);
        if (empty($guestGroup)) {
            Flash::error('Guest Group not found');
            return $this->redirectToIndex();
        }

        $guestGroup = $this->guestGroupRepository->update($request->all(), $id);
        Flash::success('Guest Group updated successfully.');
        return $this->redirectToIndex();
    }

    /**
     * @param string $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $guestGroup = $this->guestGroupRepository->findWithoutFail($id);
        if (empty($guestGroup)) {
            Flash::error('Guest Group not found');
            return $this->redirectToIndex();
        }

        $this->guestGroupRepository->delete($id);
        Flash::success('Guest Group deleted successfully.');
        return $this->redirectToIndex();
    }
}
