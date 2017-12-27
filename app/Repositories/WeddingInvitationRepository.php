<?php
namespace App\Repositories;

use App\Models\Wedding;
use App\Models\WeddingInvitation;
use InfyOm\Generator\Common\BaseRepository;
use DB;

class WeddingInvitationRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'dollar',
        'khmer',
        'other'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return WeddingInvitation::class;
    }

    /**
     * @param Wedding $wedding
     * @return mixed
     */
    public function getInvitingGuestsByWedding($wedding)
    {
        $invitingGuests = DB::table('wedding_invitations')
            ->select(
                'wedding_invitations.id',
                'weddings.id AS wedding_id',
                'guests.id AS guest_id',
                'guests.khmer_name AS khmer_name',
                'guests.english_name AS english_name',
                'guests.phone AS phone',
                'guests.address AS address',
                'guests.print_name AS print_name'
            )
            ->join('weddings', 'wedding_invitations.wedding_id', '=', 'weddings.id')
            ->join('guests', 'wedding_invitations.guest_id', '=', 'guests.id')
            ->whereNull('weddings.deleted_at')
            ->whereNull('guests.deleted_at')
            ->where('wedding_id', '=', $wedding->id)
            ->where('dollar', '=', 0)
            ->where('khmer', '=', 0)
            ->get();

        return $invitingGuests;
    }

    /**
     * @param array $weddingInvitations
     * @param string $guestGroupId
     * 
     * @return array
     */
    public function filterByGuestGroup($weddingInvitations, $guestGroupId)
    {
        $filterdWeddingInvitations =  [];
        foreach ($weddingInvitations as $weddingInvitation) {
            if ($weddingInvitation->guest && $weddingInvitation->guest->guest_group_id == $guestGroupId) {
                $filterdWeddingInvitations[] = $weddingInvitation;
            }
        }
        return $filterdWeddingInvitations;
    }
}
