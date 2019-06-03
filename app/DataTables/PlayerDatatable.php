<?php

namespace App\DataTables;

use App\Models\BackEnd\Player;
use Yajra\DataTables\Services\DataTable;
use Illuminate\Http\Request;
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
                    $pname = $player->reg_name;
                    $entity = 'players';
                    $status = $player->status;
                    return view('backend.members.player.inc.actionbtn', compact("id", "entity", "pname", "status"));
                })->addColumn('bank', function($query) {
                    if(isset($query->getPlayerBank->getBank)){
                         $bankName = $query->getPlayerBank->getBank['bk_name'];
                    $bankAccount = $query->getPlayerBank['reg_account_number'];
                    $bankAccountName = $query->getPlayerBank['reg_account_name'];
                    return '<ul class="m-nav"><li><strong>Bank Name: </strong> ' . $bankName . '</li><li><li><strong>Account Name: </strong>' . $bankAccountName . '</li><li><li><strong>Account ID: </strong>' . $bankAccount . '</li></ul>';
       
                    }else{
                        return '';
                    }
                            })->addColumn('check', '<label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand">
                    <input type="checkbox" name="cbo_selected" value="{{ $id }}" class="m-checkable"/><span></span>
                    </label>')->editColumn('reg_name', function($query) {
                    $getReferral = $query->getReferral;
                    return '<span class="p-name">' . $query->reg_name . ' </span><small>Referral: <a href="#"><i>' . $getReferral['reg_name'] . '</i></a></small> <small>Created Date: ' . date('d-m-Y', strtotime($query->reg_date)) . '<small>';
                })->editColumn('reg_username', '<span class="p-name">{{$reg_username}}</span><small>Loged :</small><small>IP: {{$reg_ip}}</small>')->rawColumns(['action', 'check', 'reg_name', 'bank', 'reg_username'])->setRowClass(function($player) {
                    return $player->status == 1 ? '' : 'text-danger';
                });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Player $model, Request $request) {
        $status = $request->input('status');
        if ($status === 'all') {
            return $model->getRecord();
        } else {
            return $model->getRecord()->where('status', $status);
        }
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html() {
        return $this->builder()
                        ->columns($this->getColumns())
                        //->addCheckbox()
                        ->ajax([
                            'data' => "function(d){
                                  d.status = $('select[name=status]').val();
                            }"
                                ]
                        )
                        ->parameters([
                            'lengthMenu' => \Config::get('sysconfig.lengthMenu'),
                            //'pagingType' => 'full_numbers',
                            'bFilter' => true,
                            'bSort' => true,
                            'order' => [
                                0,
                                'DESC'
                            ],
                            'language' => [
                                'paginate' => [
                                    'next' => '<i class="la la-angle-right"></i>', // or '→'
                                    'previous' => '<i class="la la-angle-left"></i>'
                                ]
                            ],
                            'dom' => 'Bfrtlip',
                            'buttons' => [['extend' => 'csvHtml5',
                            'filename' => 'Player_' . date('Y-m-d_H:i:s'),
                            'exportOptions' => ['columns' => ':visible', 'columns' => [2, 3, 4, 5, 6, 7]],
                            'text' => '<i class="fa fa-file-alt"></i><span>CSV</span>',
                            'className' => ' m-btn--icon'
                                ],
                                ['extend' => 'excelHtml5',
                                    'filename' => 'Player_' . date('Y-m-d_H:i:s'),
                                    'exportOptions' => ['columns' => ':visible', 'columns' => [2, 3, 4, 5, 6, 7]],
                                    'text' => '<i class="fa fa-file-excel"></i><span>Excel</span>',
                                    'className' => ' m-btn--icon'
                                ],
                                ['extend' => 'pdfHtml5',
                                    'orientation' => 'landscape',
                                    'pageSize' => 'A4',
                                    'exportOptions' => ['columns' => ':visible', 'stripHtml' => false, 'columns' => [2, 3, 4, 5, 6, 7]],
                                    'download' => 'open',
                                    'filename' => 'Player_' . date('Y-m-d_H:i:s'),
                                    'text' => '<i class="fa fa-file-pdf"></i><span>PDF</span>',
                                    'className' => ' m-btn--icon',
                                    'customize' => "function(doc) {
                                        var rowCount = doc.content[1].table.body.length;
                                       
                                        for (i = 1; i < rowCount; i++) {
                                          var test= doc.content[1].table.body[i][0];
                                          doc.content[1].table.body[i][0].alignment = 'left';
                                        }}"
                                ],
                                ['extend' => 'copyHtml5',
                                    'exportOptions' => ['columns' => ':visible'],
                                    'text' => '<i class="fa fa-copy"></i><span>Copy</span>',
                                    'className' => ' m-btn--icon'],
                                ['extend' => 'print',
                                    'exportOptions' => ['columns' => ':visible', 'columns' => [2, 3, 4, 5, 6, 7]],
                                    'pageSize' => 'A4',
                                    'text' => '<i class="fa fa-print"></i><span>Print</span>',
                                    'className' => ' m-btn--icon']
                            ],
                            'select' => ['style' => 'multi+shift', ' blurable' => true, 'selector' => 'td:not(:last-child)'],
                            'retrieve' => true,
                            'columnDefs' => [
                                'targets' => 0,
                                'className' => 'select-checkbox'
                            ]
        ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns() {
        return [
            ['data' => 'id', 'name' => 'id', 'visible' => false, 'printable' => false, 'exportable' => true],
            ['data' => 'check', 'name' => 'check', 'title' => '<label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand"> <input type="checkbox" value="" class="m-group-checkable"> <span></span>
                    </label>', "orderable" => false, "searchable" => false, 'width' => '40', 'class' => 'select-checkbox'],
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
