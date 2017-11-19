<?php

use App\Repositories\UserRepository;
use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder {

	/**
	 * @var UserRepository
	 */
	private $userRepository;


	/**
	 * @param UserRepository $userRepository
	 */
	public function __construct(UserRepository $userRepository) {
		$this->userRepository = $userRepository;
	}

	/**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $users = [
            [
				'role' => 'super_admin',
				'name' => 'Super Admin',
				'email' => 'info@reasei.com',
				'password' => bcrypt('admin@12354')
			]
		];

		$message = "\n- No users were initialized. \n";
        foreach ($users as $user) {
			/** @var User $queryUser */
			$queryUser = $this->userRepository->findWhere(['email' => $user['email']])->first();
			if (empty($queryUser)) {
				$queryUser = $this->userRepository->create($user);
				$message = "\n- Initialize user: " . $user['name'] . "\n";
			}
		}
		echo $message . "\n";
	}
}
