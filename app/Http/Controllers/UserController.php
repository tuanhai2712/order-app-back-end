<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Interfaces\UserServiceInterface;
use App\Http\Requests\UpdatePriceListForUserRequest;

class UserController extends Controller
{
    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    public function getUser(Request $request)
    {
        $conditions = $request->all();
        $users = $this->userService->getUser($conditions);
        return response()->json(['data' => $users['data'], 'last_page' => $users['last_page']], Response::HTTP_OK);
    }

    public function updatePriceListForUser(UpdatePriceListForUserRequest $request)
    {
      $data = $request->all();
      $updated = $this->userService->updatePriceListForUser($data);
      return response()->json(Response::HTTP_OK);
    }

}
