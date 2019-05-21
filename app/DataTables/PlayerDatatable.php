<?php

namespace App\DataTables;

use App\Models\BackEnd\Player;
use Yajra\DataTables\Services\DataTable;

class PlayerDatatable extends DataTable {

    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query) {
        return datatables($query)->addColumn('action', function ($player) {
                    $id = $player->id;
                    $entity = 'players';
                    return view('backend.members.player.inc.actionbtn', compact("id", "entity"));
                })->addColumn('bank', function($query) {
                    $bankName = $query->getPlayerBank->getBank['bk_name'];
                    $bankAccount = $query->getPlayerBank['reg_account_number'];
                    $bankAccountName = $query->getPlayerBank['reg_account_name'];
                    return '<ul class="m-nav"><li><strong>Bank Name: </strong> ' . $bankName . '</li><li><li><strong>Account Name: </strong>' . $bankAccountName . '</li><li><li><strong>Account ID: </strong>' . $bankAccount . '</li></ul>';
                })->addColumn('check', '<label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand">
                    <input type="checkbox" name="chkplayer" value="{{ $id }}" class="m-checkable"/><span></span>
                    </label>')->editColumn('reg_name', function($query) {
                    $getReferral = $query->getReferral;
                    return '<span class="p-name">' . $query->reg_name . '</span> <small>Referral: <a href="#"><i>' . $getReferral['reg_name'] . '</i></a></small> <small>Created Date: ' . date('d-m-Y', strtotime($query->reg_date)) . '<small>';
                })->editColumn('reg_username', '<span class="p-name">{{$reg_username}}</span><small>Loged :</small><small>IP: {{$reg_ip}}</small>')->rawColumns(['action', 'check', 'reg_name', 'bank', 'reg_username']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Player $model) {
        return $model->getRecord();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html() {
        return $this->builder()
                        ->columns($this->getColumns())
                        ->minifiedAjax()
                        ->parameters([
                            'lengthMenu' => \Config::get('sysconfig.lengthMenu'),
                            //'pagingType' => 'full_numbers',
                            'bFilter' => true,
                            'bSort' => true,
                            'order' => [
                                0,
                                'DESC'
                            ],
                            'dom' => 'Bfrtlip',
                            'buttons' => [ 'csv', 'excel', ['extend' => 'pdfHtml5','orientation'=>'landscape','pageSize'=>'A4','exportOptions'=>['columns' => ':visible'],'download' => 'open','filename' => 'Player_' . date('Y-m-d_H:i:s')],'copy', ['extend' => 'print','exportOptions'=>['columns' => ':visible'],'pageSize'=>'A4']]
                           
        ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns() {
        return [
            ['data' => 'id', 'name' => 'id','visible' => false, 'printable' => false, 'exportable' => true],
            ['data' => 'check', 'name' => 'check', 'title' => '<label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand"> <input type="checkbox" value="" class="m-group-checkable"> <span></span>
                    </label>', "orderable" => false, "searchable" => false, 'width' => '40'],
            ['data' => 'reg_name', 'name' => 'reg_name', 'title' => 'Player Name'],
            ['data' => 'reg_username', 'name' => 'reg_username', 'title' => 'Username'],
            ['data' => 'reg_phone', 'name' => 'reg_phone', 'title' => 'Phone'],
            ['data' => 'reg_email', 'name' => 'reg_email', 'title' => 'Email'],
            ['data' => 'bank', 'name' => 'bank', 'title' => 'Bank Account'],
            ['data' => 'reg_remain_balance', 'name' => 'reg_remain_balance', 'title' => 'Balance'],
            ['data' => 'action', 'name' => 'action', 'title' => 'Action', "orderable" => false, "searchable" => false, 'width' => '40']
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename() {
        return 'Player_' . date('Y-m-d_H:i:s');
    }

}
