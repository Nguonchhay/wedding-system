<?php

use App\Repositories\AccountTypeRepository;
use Illuminate\Database\Seeder;
use App\Models\AccountType;

class AccountTypesTableSeeder extends Seeder {

	/**
	 * @var AccountTypeRepository
	 */
	private $accountTypeRepository;


	/**
	 * @param AccountTypeRepository $accountTypeRepository
	 */
	public function __construct(AccountTypeRepository $accountTypeRepository) {
		$this->accountTypeRepository = $accountTypeRepository;
	}

	/**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $accountTypes = [
            [
				'name' => 'Basic',
				'wedding_count' => 1
            ]
        ];

		$message = "\n- No Account Type were initialized. \n";
        foreach ($accountTypes as $accountType) {
			/** @var AccountType $queryAccountType */
			$queryAccountType = $this->accountTypeRepository->findWhere(['name' => $accountType['name']])->first();
			if (empty($queryAccountType)) {
				$queryUser = $this->accountTypeRepository->create($accountType);
				$message = "   - Initialize account_type: " . $accountType['name'] . "\n";
			}
        }
		echo $message . "\n";
    }
}
