<?php

namespace App\Http\Controllers;

use App\Device;
use App\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class DeviceController extends Controller
{
  public function index(Request $request)
  {
    if ($request->ajax()) {
      $data = Device::where('user_id', Auth::user()->id)->latest()->with(['user',])->get();
      return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('action', function ($row) {
          $device_url = route("device.show", ['device' => $row->id]);
          return '<a href="' . $device_url . '" class="edit btn btn-primary btn-sm">Track </a>';
        })
        ->addColumn('tracking_url', function ($row) {
          return route("track.me", ['id' => $row->device_token]);
        })
        ->rawColumns(['action', 'tracking_url'])
        ->make(true);
    }
    return view("device.index");
  }

  public function store(Request $request)
  {
    $redirectRoute = route('device.index');
    $validator = Validator::make($request->all(), [
      'name' => ['required', 'max:255'],
    ]);

    if ($validator->fails()) {
      return redirect($redirectRoute)
        ->withErrors($validator)
        ->withInput();
    }
    $device['name'] = $request->name;
    $device['device_token'] = Str::uuid();
    $device['user_id'] = Auth::user()->id;
    $device['enabled'] = true;

    Device::create($device);
    return redirect($redirectRoute);
  }

  public function show(Device $device)
  {
    return view("device.show")->with(['device' => $device]);
  }

  public function getDeviceLocation($id)
  {
    $locations = Location::where('device_id', $id)->get();
    echo json_encode($locations);
  }

}
