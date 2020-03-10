<?php namespace App\Invoicer\Repositories\Eloquent;
use App\Invoicer\Repositories\Contracts\PaymentInterface;
class PaymentRepository extends BaseRepository implements PaymentInterface{
    /**
     * @return string
     */
    public function model() {
        return 'App\Models\Payment';
    }
    /**
     * @return mixed
     */
    public function totalIncome(){
        $query = "SELECT amount, currency FROM payments JOIN invoices ON invoices.uuid = payments.invoice_id";
        $payments =  \DB::select($query);
        $total = 0;
        foreach ($payments as $payment){
            $total += str_replace(',','',currency_convert(getCurrencyId($payment->currency),$payment->amount));
        }
        return round($total,2);
    }
    public function clientTotalPaid($client){
        $query = "SELECT amount, currency FROM payments JOIN invoices ON invoices.uuid = payments.invoice_id WHERE invoices.client_id = '$client'";
        $payments =  \DB::select($query);
        $total = 0;
        foreach ($payments as $payment){
            $total += str_replace(',','',currency_convert(getCurrencyId($payment->currency),$payment->amount));
        }
        return round($total,2);
    }
    public function yearlyIncome(){
        $query = "SELECT COUNT(i.uuid) AS payments_count, m.month,m.month_num
                  FROM (
                         SELECT 'Jan' AS MONTH, 1 AS month_num
                         UNION SELECT 'Feb' AS MONTH, 2 AS month_num
                         UNION SELECT 'Mar' AS MONTH, 3 AS month_num
                         UNION SELECT 'Apr' AS MONTH, 4 AS month_num
                         UNION SELECT 'May' AS MONTH, 5 AS month_num
                         UNION SELECT 'Jun' AS MONTH, 6 AS month_num
                         UNION SELECT 'Jul' AS MONTH, 7 AS month_num
                         UNION SELECT 'Aug' AS MONTH, 8 AS month_num
                         UNION SELECT 'Sep' AS MONTH, 9 AS month_num
                         UNION SELECT 'Oct' AS MONTH, 10 AS month_num
                         UNION SELECT 'Nov' AS MONTH, 11 AS month_num
                         UNION SELECT 'Dec' AS MONTH, 12 AS month_num
                  ) AS m
                  LEFT JOIN payments i ON MONTH(STR_TO_DATE(CONCAT(m.month, YEAR(CURRENT_DATE)),'%M %Y')) = MONTH(i.payment_date) AND YEAR(i.payment_date) = YEAR(CURRENT_DATE)
                  GROUP BY m.month ORDER BY m.month_num ASC";
        $earnings =  \DB::select($query);
        return $earnings;
    }
    public function clientYearlyIncome($client){
        $query = "SELECT COUNT(i.uuid) AS payments_count, m.month,m.month_num
                  FROM (
                         SELECT 'Jan' AS MONTH, 1 AS month_num
                         UNION SELECT 'Feb' AS MONTH, 2 AS month_num
                         UNION SELECT 'Mar' AS MONTH, 3 AS month_num
                         UNION SELECT 'Apr' AS MONTH, 4 AS month_num
                         UNION SELECT 'May' AS MONTH, 5 AS month_num
                         UNION SELECT 'Jun' AS MONTH, 6 AS month_num
                         UNION SELECT 'Jul' AS MONTH, 7 AS month_num
                         UNION SELECT 'Aug' AS MONTH, 8 AS month_num
                         UNION SELECT 'Sep' AS MONTH, 9 AS month_num
                         UNION SELECT 'Oct' AS MONTH, 10 AS month_num
                         UNION SELECT 'Nov' AS MONTH, 11 AS month_num
                         UNION SELECT 'Dec' AS MONTH, 12 AS month_num
                  ) AS m
                  LEFT JOIN payments i ON MONTH(STR_TO_DATE(CONCAT(m.month, YEAR(CURRENT_DATE)),'%M %Y')) = MONTH(i.payment_date) AND YEAR(i.payment_date) = YEAR(CURRENT_DATE)
                  LEFT JOIN invoices ON invoices.uuid = i.invoice_id  AND invoices.client_id = '$client' GROUP BY m.month ORDER BY m.month_num ASC";
        $earnings =  \DB::select($query);
        return $earnings;
    }
    public function clientYearlyInvoices($client){
        $query = "SELECT COUNT(i.uuid) AS invoice_count, m.month,m.month_num
                  FROM (
                         SELECT 'Jan' AS MONTH, 1 AS month_num
                         UNION SELECT 'Feb' AS MONTH, 2 AS month_num
                         UNION SELECT 'Mar' AS MONTH, 3 AS month_num
                         UNION SELECT 'Apr' AS MONTH, 4 AS month_num
                         UNION SELECT 'May' AS MONTH, 5 AS month_num
                         UNION SELECT 'Jun' AS MONTH, 6 AS month_num
                         UNION SELECT 'Jul' AS MONTH, 7 AS month_num
                         UNION SELECT 'Aug' AS MONTH, 8 AS month_num
                         UNION SELECT 'Sep' AS MONTH, 9 AS month_num
                         UNION SELECT 'Oct' AS MONTH, 10 AS month_num
                         UNION SELECT 'Nov' AS MONTH, 11 AS month_num
                         UNION SELECT 'Dec' AS MONTH, 12 AS month_num
                  ) AS m
                  LEFT JOIN invoices i ON MONTH(STR_TO_DATE(CONCAT(m.month, YEAR(CURRENT_DATE)),'%M %Y')) = MONTH(i.invoice_date) AND YEAR(i.invoice_date) = YEAR(CURRENT_DATE) AND i.client_id = '$client'
                  GROUP BY m.month ORDER BY m.month_num ASC";
        $earnings =  \DB::select($query);
        return $earnings;
    }
    public function payment_summary($client = 'all', $from_date = '', $to_date = ''){
        $query = "SELECT payments.*, invoices.client_id, payment_methods.name AS method_name, clients.name AS client_name, invoices.number,invoices.currency FROM payments
                  LEFT JOIN payment_methods ON payment_methods.uuid = payments.method
                  JOIN invoices ON invoices.uuid = payments.invoice_id
                  JOIN clients ON clients.uuid = invoices.client_id ";
       $where = '';
        if($client != 'all' && $client != '') {
            $where .= " WHERE invoices.client_id = '$client'";
        }
        if($from_date != '' && $to_date != '') {
            if($where == ''){
                $where .= " WHERE payment_date >= '".date('Y-m-d', strtotime($from_date))."' AND payment_date <= '".date('Y-m-d', strtotime($to_date))."'";
            }
            else{
                $where .= " AND payment_date >= '".date('Y-m-d', strtotime($from_date))."' AND payment_date <= '".date('Y-m-d', strtotime($to_date))."'";
            }
        }
       // echo $client; exit;
        $query .= $where.' ORDER BY payments.payment_date DESC';
        $payments =  \DB::select($query);
        return $payments;
    }

}