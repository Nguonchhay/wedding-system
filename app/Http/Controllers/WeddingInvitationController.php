<?php
namespace App\Http\Controllers;


use App\Models\WeddingInvitation;
use App\Repositories\WeddingInvitationRepository;
use App\Repositories\WeddingRepository;
use Illuminate\Http\Request;
use Response;

class WeddingInvitationController extends AppBaseController
{
    /** @var WeddingRepository */
    private $weddingRepository;

    /** @var WeddingInvitationRepository */
    private $weddingInvitationRepository;



    /**
     * @param WeddingRepository $weddingRepository
     * @param WeddingInvitationRepository $weddingInvitationRepository
     */
    public function __construct(WeddingRepository $weddingRepository, WeddingInvitationRepository $weddingInvitationRepository)
    {
        parent::__construct();
        $this->weddingRepository = $weddingRepository;
        $this->weddingInvitationRepository = $weddingInvitationRepository;
        $this->activeMenu = ['active' => 'home', 'subMenu' => ''];
        $this->viewPath = 'wedding_invitations.';
        $this->routePath = 'wedding_invitations.';
    }

    /**
     * @param string $wedding_id
     * @param Request $request
     *
     * @return Response
     */
    public function index($wedding_id, Request $request) {
        $wedding = $this->weddingRepository->findWithoutFail($wedding_id);
        if (empty($wedding)) {
            return redirect(route('weddings.index'));
        }

        $weddingInvitations = $this->weddingInvitationRepository->findWhere([
            'wedding_id' => $wedding->id
        ]);

        return $this->assignToView('Invited guests', 'index', [
            'wedding' => $wedding,
            'weddingInvitations' => $weddingInvitations
        ]);
    }

    /**
     * @param string $id
     *
     * @return Response
     */
    public function record($id)
    {
        $wedding = $this->weddingRepository->findWithoutFail($id);
        if (empty($wedding)) {
            return redirect(route('weddings.index')) ;
        }

        $weddingInvitations = $this->weddingInvitationRepository->getInvitingGuestsByWedding($wedding);
        return $this->assignToView('Recording guest gift', 'record', [
            'wedding' => $wedding,
            'weddingInvitations' => $weddingInvitations
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function recordAjax(Request $request)
    {
        $status = 400;
        if (!$request->has('weddingInvitation') || !$request->has('dollar') || !$request->has('khmer') || !$request->has('other')) {
            // Throw something
        } else {
            $input = $request->all();
            /** @var WeddingInvitation|null $weddingInvitation */
            $weddingInvitation = $this->weddingInvitationRepository->findWithoutFail($input['weddingInvitation']);
            if (!empty($weddingInvitation)) {
                unset($input['weddingInvitation']);
                $weddingInvitation = $this->weddingInvitationRepository->update($input, $weddingInvitation->id);
                $status = 200;
            }
        }

        if($request->ajax()){
            return response()->json([
                'status' => $status
            ]);
        }
    }
}
