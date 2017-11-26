<?php
namespace App\Http\Controllers;

use App\Http\Requests\CreateExpenseRequest;
use App\Http\Requests\UpdateExpenseRequest;
use App\Models\Expense;
use App\Models\Wedding;
use App\Repositories\ExpenseRepository;
use App\Repositories\WeddingRepository;
use App\User;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Auth;
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
        $this->activeMenu = ['active' => 'expense', 'subMenu' => ''];
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

        /** @var User $authUser */
        $authUser = Auth::user();
        if ($authUser->hasRole('super_admin')) {
            $expenses = $this->expenseRepository->orderBy('wedding_id')->all();
            $weddings = $this->weddingRepository->all();
        } else {
            $weddings = $this->weddingRepository->findWhere(['user_id' => $authUser->id]);

            $expenses = [];
            /** @var Wedding $wedding */
            foreach ($weddings as $wedding) {
                $queryExpenses = $this->expenseRepository->findWhere(['wedding_id' => $wedding->id]);
                foreach ($queryExpenses as $queryExpense) {
                    $expenses[] = $queryExpense;
                }
            }
        }

        $weddingExpenses = [];
        /** @var Wedding $wedding */
        foreach ($weddings as $wedding) {
            $weddingExpenses[$wedding->title] = $this->expenseRepository->getTotalExpenseByWedding($wedding->id);
        }

        return $this->assignToView('Expense List', 'index', [
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
        /** @var User $authUser */
        $authUser = Auth::user();
        if ($authUser->hasRole('super_admin')) {
            $weddings = $this->weddingRepository->pluck('title', 'id');
        } else {
            $weddings = $this->weddingRepository->findWhere(['user_id' => $authUser->id])->pluck(['id', 'title']);
        }

        return $this->assignToView('Expense List', 'create', [
            'weddings' => $weddings,
            'selectedWedding' => null,
            'selectedCurrency' => ''
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
            'selectedWedding' => $expense->wedding_id,
            'selectedCurrency' => $expense->currency
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
