<?php
namespace App\Http\Controllers;

use App\Http\Requests\CreateExpenseRequest;
use App\Http\Requests\UpdateExpenseRequest;
use App\Models\Expense;
use App\Models\Wedding;
use App\Repositories\ExpenseDetailRepository;
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

    /** @var ExpenseDetailRepository */
    private $expenseDetailRepository;

    /**
     * @var WeddingRepository
     */
    private $weddingRepository;

    /**
     * @param ExpenseRepository $expenseRepository
     * @param ExpenseDetailRepository $expenseDetailRepository
     * @param WeddingRepository $weddingRepository
     */
    public function __construct(ExpenseRepository $expenseRepository, ExpenseDetailRepository $expenseDetailRepository, WeddingRepository $weddingRepository)
    {
        parent::__construct();
        $this->expenseRepository = $expenseRepository;
        $this->expenseDetailRepository = $expenseDetailRepository;
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

        $totalExpenses = [];
        /** @var Wedding $wedding */
        foreach ($weddings as $wedding) {
            $totalExpenses[$wedding->title] = $this->expenseRepository->getTotalExpenseByWedding($wedding->id);
        }

        return $this->assignToView('Expense List', 'index', [
            'expenses' => $expenses,
            'totalExpenses' => $totalExpenses
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
            $weddings = $this->weddingRepository->findWhere(['user_id' => $authUser->id])->pluck('title', 'id');
        }

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
        if (!$request->has('date') || !$request->has('dollar') || !$request->has('khmer') || !$request->has('who')) {
            Flash::success('Please fill necessary information.');
            return redirect(route('expenses.index'));
        }

        $input = $request->all();
        if ($input['dollar'] == 0 && $input['khmer']) {
            Flash::success('Please fill necessary information.');
            return redirect(route('expenses.index'));
        }

        $expenseData = [
            'wedding_id' => $input['wedding_id'],
            'title' => $input['title']
        ];
        $expense = $this->expenseRepository->create($expenseData);

        $expenseDetailData = [
            'expense_id' => $expense->id,
            'who' => $input['who'],
            'date' => $input['date'],
            'dollar' => $input['dollar'],
            'khmer' => $input['khmer'],
            'note' => $input['note']
        ];
        $expenseDetail = $this->expenseDetailRepository->create($expenseDetailData);

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

        /** @var User $authUser */
        $authUser = Auth::user();
        if ($authUser->hasRole('super_admin')) {
            $weddings = $this->weddingRepository->pluck('title', 'id');
        } else {
            $weddings = $this->weddingRepository->findWhere(['user_id' => $authUser->id])->pluck('title', 'id');
        }

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
