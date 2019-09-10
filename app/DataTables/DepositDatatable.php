<?php

namespace App\DataTables;

use App\Models\BackEnd\TemTransaction;
use Yajra\DataTables\Services\DataTable;

class DepositDatatable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables($query)
                ->addColumn('action',function($query){
                    $transactionId= $query->transactid;
                    $memberName = $query->players['reg_name'];
                    $memberId= $query->players['id'];
                    return view('backend.transaction.inc._actionbtn', compact('transactionId','memberName','memberId'));
                })
                ->editColumn('players.reg_name','<b>{{$players["reg_name"]}}</b><br/>{{$players["reg_username"]}}<br/>{{$players["reg_email"]}}')
                ->editColumn('bank_name', '<b>{{$bank_name}}</b><br/>{{$bank_acc_name}}<br/>{{$bank_acc_id}}')
                ->editColumn('deposit_bank_name', '<b>{{$deposit_bank_name}}</b><br/>{{$deposit_ac_name}}<br/>{{$deposit_ac_number}}')
                ->editColumn('transactid','{{$transactid}}<br/>{{$request_at}}')
                ->editColumn('amount', '<b style="float:right;font-size: 16px;">{{CommonFunction::_CurrencyFormat($amount)}}</b>')
                ->rawColumns(['check','players.reg_name','bank_name','deposit_bank_name','transactid','amount','action']);
            
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(TemTransaction $model)
    {
        return $model->with(['players'])->where('proc_type','deposit')->where('status',0);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->columns($this->getColumns())
                    ->postAjax()
                    ->parameters($this->getBuilderParameters());
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
           ['data' => 'id', 'name' => 'id', 'visible' => false, 'printable' => false, 'exportable' => false],
           ['data' => 'transactid', 'name' => 'transactid','title' => 'Transaction/Date'], 
           ['data' => 'players.reg_name', 'name' => 'players.reg_name','title' => 'Member'],
           ['data' => 'bank_name', 'name' => 'bank_name','title' => 'Member Bank'],
           ['data' => 'deposit_bank_name', 'name' => 'deposit_bank_name','title' => 'Deposit To'],
           ['data' => 'amount', 'name' => 'amount','title' => 'Amount'],
           ['data' => 'note', 'name' => 'note','title' => 'Note'],
           ['data' => 'ip', 'name' => 'ip','title' => 'IP'],
           ['data' => 'action', 'name' => 'action','title' => 'Action',"orderable" => false, "searchable" => false, 'width' => '70'],
            
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Deposit_' . date('YmdHis');
    }
}
