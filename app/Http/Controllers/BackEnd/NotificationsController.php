<?php

namespace App\Http\Controllers\BackEnd;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\Facades\DataTables;
use App\Models\BackEnd\Authorizable;
use DB;
use Config;
use App\Models\BackEnd\Notification;
use Illuminate\Support\Facades\File;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class NotificationsController extends Controller
{  
    use Authorizable;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Builder $builder)
    {
        if (request()->ajax()) {
            $notification = DB::table('Notification')->select(['id', 'nt_name', 'nt_sound', 'nt_record']);
            $datatables = Datatables::of($notification)->addColumn('action', function ($notification) {
                $id = $notification->id;
                $entity = 'notifications';
                return view('backend.systemsetting.notification.inc._actions', compact("id", "entity"));
            })->addColumn('nt_sound', '<audio controls>
                                            <source src="{!! asset("uploads/audio/" .$nt_sound) !!}" type="audio/ogg">
                                        </audio>'
                                        )
            ->setRowData([
                    'data-id' => '{{$id}}'
                ])->setRowClass('row-ordering')->setRowAttr(['data-id' => '{{$id}}'])->rawColumns(['nt_sound','action', 'check'])->addIndexColumn();
            return $datatables->make(true);
        }
        $html = $builder->columns([
            ['data' => 'nt_name', 'name' => 'nt_name', 'title' => trans('labels.notification_name')],
            ['data' => 'nt_sound', 'name' => 'nt_sound', 'title' => trans('labels.notification_sound')],
            ['data' => 'action', 'name' => 'action', 'title' => trans('labels.action'), "orderable" => false, "searchable" => false, 'width' => '60'],
        ])->parameters([
            'order' => [
                1,
                'ASC'
            ],
            'lengthMenu' => Config::get('sysconfig.lengthMenu')
        ]);
        
        return view('backend.systemsetting.notification.index', compact('html', $html));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $notification = Notification::find($id);
        return view('backend.systemsetting.notification.edit')->with('notification', $notification);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $notification = Notification::find($id);
        $notification->nt_name = $request->input('nt_name');
        $getSound = $notification->nt_sound;

        if ($request->hasFile('sound')) {
            $mp3 = $request->file('sound');
            $filename = $mp3->getClientOriginalName();
            $path = public_path('uploads/audio');
            $mp3->move($path,$filename);
    
            $notification->nt_sound = $filename;
            File::delete($path.'/'.$getSound);
        }
       
    

        $notification->save();
        \Alert::success(trans('menu.notification') . trans('trans.messageupdatesuccess'), trans('trans.success'));
        if ($request->has('btnsaveclose')) {
            return redirect(_ADMIN_PREFIX_URL . '/notifications');
        } else {
            return redirect(_ADMIN_PREFIX_URL . '/notifications/' . $notification->id . '/edit');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
