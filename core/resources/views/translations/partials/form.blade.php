<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            {!! Form::label('locale_name', trans('application.locale_name')) !!}
            {!! Form::text('locale_name', null, ['class' => 'form-control input-sm', 'required']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('short_name', trans('application.short_name')) !!}
            {!! Form::text('short_name', null, ['class' => 'form-control input-sm', 'required', isset($locale) && $locale->short_name == 'en' ? 'readonly' : '']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('status', trans('application.status')) !!}
            {!! Form::select('status', array('0' => trans('application.disabled'), '1'=>trans('application.enabled')), null, ['class' => 'form-control input-sm', 'required']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('flag', trans('application.flag').'('.trans('application.width').' : 16px)') !!}
            @if(isset($locale) && $locale->flag != '')
                {!! HTML::image(asset('assets/img/flags/'.$locale->flag), 'flag', array('class' => 'thumbnail')) !!}
            @endif
            <div class=" form-group input-group input-file" style="margin-bottom: 10px;width:50%">
                <div class="form-control input-sm"></div>
                  <span class="input-group-addon">
                    <a class='btn btn-sm btn-primary' href='javascript:;'>
                        {{ trans('application.browse') }}
                        <input type="file" name="flag" id="flag" onchange="$(this).parent().parent().parent().find('.form-control').html($(this).val());">
                    </a>
                  </span>
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('default', trans('application.default')) !!}
            <div class="input-group col-md-6">
                {!! Form::select('default', array('0'=>'No',  '1' => 'Yes'),  null, ['class' => "form-control input-sm"]) !!}
            </div>
        </div>
    </div>
</div>