<?php
namespace App\Http\Controllers;

use App\Http\Requests\CreateGuestRequest;
use App\Http\Requests\UpdateGuestRequest;
use App\Models\Guest;
use App\Models\GuestGroup;
use App\Repositories\GuestGroupRepository;
use App\Repositories\GuestRepository;
use App\Repositories\WeddingInvitationRepository;
use App\Repositories\WeddingRepository;
use App\User;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Auth;
use Excel;
use Illuminate\Support\Facades\Input;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class GuestController extends AppBaseController
{
    /** @var GuestRepository */
    private $guestRepository;

    /** @var GuestGroupRepository */
    private $guestGroupRepository;

    /** @var WeddingRepository */
    private $weddingRepository;

    /** @var WeddingInvitationRepository */
    private $weddingInvitationRepository;



    /**
     * @param GuestRepository $guestRepository
     * @param GuestGroupRepository $guestGroupRepository
     * @param WeddingRepository $weddingRepository
     * @param WeddingInvitationRepository $weddingInvitationRepository
     */
    public function __construct(GuestRepository $guestRepository, GuestGroupRepository $guestGroupRepository, WeddingRepository $weddingRepository, WeddingInvitationRepository $weddingInvitationRepository) {
        parent::__construct();
        $this->guestRepository = $guestRepository;
        $this->guestGroupRepository = $guestGroupRepository;
        $this->weddingRepository = $weddingRepository;
        $this->weddingInvitationRepository = $weddingInvitationRepository;
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
        /** @var User $authUser */
        $authUser = Auth::user();
        $guestGroups = $this->guestGroupRepository->pluck('name', 'id')->prepend('Select guest group', '');

        $selectedGroup = $request->get('group', null);
        if ($selectedGroup !== null) {
            $guests = $this->guestRepository->findWhere([
                'user_id' => $authUser->id,
                'guest_group_id' => $selectedGroup
            ]);
        } else {
            $guests = $this->guestRepository->findWhere(['user_id' => $authUser->id]);
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
        /** @var User $authUser */
        $authUser = Auth::user();
        if ($authUser->hasRole('super_admin')) {
            $weddings = $this->weddingRepository->pluck('title', 'id');
        } else {
            $weddings = $this->weddingRepository->findWhere(['user_id' => $authUser->id])->pluck('title', 'id');
        }

        $guestGroups = $this->guestGroupRepository->pluck('name', 'id');
        return $this->assignToView('New guest', 'create', [
            'guestGroups' => $guestGroups,
            'weddings' => $weddings
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

        $isInvite = $request->get('is_invite', false);
        $weddingId = $request->get('wedding_id', '');
        if ($isInvite && $weddingId !== '') {
            $weddingInvitation = $this->weddingInvitationRepository->create([
                'wedding_id' => $weddingId,
                'guest_id' => $guest->id,
            ]);
        }

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
        /** @var User $authUser */
        $authUser = Auth::user();
        if ($authUser->hasRole('super_admin')) {
            $weddings = $this->weddingRepository->pluck('title', 'id');
        } else {
            $weddings = $this->weddingRepository->findWhere(['user_id' => $authUser->id])->pluck('title', 'id');
        }

        return $this->assignToView('Import guests', 'import', [
            'weddings' => $weddings
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function importGuest(Request $request)
    {
        $isInvite = $request->get('is_invite', false);
        $weddingId = $request->get('wedding_id', '');

        if ($request->hasFile('import_file')) {
            $extensions = explode('.', Input::file('import_file')->getClientOriginalName());
            if (end($extensions) === "xlsx") {
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
                        $guestGroupData = trim($excelRow->get('guest_group', ''));
                        $englishName = trim($excelRow->get('english_name', ''));
                        $khmerName = trim($excelRow->get('khmer_name', ''));
                        if ($khmerName === '' && $englishName === '') {
                            continue;
                        }

                        $guestGroup = $this->checkExistGuestGroup($guestGroupData);
                        $guestData = [
                            'user_id' => $userId,
                            'guest_group_id' => $guestGroup->id,
                            'khmer_name' => $khmerName,
                            'english_name' => $englishName,
                            'phone' => $excelRow->get('phone_number', ''),
                            'print_name' => $excelRow->get('print_name', ''),
                            'address' => $excelRow->get('address', '')
                        ];
                        $guest = $this->guestRepository->create($guestData);

                        if ($isInvite && $weddingId !== '') {
                            $weddingInvitation = $this->weddingInvitationRepository->create([
                                'wedding_id' => $weddingId,
                                'guest_id' => $guest->id,
                            ]);
                        }
                    }
                }
            } else {
                Flash::success('Please, upload excel file (.xlsx)');
                return $this->redirectTo('import');
            }
        }

        if ($isInvite && $weddingId !== '') {
            return redirect(route('wedding_invitations.index', [$weddingId]));
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
