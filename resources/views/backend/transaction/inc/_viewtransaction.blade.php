<div class="m-auto col-sm-10">
    <div class="form-group m-form__group row @if ($errors->has('name')) has-danger @endif">
        {!!Form::label('name','Customer Name',['class' => 'col-sm-3 col-form-label required'])!!}
        <div class="col-sm-9">
            {!!Form::text('name',old('name',$temTransaction->players->reg_name),['class' => 'form-control m-input','id'=>'name','readonly'])!!}
            @if ($errors->has('name')) <p class="form-control-feedback">{{ $errors->first('name') }}</p> @endif
        </div>
    </div>
    <div class="form-group m-form__group row @if ($errors->has('code')) has-danger @endif">
        {!!Form::label('mail','Mail',['class' => 'col-sm-3 col-form-label required'])!!}
        <div class="col-sm-9">
            {!!Form::text('mail',old('mail',$temTransaction->players->reg_email),['class' => 'form-control m-input','id'=>'mail','readonly' ])!!}
            @if ($errors->has('mail')) <p class="form-control-feedback">{{ $errors->first('mail') }}</p> @endif
        </div>
    </div>
    <div class="m-separator m-separator--dashed m-separator--sm"></div>
    <div class="form-group m-form__group row @if ($errors->has('cbank')) has-danger @endif">
        {!!Form::label('cbank','Customer Bank',['class' => 'col-sm-3 col-form-label required'])!!}
        <div class="col-sm-9">
            {!!Form::text('cbank',old('cbank',$temTransaction->bank_name),['class' => 'form-control m-input','id'=>'cbank','readonly'])!!}
            @if ($errors->has('cbank')) <p class="form-control-feedback">{{ $errors->first('cbank') }}</p> @endif
        </div>
    </div>
    <div class="form-group m-form__group row @if ($errors->has('accountname')) has-danger @endif">
        {!!Form::label('accountname','Account Name',['class' => 'col-sm-3 col-form-label required'])!!}
        <div class="col-sm-9">
            {!!Form::text('accountname',old('accountname',$temTransaction->bank_acc_name),['class' => 'form-control m-input','readonly'])!!}
            @if ($errors->has('accountname')) <p class="form-control-feedback">{{ $errors->first('accountname') }}</p> @endif
        </div>
    </div>

    <div class="form-group m-form__group row @if ($errors->has('accountnumber')) has-danger @endif">
        {!!Form::label('accountnumber','Account Number',['class' => 'col-sm-3 col-form-label required'])!!}
        <div class="col-sm-9">
            {!!Form::text('accountnumber',old('accountnumber',$temTransaction->bank_acc_id),['class' => 'form-control m-input','readonly'])!!}
            @if ($errors->has('accountnumber')) <p class="form-control-feedback">{{ $errors->first('accountnumber') }}</p> @endif
        </div>
    </div>
    <div class="m-separator m-separator--dashed m-separator--sm"></div>

    <div class="form-group m-form__group row @if ($errors->has('deposittobank')) has-danger @endif">
        {!!Form::label('deposittobank','Deposit To',['class' => 'col-sm-3 col-form-label required'])!!}
        <div class="col-sm-9">
            {!!Form::text('deposittobank',old('deposittobank',$temTransaction->deposit_bank_name),['class' => 'form-control m-input','id'=>'deposittobank','readonly'])!!}
            @if ($errors->has('deposittobank')) <p class="form-control-feedback">{{ $errors->first('deposittobank') }}</p> @endif
        </div>
    </div>
     <div class="form-group m-form__group row @if ($errors->has('depositaccountname')) has-danger @endif">
        {!!Form::label('depositaccountname','Account Name',['class' => 'col-sm-3 col-form-label required'])!!}
        <div class="col-sm-9">
            {!!Form::text('depositaccountname',old('depositaccountname',$temTransaction->deposit_ac_name),['class' => 'form-control m-input','id'=>'depositaccountname','readonly'])!!}
            @if ($errors->has('depositaccountname')) <p class="form-control-feedback">{{ $errors->first('depositaccountname') }}</p> @endif
        </div>
    </div>

    <div class="form-group m-form__group row @if ($errors->has('depositaccountnumber')) has-danger @endif">
        {!!Form::label('depositaccountnumber','Account Number',['class' => 'col-sm-3 col-form-label required'])!!}
        <div class="col-sm-9">
            {!!Form::text('depositaccountnumber',old('depositaccountnumber',$temTransaction->deposit_ac_number),['class' => 'form-control m-input','readonly'])!!}
            @if ($errors->has('depositaccountnumber')) <p class="form-control-feedback">{{ $errors->first('depositaccountnumber') }}</p> @endif
        </div>
    </div>
     <div class="form-group m-form__group row @if ($errors->has('depositamount')) has-danger @endif">
        {!!Form::label('depositamount','Amount',['class' => 'col-sm-3 col-form-label required'])!!}
        <div class="col-sm-9">
          <div class="input-group m-input-group m-input-group--square">
            <div class="input-group-prepend"><span class="input-group-text" id="basic-addon1">$</span></div>  
            {!!Form::text('depositamount',old('depositamount',CommonFunction::_CurrencyFormat($temTransaction->amount)),['class' => 'form-control m-input'])!!}
          </div> 
            @if ($errors->has('depositamount')) <p class="form-control-feedback">{{ $errors->first('depositamount') }}</p> @endif
        </div>
    </div>
</div>