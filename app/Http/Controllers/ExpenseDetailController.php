<?php
namespace App\Http\Controllers;

use App\Http\Requests\CreateExpenseDetailRequest;
use App\Http\Requests\UpdateExpenseDetailRequest;
use App\Models\Expense;
use App\Repositories\ExpenseDetailRepository;
use App\Http\Controllers\AppBaseController;
use App\Repositories\ExpenseRepository;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class ExpenseDetailController extends AppBaseController
{
    /** @var ExpenseDetailRepository */
    private $expenseDetailRepository;

    /** @var ExpenseRepository */
    private $expenseRepository;

    /**
     * ExpenseDetailController constructor.
     * @param ExpenseDetailRepository $expenseDetailRepository
     * @param ExpenseRepository $expenseRepository
     */
    public function __construct(ExpenseDetailRepository $expenseDetailRepository, ExpenseRepository $expenseRepository)
    {
        parent::__construct();
        $this->expenseDetailRepository = $expenseDetailRepository;
        $this->expenseRepository = $expenseRepository;
        $this->activeMenu = ['active' => 'expense', 'subMenu' => ''];
        $this->viewPath = 'expense_details.';
        $this->routePath = 'expense_details.';
    }

    /**
     * @param $expense
     *
     * @return Response
     */
    public function create($expense)
    {
        /** @var Expense $selectExpense */
        $selectedExpense = $this->expenseRepository->findWithoutFail($expense);
        if (empty($selectedExpense)) {
            Flash::error('Expense not found');
            return redirect(route('expenses.index'));
        }

        return $this->assignToView($selectedExpense->title . ': New expense detail', 'create', [
            'selectedExpense' => $selectedExpense,
            'selectedCurrency' => ''
        ]);
    }

    /**
     * @param CreateExpenseDetailRequest $request
     *
     * @return Response
     */
    public function store(CreateExpenseDetailRequest $request)
    {
        $input = $request->all();

        /** @var Expense $selectExpense */
        $selectedExpense = $this->expenseRepository->findWithoutFail($input['expense_id']);
        if (empty($selectedExpense)) {
            Flash::error('Expense not found');
            return redirect(route('expenses.index'));
        }
        
        $expenseDetail = $this->expenseDetailRepository->create($input);
        Flash::success('Expense Detail saved successfully.');
        return redirect(route('expenses.index'));
    }

    /**
     * Show the form for editing the specified ExpenseDetail.
     *
     * @param string $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $expenseDetail = $this->expenseDetailRepository->findWithoutFail($id);
        if (empty($expenseDetail)) {
            Flash::error('Expense Detail not found');
            return redirect(route('expenseDetails.index'));
        }

        return $this->assignToView($expenseDetail->expense->title . ': Edit expense detail', 'edit', [
            'expenseDetail' => $expenseDetail,
            'selectedExpense' => $expenseDetail->expense,
            'selectedCurrency' => ''
        ]);
    }

    /**
     * @param string $id
     * @param UpdateExpenseDetailRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateExpenseDetailRequest $request)
    {
        $expenseDetail = $this->expenseDetailRepository->findWithoutFail($id);
        if (empty($expenseDetail)) {
            Flash::error('Expense Detail not found');
            return redirect(route('expenseDetails.index'));
        }

        $expenseDetail = $this->expenseDetailRepository->update($request->all(), $id);
        Flash::success('Expense Detail updated successfully.');

        return redirect(route('expenses.index'));
    }

    /**
     * @param string $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $expenseDetail = $this->expenseDetailRepository->findWithoutFail($id);
        if (empty($expenseDetail)) {
            Flash::error('Expense Detail not found');
            return redirect(route('expenseDetails.index'));
        }

        $this->expenseDetailRepository->delete($id);
        Flash::success('Expense Detail deleted successfully.');

        return redirect(route('expenses.index'));
    }
}
