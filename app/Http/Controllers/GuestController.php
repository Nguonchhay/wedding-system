<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateGuestRequest;
use App\Http\Requests\UpdateGuestRequest;
use App\Models\Guest;
use App\Models\GuestGroup;
use App\Repositories\GuestGroupRepository;
use App\Repositories\GuestRepository;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Auth;
use Excel;
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
        $guestGroups = $this->guestGroupRepository->pluck('name', 'id')->prepend('Select guest group', '');

        $selectedGroup = $request->get('group', null);
        if ($selectedGroup !== null) {
            $guests = $this->guestRepository->findWhere(['guest_group_id' => $selectedGroup]);
        }

        return $this->assignToView('Guest List', 'index', [
            'guestGroups' => $guestGroups,
            'selectedGroup' => $selectedGroup,
            'guests' => $guests
        ]);
    }

    /**
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
     * @param CreateGuestRequest $request
     *
     * @return Response
     */
    public function store(CreateGuestRequest $request)
    {
        $this->guestRepository->pushCriteria(new RequestCriteria($request));
        $input = $request->all();

        $input['khmer_name'] = $request->get('khmer_name', null);
        $input['english_name'] = $request->get('english_name', null);
        if ($input['khmer_name'] === null && $input['english_name'] === null) {
            Flash::success('Khmer name or English name is require');
            return $this->redirectTo('create');
        }

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
        $input = $request->all();

        $input['khmer_name'] = $request->get('khmer_name', null);
        $input['english_name'] = $request->get('english_name', null);
        if ($input['khmer_name'] === null && $input['english_name'] === null) {
            Flash::success('Khmer full name or English name is require');
            return $this->redirectToIndex();
        }

        $guest = $this->guestRepository->update($input, $guest->id);
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
     * @return Response
     */
    public function import()
    {
        $guests = $this->guestRepository->findWhere(['user_id' => Auth::user()->id]);
        return $this->assignToView('Import guests', 'import', [
            'guests' => $guests
        ]);
    }

    public function importGuest(Request $request)
    {
        if ($request->hasFile('import_file')) {
            $extension = $request->file('import_file')->extension();
            if ($extension === "xlsx") {
                $path = $request->file('import_file')->getRealPath();
                /** @var \Maatwebsite\Excel\Collections\RowCollection $data */
                $data = Excel::load($path, function ($reader) {
                })->get();

                if (!empty($data) && $data->count()) {
                    $adjustData = $data->all();
                    $userId = Auth::user()->id;
                    /** @var \Maatwebsite\Excel\Collections\CellCollection $excelRow */
                    for ($i = 1; $i < $data->count(); $i++) {
                        $excelRow = $adjustData[$i];
                        $guestGroupData = $excelRow->get('guest_group', '');
                        $khmerName = $excelRow->get('khmer_name', '');
                        $printName = $excelRow->get('print_name', '');
                        if ($khmerName !== '' && $printName !== '') {
                            $guestGroup = $this->checkExistGuestGroup($guestGroupData);
                            $guestData = [
                                'user_id' => $userId,
                                'guest_group_id' => $guestGroup->id,
                                'khmer_name' => $khmerName,
                                'english_name' => $excelRow->get('khmer_name', ''),
                                'phone' => $excelRow->get('phone_number', ''),
                                'print_name' => $printName,
                                'address' => $excelRow->get('address', '')
                            ];
                            $guest = $this->guestRepository->create($guestData);
                        }
                    }
                }
            } else {
                Flash::success('Please, upload excel file (.xlsx)');
                return $this->redirectTo('import');
            }
        }

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

    /**
     * @param string $name
     * @return GuestGroup|null
     */
    private function checkExistGuestGroup($name)
    {
        if ($name === '') {
            $name = 'General';
        }

        /** @var GuestGroup|null $guestGroup */
        $guestGroup = $this->guestGroupRepository->findWhere(['name' => $name])->first();
        if (empty($guestGroup)) {
            $guestGroup = $this->guestGroupRepository->create([
                'name' => $name
            ]);
        }

        return $guestGroup;
    }
}
