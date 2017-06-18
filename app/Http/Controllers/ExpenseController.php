<?php
namespace App\Http\Controllers;

use App\Http\Requests\CreateExpenseRequest;
use App\Http\Requests\UpdateExpenseRequest;
use App\Repositories\ExpenseRepository;
use App\Repositories\WeddingRepository;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class ExpenseController extends AppBaseController
{
	/**
	 * @var ExpenseRepository
	 */
    private $expenseRepository;

	/**
	 * @var WeddingRepository
	 */
	private $weddingRepository;

	/**
	 * @param ExpenseRepository $expenseRepository
	 * @param WeddingRepository $weddingRepository
	 */
    public function __construct(ExpenseRepository $expenseRepository, WeddingRepository $weddingRepository)
    {
		parent::__construct();
        $this->expenseRepository = $expenseRepository;
		$this->weddingRepository = $weddingRepository;
		$this->activeMenu = ['active' => 'guest', 'subMenu' => ''];
		$this->viewPath = 'expenses.';
		$this->routePath = 'expenses.';
    }

    /**
     * Display a listing of the Expense.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->expenseRepository->pushCriteria(new RequestCriteria($request));
        $expenses = $this->expenseRepository->orderBy('wedding_id')->all();

		$weddingIds = $this->weddingRepository->all(['id', 'groom_name']);
		$weddingExpenses = [];
		foreach ($weddingIds as $weddingId) {
			$weddingExpenses[$weddingId->groom_name] = $this->expenseRepository->getTotalExpenseByWedding($weddingId->id);
		}

		return $this->assignToView('Guest List', 'index', [
			'expenses' => $expenses,
			'weddingExpenses' => $weddingExpenses
		]);
    }

    /**
     * Show the form for creating a new Expense.
     *
     * @return Response
     */
    public function create()
    {
		$weddings = $this->weddingRepository->pluck('groom_name', 'id');
		return $this->assignToView('Expense List', 'create', [
			'weddings' => $weddings,
			'selectedWedding' => null
		]);
    }

    /**
     * Store a newly created Expense in storage.
     *
     * @param CreateExpenseRequest $request
     *
     * @return Response
     */
    public function store(CreateExpenseRequest $request)
    {
        $input = $request->all();
        $expense = $this->expenseRepository->create($input);
        Flash::success('Expense saved successfully.');
        return redirect(route('expenses.index'));
    }

    /**
     * @param string $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $expense = $this->expenseRepository->findWithoutFail($id);
        if (empty($expense)) {
            Flash::error('Expense not found');
            return redirect(route('expenses.index'));
        }

		$weddings = $this->weddingRepository->pluck('groom_name', 'id');
		return $this->assignToView('Edit expense', 'edit', [
			'expense' => $expense,
			'weddings' => $weddings,
			'selectedWedding' => $expense->wedding_id
		]);
    }

    /**
     * @param string $id
     * @param UpdateExpenseRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateExpenseRequest $request)
    {
        $expense = $this->expenseRepository->findWithoutFail($id);
        if (empty($expense)) {
            Flash::error('Expense not found');
            return redirect(route('expenses.index'));
        }

        $expense = $this->expenseRepository->update($request->all(), $id);
        Flash::success('Expense updated successfully.');
        return redirect(route('expenses.index'));
    }

    /**
     * @param string $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $expense = $this->expenseRepository->findWithoutFail($id);
        if (empty($expense)) {
            Flash::error('Expense not found');
            return redirect(route('expenses.index'));
        }

        $this->expenseRepository->delete($id);
        Flash::success('Expense deleted successfully.');
        return redirect(route('expenses.index'));
    }
}
