<?php
namespace App\Http\Controllers;

use App\Http\Requests\CreateWeddingRequest;
use App\Http\Requests\UpdateWeddingRequest;
use App\Models\Wedding;
use App\Models\WeddingInvitation;
use App\Repositories\GuestRepository;
use App\Repositories\WeddingInvitationRepository;
use App\Repositories\WeddingRepository;
use App\User;
use App\Utility\Files;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Auth;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class WeddingController extends AppBaseController
{
    /** @var WeddingRepository */
    private $weddingRepository;

    /** @var GuestRepository */
    private $guestRepository;

    /** @var WeddingInvitationRepository */
    private $weddingInvitationRepository;



    /**
     * @param WeddingRepository $weddingRepository
     * @param GuestRepository $guestRepository
     * @param WeddingInvitationRepository $weddingInvitationRepository
     */
    public function __construct(WeddingRepository $weddingRepository, GuestRepository $guestRepository, WeddingInvitationRepository $weddingInvitationRepository) {
        parent::__construct();
        $this->weddingRepository = $weddingRepository;
        $this->guestRepository = $guestRepository;
        $this->weddingInvitationRepository = $weddingInvitationRepository;
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

        /** @var User $authUser */
        $authUser = Auth::user();
        if ($authUser->hasRole('super_admin')) {
            $weddings = $this->weddingRepository->all();
        } else if ($authUser->hasRole('admin')) {
            $weddings = $this->weddingRepository->findWhere(['user_id' => $authUser->id]);
        } else {
            $weddings = $this->weddingRepository->findWhere(['user_id' => $authUser->created_by]);
        }

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
        $imagePrefix = Wedding::getPrefixImage();
        $imageBasePath = Wedding::getBaseImagePath();
        $input['groom_image'] = Files::saveUploadImage('groom_image', $imagePrefix, $imageBasePath);
        $input['bride_image'] = Files::saveUploadImage('bride_image', $imagePrefix, $imageBasePath);

        $wedding = $this->weddingRepository->create($input);
        Flash::success('Wedding saved successfully.');
        return $this->redirectToIndex();
    }

    /**
     * @param string $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Wedding $wedding */
        $wedding = $this->checkExistWedding($id);
        return $this->assignToView('Wedding detail', 'show', [
            'wedding' => $wedding
        ]);
    }

    /**
     * @param string $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var Wedding $wedding */
        $wedding = $this->checkExistWedding($id);
        return $this->assignToView('Edit Wedding', 'edit', [
            'wedding' => $wedding
        ]);
    }

    /**
     * Update the specified Wedding in storage.
     *
     * @param string $id
     * @param UpdateWeddingRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateWeddingRequest $request)
    {
        /** @var Wedding $wedding */
        $wedding = $this->checkExistWedding($id);

        $input = $request->all();
        $imagePrefix = Wedding::getPrefixImage();
        $imageBasePath = Wedding::getBaseImagePath();
        $input['groom_image'] = Files::saveEditUploadImage($input, $wedding->groom_image, 'groom_image', $imagePrefix, $imageBasePath, 'imageIsDelete');
        $input['bride_image'] = Files::saveEditUploadImage($input, $wedding->bride_image, 'bride_image', $imagePrefix, $imageBasePath, 'welcomeImageIsDelete');

        /**
         * Clean update the uploaded image
         */
        if (isset($input['groomImageIsDelete']) && intval($input['groomImageIsDelete']) == 1) {
            Files::delete($wedding->groom_image);
        } else {
            if ($input['groom_image'] !== $wedding->groom_image) {
                Files::delete($wedding->groom_image);
            }
        }

        if (isset($input['brideImageIsDelete']) && intval($input['brideImageIsDelete']) == 1) {
            Files::delete($wedding->groom_image);
        } else {
            if ($input['bride_image'] !== $wedding->bride_image) {
                Files::delete($wedding->bride_image);
            }
        }

        $wedding = $this->weddingRepository->update($input, $id);
        Flash::success('Wedding updated successfully.');
        return $this->redirectToIndex();
    }

    /**
     * Remove the specified Wedding from storage.
     *
     * @param string $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Wedding $wedding */
        $wedding = $this->checkExistWedding($id);
        $this->weddingRepository->delete($id);
        Files::delete($wedding->groom_image);
        Files::delete($wedding->bride_image);

        Flash::success('Wedding deleted successfully.');
        return $this->redirectToIndex();
    }

    /**
     * @param $id
     *
     * @return Wedding|null
     */
    public function checkExistWedding($id)
    {
        /** @var Wedding|null $wedding */
        $wedding = $this->weddingRepository->findWithoutFail($id);
        if (empty($wedding)) {
            Flash::error('Wedding not found');
            return redirect(route('weddings.index'));
        }
        return $wedding;
    }

    /**
     * @param string $id
     *
     * @return Response
     */
    public function invite($id)
    {
        /** @var Wedding $wedding */
        $wedding = $this->checkExistWedding($id);
        $uninvitedGuests = $this->guestRepository->findUnInvitedGuests(Auth::user(), $wedding);
        return $this->assignToView('Invite guests to wedding', 'invite', [
            'wedding' => $wedding,
            'guests' => $uninvitedGuests
        ]);
    }

    /**
     * @param string $id
     * @param Request $request
     *
     * @return Response
     */
    public function inviteGuest($id, Request $request)
    {
        /** @var Wedding $wedding */
        $wedding = $this->checkExistWedding($id);
        $selectedGuests = $request->get('guests');

        if ($selectedGuests) {
            foreach ($selectedGuests as $selectedGuest) {
                $weddingGuestData = [
                    'wedding_id' => $wedding->id,
                    'guest_id' => $selectedGuest
                ];
                $weddingInvitation = $this->weddingInvitationRepository->create($weddingGuestData);
            }
            return redirect(route('wedding_invitations.index', $wedding->id));
        }
        return $this->redirectToIndex();
    }
}
