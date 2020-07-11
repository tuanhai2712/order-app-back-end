<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\SettingRequest;
use App\Interfaces\SettingServiceInterface;

class SettingController extends Controller
{
    public function __construct(SettingServiceInterface $settingService)
    {
        $this->settingService = $settingService;
    }

   public function setting(SettingRequest $request)
   {
      $validated = $request->validateImages();
      if (!$validated) {
          return response()->json(Response::HTTP_BAD_REQUEST);
      }
      $setting = $this->settingService->setting($request->all());
      if (!$setting) {
          return response()->json(Response::HTTP_BAD_REQUEST);
      }
      return response()->json($setting, Response::HTTP_OK);
   }

   public function getSetting()
   {
      $setting = $this->settingService->getSetting();
      if (!$setting) {
          return response()->json(Response::HTTP_BAD_REQUEST);
      }
      return response()->json($setting, Response::HTTP_OK);
   }

   public function getOverview()
   {
        $user = Auth::user();
        $customers = $this->settingService->getCustomers($user['role']);
        $overview = $this->settingService->getOverview($user['id'], $user['role']);
        return response()->json([
          'customers' => $customers,
          'overview' => $overview,
        ], Response::HTTP_OK);
   }
}
