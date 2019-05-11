<ul class="m-portlet__nav">
    <li class="m-portlet__nav-item">
        <a href="{{url()->current()}}/create" class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">
            <span>
                <i class="la la-plus"></i>
                <span>{{trans('trans.newbtn')}}</span>
            </span>
        </a>
    </li>
    <li class="m-portlet__nav-item">
        <a href="javascript:void(0);" class="btn btn-info m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air" id="active-record" data-status="1">
            <span>
                <i class="fa fa-eye"></i>
                <span>{{trans('trans.publishedbtn')}}</span>
            </span>
        </a>
    </li>
    <li class="m-portlet__nav-item">
        <a href="javascript:void(0);" class="btn btn-warning m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air" id="unactive-record" data-status="0">
            <span>
                <i class="fa fa-eye-slash"></i>
                <span>{{trans('trans.unpublishedbtn')}}</span>
            </span>
        </a>
    </li>
    <li class="m-portlet__nav-item">
        <a href="javascript:void(0);" class="btn btn-danger m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air" id="remove-record" data-type="remove">
            <span>
                <i class="la la-trash-o"></i>
                <span>{{trans('trans.removebtn')}}</span>
            </span>
        </a>
    </li>
    <li class="m-portlet__nav-item">
        <a href="javascript:void(0);" class="btn btn-danger m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air" id="delete-record" data-type="delete">
            <span>
                <i class="la la-times-circle"></i>
                <span>{{trans('trans.deleterecord')}}</span>
            </span>
        </a>
    </li>
</ul>