<?php
namespace App\Http\Controllers;

use App\Models\Wedding;
use App\Models\WeddingInvitation;
use App\Repositories\WeddingInvitationRepository;
use App\Repositories\WeddingRepository;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Response;
use Flash;
use Excel;

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
     * @param $id
     * @return Response
     */
    public function edit($id)
    {
        /** @var User $authUser */
        $authUser = Auth::user();
        if ($authUser->hasRole('user')) {
            return $this->redirectToIndex();
        }

        $weddingInvitation = $this->weddingInvitationRepository->findWithoutFail($id);
        return $this->assignToView('Edit wedding gift', 'edit', [
            'weddingInvitation' => $weddingInvitation
        ]);
    }

    /**
     * @param string $id
     * @param Request $request
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        $weddingInvitation = $this->weddingInvitationRepository->findWithoutFail($id);
        $weddingInvitationData = [];

        $updateField = ['dollar', 'khmer', 'other'];
        foreach ($updateField as $field) {
            if ($request->has($field)) {
                $weddingInvitationData[$field] = $request->get($field);
            }
        }

        if (count($weddingInvitationData)) {
            $weddingInvitation = $this->weddingInvitationRepository->update($weddingInvitationData, $weddingInvitation->id);
        }

        Flash::success('Wedding gift was update successfully.');
        return redirect(route($this->routePath . 'index', [$weddingInvitation->wedding->id]));
    }

    /**
     * @param string $wedding_id
     * @return Response
     */
    public function exportGuestNameForWeddingLetter($wedding_id)
    {
        /** @var Wedding $wedding */
        $wedding = $this->weddingRepository->findWithoutFail($wedding_id);
        if (empty($wedding)) {
            return redirect(route($this->routePath . 'index'));
        }

        $tempExcel = $wedding->title . date('d-m-Y');
        /* Set header */
        $data[0] = [$wedding->title . ': Guest List'];
        $data[] = ['No', 'Guest Print Name'];

        $index = 1;
        /** @var WeddingInvitation $weddingInvitation */
        foreach ($wedding->wedding_invitations as $weddingInvitation) {
            $data[] = [
                $index++,
                $weddingInvitation->guest->print_name
            ];
        }
        $index += 4;

        Excel::create($tempExcel, function($excel) use($data, $index) {
            $excel->sheet('Wedding Guest List', function($sheet) use($data, $index) {
                $sheet->setWidth([
                    'A'     =>  5,
                    'B'     =>  50
                ]);

                $sheet->mergeCells('A2:B2');
                $sheet->cells('A2:B2', function($cells) {
                    $cells->setFont([
                        'family'     => 'KhmerOs',
                        'size'       => '16',
                        'bold'       =>  true
                    ]);
                });

                $sheet->cells('A3:B3', function($cells) {
                    $cells->setFontWeight('bold');
                });

                $sheet->fromArray($data);
            });
        })->export('xlsx');

        return redirect(route($this->routePath . 'index', $wedding_id)) ;
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
