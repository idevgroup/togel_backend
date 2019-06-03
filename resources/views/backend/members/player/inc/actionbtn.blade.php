
<div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" m-dropdown-toggle="click" aria-expanded="true">
    <a href="#" class="m-portlet__nav-link m-dropdown__toggle btn btn-secondary m-btn m-btn--icon m-btn--pill">
        <i class="la la-ellipsis-v"></i>
    </a>
    <div class="m-dropdown__wrapper">
        <div class="m-dropdown__inner">
            <div class="m-dropdown__body">
                <div class="m-dropdown__content">
                    <ul class="m-nav">
                        <li class="m-nav__item">
                            <a class="m-nav__link player-transaction" data-id="{{ $id }}" href="javascript:void(0);" data-pname="{{$pname}}">
                                <i class="m-nav__link-icon flaticon-list-2"></i><span class="m-nav__link-text">Transaction</span>
                            </a>
                        </li>
                       <li class="m-nav__item">
                            <a class="m-nav__link" href="{{ url(_ADMIN_PREFIX_URL)}}/{{ $entity }}/{{ $id }}/banking">
                                <i class="m-nav__link-icon fa fa-money-bill-alt"></i><span class="m-nav__link-text"> Bank</span></a>
                        </li>
                        <li class="m-nav__item">
                            <a class="m-nav__link" href="{{ url(_ADMIN_PREFIX_URL)}}/{{ $entity }}/{{ $id }}/edit">
                                <i class="m-nav__link-icon flaticon-edit-1"></i><span class="m-nav__link-text"> Edit</span></a>
                        </li>
                        <li class="m-nav__item">
                            <a class="m-nav__link delete_action" data-id="{{ $id }}" href="javascript:void(0);">
                                <i class="m-nav__link-icon flaticon-circle"></i><span class="m-nav__link-text">Delete</span>
                            </a>
                        </li>
                         <li class="m-nav__item">
                            <a class="m-nav__link player_block" data-id="{{ $id }}" data-status="{{$status}}" href="javascript:void(0);">
                                @if($status === 1)
                                <i class="m-nav__link-icon fa fa-lock-open"></i><span class="m-nav__link-text">{{trans('trans.unblockplayer')}}</span>
                                @else
                                  <i class="m-nav__link-icon flaticon-lock"></i><span class="m-nav__link-text">{{trans('trans.blockplayer')}}</span>
                                @endif
                            </a>
                        </li>
                    </ul>

                </div>
            </div>
        </div>
    </div>


