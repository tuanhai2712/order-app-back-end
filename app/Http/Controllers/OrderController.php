<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\OrderServiceInterface;
use Illuminate\Http\Response;
use App\Http\Requests\SearchRequest;
use App\Http\Requests\CreateOrderRequest;
use App\Http\Requests\ImportWaybillCodeRequest;

class OrderController extends Controller
{
    public function __construct(OrderServiceInterface $orderService)
    {
        $this->orderService = $orderService;
    }

    public function getOrderCheck(SearchRequest $request)
    {
        $conditions = $request->all();
        $orders = $this->orderService->getOrderCheck($conditions);
        return response()->json(['data' => $orders['data'], 'last_page' => $orders['last_page']], Response::HTTP_OK);
    }

    public function create(CreateOrderRequest $request)
    {
        $validated = $request->validateImages();
        if (!$validated) {
            return response()->json(Response::HTTP_BAD_REQUEST);
        }
        $created = $this->orderService->create($request->all());
        if (!$created) {
            return response()->json(Response::HTTP_BAD_REQUEST);
        }
        return response()->json(Response::HTTP_OK);
    }

    public function getImageOrder(Request $request)
    {
        $data = $request->all();
        $images = $this->orderService->getImageOrder($data['order_id']);
        return response()->json(['images' => $images], Response::HTTP_OK);
    }

    public function updateOrder(Request $request)
    {
        $data = $request->all();
        $updated = $this->orderService->updateOrder($data);
        return response()->json($updated, Response::HTTP_OK);
    }

    public function confirmOrder(Request $request)
    {
        $data = $request->all();
        $confirmed = $this->orderService->confirmOrder($data);
        return response()->json($confirmed, Response::HTTP_OK);
    }

    public function getOrderBeingTransportedStatus()
    {
        $orders = $this->orderService->getOrderBeingTransportedStatus();
        $consignment = $this->orderService->getConsignment();
        return response()->json([
          'orders' => $orders,
          'consignment' => $consignment
        ], Response::HTTP_OK);
    }

    public function checkBarcode(Request $request)
    {
        $data = $request->all();
        $checkBarcode = $this->orderService->checkBarcode($data);
        return response()->json($checkBarcode, Response::HTTP_OK);
    }

    public function import(ImportWaybillCodeRequest $request) {
      $validated = $request->validateFileImport();
      if (!$validated['success']) {
        return $validated;
      }
      $import = $this->orderService->import($validated['data']);
      if (!$import['success']) {
        return $import;
      }
      return response()->json($import, Response::HTTP_OK);
    }

    public function findWaybillCode(Request $request)
    {
        $data = $request->all();
        $waybillCode = $this->orderService->findWaybillCode($data);
        return response()->json($waybillCode, Response::HTTP_OK);
    }
}
