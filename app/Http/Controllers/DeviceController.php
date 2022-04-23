<?php

namespace App\Http\Controllers;

use App\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class DeviceController extends Controller
{

  /**
   * Display a listing of the resource.
   *
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\View\View
   */
  public function index(Request $request)
  {
    if ($request->ajax()) {
      $data = Device::where('user_id', Auth::user()->id)->latest()->with(['user',])->get();
      return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('action', function ($row) {
          return '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">Track </a>';
        })
        ->addColumn('tracking_url', function ($row) {
          return route("track.me", ['id' => $row->device_token]);
//          return '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">Track </a>';
        })
        ->rawColumns(['action', 'tracking_url'])
        ->make(true);
    }
    return view("device.index");
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Contracts\Foundation\Application|
   * @return \Illuminate\Http\RedirectResponse|
   * @return \Illuminate\Http\Response|
   * @return \Illuminate\Routing\Redirector
   */
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

  /**
   * Display the specified resource.
   *
   * @param \App\Device $device
   * @return \Illuminate\Http\Response
   */
  public function show(Device $device)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param \App\Device $device
   * @return \Illuminate\Http\Response
   */
  public function edit(Device $device)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param \Illuminate\Http\Request $request
   * @param \App\Device $device
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Device $device)
  {
    //
  }

//  /**
//   * Remove the specified resource from storage.
//   *
//   * @param \App\Device $device
//   * @return \Illuminate\Http\Response
//   */
//  public function destroy(Device $device)
//  {
//    //
//  }
}
