<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * Получить список заказов с фильтрами, пагинацией и выбором состава.
     */
    public function index(Request $request)
    {
        $query = Order::query();

        // Фильтры
        if ($request->filled('status_id')) {
            $query->where('status_id', $request->input('status_id'));
        }
        if ($request->filled('book_id')) {
            $query->where('book_id', $request->input('book_id'));
        }
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->input('date_from'));
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->input('date_to'));
        }

        // Состав: short/extended
        $with = ['book', 'status'];
        if ($request->input('composition') === 'extended') {
            $with[] = 'attributes';
        }

        $query->with($with);

        // Пагинация
        $perPage = $request->input('per_page', 10);
        $orders = $query->paginate($perPage);

        return response()->json($orders);
    }

    /**
     * Сменить статус заказа
     */
    public function changeStatus(Request $request, $orderId)
    {
        $validator = Validator::make($request->all(), [
            'status_id' => 'required|exists:statuses,id',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $order = Order::findOrFail($orderId);
        $newStatus = Status::findOrFail($request->input('status_id'));

        // Проверка: можно ли менять статус
        if (!$newStatus->is_changeable) {
            return response()->json(['error' => 'Смена на этот статус запрещена'], 403);
        }

        $order->status_id = $newStatus->id;
        $order->save();

        return response()->json(['message' => 'Статус заказа изменён', 'order' => $order->load('status')]);
    }
}
