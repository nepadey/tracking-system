{!! Form::open(['url' => route('device.store'),'files'=> false]) !!}
<div class="">
  <div class="row form-group">
    {{Form::label("name","Name", [ "class" => "col-md-4 col-form-label text-md-right" ]) }}
    <div class="col-md-6 ">
      {{Form::text("name", old("name") ? old("name") :"", [ "class" => "form-control device-name", "placeholder" => "Device Name", ]) }}
    </div>
  </div>
  <div class="row form-group">
    <div class="offset-md-5">
      {{Form::submit('Submit',[ "class" => "col-md-12 submit-btn btn btn-primary" ])}}
    </div>
  </div>
</div>
{!! Form::close() !!}
