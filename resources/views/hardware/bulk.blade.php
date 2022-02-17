@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('admin/hardware/form.update') }}
@parent
@stop


@section('header_right')
<a href="{{ URL::previous() }}" class="btn btn-sm btn-primary pull-right">
  {{ trans('general.back') }}</a>
@stop

{{-- Page content --}}
@section('content')
<div class="row">
  <div class="col-md-8 col-md-offset-2">

    <p>{{ trans('admin/hardware/form.bulk_update_help') }}</p>

    <div class="callout callout-warning">
      <i class="fa fa-warning"></i> {{ trans('admin/hardware/form.bulk_update_warn', ['asset_count' => count($assets)]) }}
    </div>

    <form class="form-horizontal" method="post" action="{{ route('hardware/bulksave') }}" autocomplete="off" role="form">
      {{ csrf_field() }}

      <div class="box box-default">
        <div class="box-body">
        
          <!-- Expected Checkin Date -->
          <div class="form-group {{ $errors->has('expected_checkin') ? ' has-error' : '' }}">
             <label for="expected_checkin" class="col-md-3 control-label">{{ trans('admin/hardware/form.expected_checkin') }}</label>
             <div class="input-group col-md-3">
                  <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd"  data-autoclose="true">
                      <input type="text" class="form-control" placeholder="{{ trans('general.select_date') }}" name="expected_checkin" id="expected_checkin" value="{{ old('expected_checkin') }}">
                      <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                 </div>
                 {!! $errors->first('expected_checkin', '<span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span>') !!}
             </div>
          </div>


          <!-- Status -->
          <div class="form-group {{ $errors->has('status_id') ? ' has-error' : '' }}">
            <label for="status_id" class="col-md-3 control-label">
              {{ trans('admin/hardware/form.status') }}
            </label>
            <div class="col-md-7">
              {{ Form::select('status_id', $statuslabel_list , old('status_id'), array('class'=>'select2', 'style'=>'width:350px', 'aria-label'=>'status_id')) }}
              {!! $errors->first('status_id', '<span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span>') !!}
            </div>
          </div>

        @include ('partials.forms.edit.model-select', ['translated_name' => trans('admin/hardware/form.model'), 'fieldname' => 'model_id'])

          <!-- Default Location -->
        @include ('partials.forms.edit.location-select', ['translated_name' => trans('admin/hardware/form.default_location'), 'fieldname' => 'rtd_location_id'])

        <!-- Update actual location  -->
          <div class="form-group">
            <div class="col-md-3"></div>
            <div class="col-md-9">

                <label for="update_real_loc">
                  {{ Form::radio('update_real_loc', '1', old('update_real_loc'), ['class'=>'minimal', 'aria-label'=>'update_real_loc']) }}
                  Update default location AND actual location
                </label>
                <br>
                <label for="update_default_loc">
                  {{ Form::radio('update_real_loc', '0', old('update_real_loc'), ['class'=>'minimal', 'aria-label'=>'update_default_loc']) }}
                  Update only default location
                </label>

            </div>
          </div> <!--/form-group-->



          
          <!-- Company -->
          @include ('partials.forms.edit.company-select', ['translated_name' => trans('general.company'), 'fieldname' => 'company_id'])

         

          <!-- Requestable -->
          <div class="form-group {{ $errors->has('requestable') ? ' has-error' : '' }}">
            <div class="control-label col-md-3">
              <strong>{{ trans('admin/hardware/form.requestable') }}</strong>
            </div>
            <div class="col-md-7">
              <label class="radio">
                <input type="radio" class="minimal" name="requestable" value="1"> Yes
              </label>
              <label class="radio">
                <input type="radio" class="minimal" name="requestable" value="0"> No
              </label>
              <label class="radio">
                <input type="radio" class="minimal" name="requestable" value=""> Do Not Change
              </label>
            </div>
          </div>

          @foreach ($assets as $key => $value)
            <input type="hidden" name="ids[{{ $value }}]" value="1">
          @endforeach
        </div> <!--/.box-body-->

        <div class="text-right box-footer">
          <button type="submit" class="btn btn-success"><i class="fa fa-check icon-white" aria-hidden="true"></i> {{ trans('general.save') }}</button>
        </div>
      </div> <!--/.box.box-default-->
    </form>
  </div> <!--/.col-md-8-->
</div>
@stop
