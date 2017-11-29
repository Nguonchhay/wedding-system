<?php

namespace App\Repositories;

use App\Models\Guest;
use App\Models\Wedding;
use InfyOm\Generator\Common\BaseRepository;
use App\User;
use DB;

class GuestRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'full_name',
        'print_name',
        'note',
        'dollar',
        'khmer'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Guest::class;
    }

    /**
     * @param User $user
     * @param Wedding $wedding
     *
     * @return array
     */
    public function findUnInvitedGuests($user, $wedding)
    {
        /* Find all booking rooms */
        $weddingInvitations = DB::table('wedding_invitations')
            ->join('weddings', 'wedding_invitations.wedding_id', '=', 'weddings.id')
            ->whereNull('weddings.deleted_at')
            ->where('weddings.id', $wedding->id)
            ->get(['wedding_invitations.guest_id']);

        $invitedGuests = [];
        foreach ($weddingInvitations as $weddingInvitation) {
            $invitedGuests[] = $weddingInvitation->guest_id;
        }

        $unInvitedGuests = DB::table('guests')
            ->select('guests.id', 'guests.khmer_name', 'guests.english_name', 'guests.print_name', 'guests.phone')
            ->join('users', 'guests.user_id', '=', 'users.id')
            ->where('users.id', '=', $user->id)
            ->whereNull('guests.deleted_at')
            ->whereNotIn('guests.id', $invitedGuests)
            ->orderBy('guests.english_name')
            ->get();

        return $unInvitedGuests;
    }
}
