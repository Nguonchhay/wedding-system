<?php

use App\Models\GuestGroup;
use App\Repositories\GuestGroupRepository;
use App\User;
use Illuminate\Database\Seeder;

class GuestGroupsTableSeeder extends Seeder {

    /**
     * @var GuestGroupRepository
     */
    private $guestGroupRepository;


    /**
     * @param GuestGroupRepository $guestGroupRepository
     */
    public function __construct(GuestGroupRepository $guestGroupRepository) {
        $this->guestGroupRepository = $guestGroupRepository;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $guestGroups = [
            [
                'name' => 'General'
            ]
        ];

        $message = "\n- No guest group(s) were initialized. \n";
        foreach ($guestGroups as $guestGroup) {
            /** @var GuestGroup $queryGuestGroup */
            $queryGuestGroup = $this->guestGroupRepository->findWhere(['name' => $guestGroup['name']])->first();
            if (empty($queryGuestGroup)) {
                $queryGuestGroup = $this->guestGroupRepository->create($guestGroup);
                $message = "\n- Initialize guest group: " . $guestGroup['name'] . "\n";
            }
        }
        echo $message . "\n";
    }
}
