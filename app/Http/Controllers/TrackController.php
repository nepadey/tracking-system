<?php

namespace App\Http\Controllers;

use App\Device;
use Illuminate\Http\Request;

class TrackController extends Controller
{

  /**
   * Display a listing of the resource.
   *
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\View\View
   */
  public function trackMe(Request $request)
  {
    $device = Device::where('device_token', $request->id)->first();
    if ($device) {
      return view("track.show")->with(['key' => $this->encryptString($device->device_token)]);
    } else {
      return '<h1> PLease check the tracking code</h1>';
    }
  }

  public function storeTrackedData(Request $request)
  {
    $device_token = $this->decryptString($request->key);
    $device = Device::where('device_token', $device_token)->first();
    if ($device) {
      $location['lat'] = $request->latitude;
      $location['lng'] = $request->longitude;
      $location['ipaddress'] = $request->ipaddress;
      $device->location()->create($location);
      return 200;
    }
  }

  private function encryptString($simple_string)
  {
    $ciphering = "AES-128-CTR";
    $options = 0;
    $encryption_iv = '1234567891011121';
    $encryption_key = "TrackingSystem";
    return openssl_encrypt($simple_string, $ciphering, $encryption_key, $options, $encryption_iv);
  }

  private function decryptString($encryption_string)
  {
    $ciphering = "AES-128-CTR";
    $options = 0;
    $encryption_iv = '1234567891011121';
    $encryption_key = "TrackingSystem";
    return openssl_decrypt($encryption_string, $ciphering, $encryption_key, $options, $encryption_iv);
  }

}
