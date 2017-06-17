<?php

use App\Models\AccountType;
use App\Repositories\AccountRepository;
use App\Repositories\AccountTypeRepository;
use App\Repositories\UserRepository;
use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder {

	/**
	 * @var UserRepository
	 */
	private $userRepository;

	/**
	 * @var AccountRepository
	 */
	private $accountRepository;

	/**
	 * @var AccountTypeRepository
	 */
	private $accountTypeRepository;


	/**
	 * @param UserRepository $userRepository
	 * @param AccountRepository $accountRepository
	 * @param AccountTypeRepository $accountTypeRepository
	 */
	public function __construct(UserRepository $userRepository, AccountRepository $accountRepository, AccountTypeRepository $accountTypeRepository) {
		$this->userRepository = $userRepository;
		$this->accountRepository = $accountRepository;
		$this->accountTypeRepository = $accountTypeRepository;
	}

	/**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
		/** @var AccountType $basicAccount */
		$basicAccount = $this->accountTypeRepository->findWhere(['name' => 'Basic'])->first();
		if (empty($basicAccount)) {
			echo "\n- No account type is found in the system. System cannot operate. \n";
			exit(1);
		}

        $users = [
            [
				'role' => 'admin',
				'name' => 'Admin',
				'email' => 'admin@reasei.com',
                'password' => bcrypt('admin@12354')
            ],
			[
				'role' => 'user',
				'name' => 'User',
				'email' => 'user@reasei.com',
				'password' => bcrypt('user')
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

			if (empty($queryUser->account)) {
				$accountData = [
					'user_id' => $queryUser->id,
					'account_type_id' => $basicAccount->id
				];
				$account = $this->accountRepository->create($accountData);
				$message = "   - Initialize account name: " . $user['name'] . "\n";
			}

		}
		echo $message . "\n";
    }
}
