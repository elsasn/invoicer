<?php namespace App\Invoicer\Repositories\Eloquent;

use App\Invoicer\Repositories\Contracts\ExpenseInterface;

class ExpenseRepository extends BaseRepository implements ExpenseInterface{

    public function model() {
        return 'App\Models\Expense';
    }
    /**
     * @param $range
     * @return mixed
     */

    public function report($range){
        $invoice = $this->model();
        $stats = $invoice::where('expense_date', '>=', $range)
            ->groupBy('date')
            ->orderBy('date', 'DESC')
            ->get([
                \DB::raw('Date(expense_date) as date'),
                \DB::raw('SUM(amount) as value')
            ]);
        return $stats;
    }
    public function totalExpenses(){
        $query = "SELECT SUM(CASE WHEN MONTHNAME(expense_date) = 'January' THEN amount ELSE 0 END) AS Jan,
                            SUM(CASE WHEN MONTHNAME(expense_date) = 'February' THEN amount ELSE 0 END) AS Feb,
                            SUM(CASE WHEN MONTHNAME(expense_date) = 'March' THEN amount ELSE 0 END) AS Mar,
                            SUM(CASE WHEN MONTHNAME(expense_date) = 'April' THEN amount ELSE 0 END) AS Apr,
                            SUM(CASE WHEN MONTHNAME(expense_date) = 'May' THEN amount ELSE 0 END) AS May,
                            SUM(CASE WHEN MONTHNAME(expense_date) = 'June' THEN amount ELSE 0 END) AS Jun,
                            SUM(CASE WHEN MONTHNAME(expense_date) = 'July' THEN amount ELSE 0 END) AS Jul,
                            SUM(CASE WHEN MONTHNAME(expense_date) = 'August' THEN amount ELSE 0 END) AS Aug,
                            SUM(CASE WHEN MONTHNAME(expense_date) = 'September' THEN amount ELSE 0 END) AS Sept,
                            SUM(CASE WHEN MONTHNAME(expense_date) = 'October' THEN amount ELSE 0 END) AS Oct,
                            SUM(CASE WHEN MONTHNAME(expense_date) = 'November' THEN amount ELSE 0 END) AS Nov,
                            SUM(CASE WHEN MONTHNAME(expense_date) = 'December' THEN amount ELSE 0 END) AS Dece
                            FROM expenses WHERE YEAR(expense_date) = YEAR(CURRENT_DATE)";
        $expenses =  \DB::select($query);
        return $expenses;
    }

    public function expenses_report($category = 'all', $from_date = '', $to_date = ''){
        $query = "SELECT expenses.*,expense_categories.name AS category_name FROM expenses JOIN expense_categories ON expense_categories.uuid = expenses.category_id";
        $where = '';
        if($category != 'all' && $category != '') {
            $where .= " WHERE expenses.category_id = '$category'";
        }
        if($from_date != '' && $to_date != '') {
            if($where == ''){
                $where .= " WHERE expense_date >= '".date('Y-m-d', strtotime($from_date))."' AND expense_date <= '".date('Y-m-d', strtotime($to_date))."'";
            }
            else{
                $where .= " AND expense_date >= '".date('Y-m-d', strtotime($from_date))."' AND expense_date <= '".date('Y-m-d', strtotime($to_date))."'";
            }
        }
        // echo $client; exit;
        $query .= $where.' ORDER BY expenses.expense_date ASC';
        $expenses =  \DB::select($query);
        return $expenses;
    }
}