<?php

namespace holoo\modules\Payments\Contracts;


use holoo\modules\Bases\Http\Contracts\BaseRepository;
use holoo\modules\Invoices\Contracts\InvoiceInterface;
use holoo\modules\Payments\Models\Payment;

class PaymentRepository  extends BaseRepository implements InvoiceInterface
{
    public function model(): mixed
    {
        return Payment::class;
    }
    public function searchPayment($data)
    {
        $search = $data['search'] ?? null;
        $statusPayment = $data['statusPayment'] ?? null;
        $dateRange = $data['date'] ?? null;
        $userId = $data['user_id'] ?? null;

        return Payment::with('link')
            ->when($search, function ($query) use ($search) {
                return $query->where('ref_id', 'like', '%' . $search . '%');
            })
            ->when($statusPayment, function ($query) use ($statusPayment) {
                return $query->where('status', $statusPayment);
            })
            ->when($dateRange, function ($query) use ($dateRange) {
                return $query->whereBetween('created_at', $dateRange);
            })
            ->when($userId, function ($query) use ($userId) {
                return $query->whereHas('link', function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                });
            })
            ->paginate($data['per_page'] ?? 500);
    }

    public function withAndPaginateRole($request, $page)
    {
        $user = User::with('roles')->find(Auth::id());
        $query = Payment::with('link');
        if ($user->roles[0]['name'] && $user->roles[0]['name'] !== 'admin' && $user->roles[0]['name'] !== 'finance') {
            $query->whereHas('link', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            });
        }
        return $query->orderBy('created_at', 'desc')->paginate($page);
    }

    public function queryExcel($request)
    {
        $dates = [
            $request['dates'][0],
            $request['dates'][1],
        ];
        $user = User::with('roles')->find(Auth::id());

        $query = Payment::with('link')->whereBetween('updated_at', $dates);

        if ($user->roles[0]['name'] && $user->roles[0]['name'] !== 'admin') {

            $query->whereHas('link', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            });

        }
        return $query->get();
    }
}
