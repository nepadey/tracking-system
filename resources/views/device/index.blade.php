@extends('layouts.app')

@section('custom_style')
@endsection

@section('content')
  <div class="vehicle-form">
    <form action="#" method="post">
      <p>Driver :</p>
      <input type="text" id="driver" name="driver"/>

      <p>Vehicle No :</p>
      <input type="text" id="vehicle-no" name="vehicle-no"/>

      <p>Vehicle Name :</p>
      <input type="text" id="vehicle-name" name="vehicle-name"/>
      <br>
      <button type="submit">Add</button>
    </form>
  </div>
@endsection

@section('custom_script')
@endsection
