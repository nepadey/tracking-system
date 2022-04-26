@extends('layouts.app')

@section('custom_style')
  <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
  <style>
    .device-list {
      padding: 24px;
    }
  </style>
@endsection

@section('content')
  <div class="device-form">
    @include("device._form")
  </div>
  <div class="device-list">
    <table class="table mt-4" id="devicesTable">
      <thead>
      <th> #</th>
      <th> Name</th>
      <th> Tracking Code</th>
      <th> Tracking Code</th>
      <th> Action</th>
      </thead>
      <tbody>
      </tbody>
    </table>
  </div>
@endsection

@section('custom_script')
    <script src="{{ asset('js/app.js') }}" defer></script>
  <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function () {
      $.noConflict();
      $('#devicesTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('device.index') !!}',
        columns: [
          {data: 'DT_RowIndex', name: 'DT_RowIndex'},
          // {data: 'id', name: 'id'},
          {data: 'name', name: 'name'},
          {data: 'device_token', name: 'device_token'},
          {data: 'tracking_url', name: 'tracking_url'},
          {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
      });
    });
  </script>
@endsection
