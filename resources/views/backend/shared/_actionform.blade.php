<div class="m-demo__preview m-demo__preview--btn">
    <button type="submit" name="btnsaverefresh" class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--pill m-btn--air">
        <span>
            <i class="fa fa-archive"></i>
            <span>{{__('trans.btnsave')}}</span>
        </span>
    </button>
    <button type="submit" name="btnsaveclose" class="btn btn-info m-btn m-btn--custom m-btn--icon m-btn--pill m-btn--air">
        <span>
            <i class="fa fa-archive"></i>
            <span>{{__('trans.btnsave&close')}}</span>
        </span>
    </button>
    <a href="{{ url()->previous() }}" class="btn btn-warning m-btn m-btn--custom m-btn--icon m-btn--pill m-btn--air">
        <span>
            <i class="fa fa-arrow-left"></i>
            <span>{{__('trans.btnback')}}</span>
        </span>
    </a>
   
</div>