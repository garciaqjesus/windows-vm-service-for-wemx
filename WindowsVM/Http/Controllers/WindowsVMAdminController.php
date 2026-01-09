<?php

namespace App\Services\WindowsVM\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\WindowsVM\Models\WindowsVMAccess;
use Illuminate\Http\Request;

class WindowsVMAdminController extends Controller
{
    public function edit(Order $order)
    {
        $access = WindowsVMAccess::firstOrCreate(
            ['order_id' => $order->id],
            ['rdp_port' => 3389]
        );

        // Backward-compatible default if the `status` column isn't present yet.
        // Older versions only used `ready_at` to determine readiness.
        if (empty($access->status)) {
            $access->status = $access->ready_at ? 'active' : 'pending';
        }

        return view('windowsvm::admin.edit-service', [
            'order' => $order,
            'access' => $access,
	        // WemX's default order edit wrapper references $order_errors.
	        // Some routes that render the service tab don't provide it,
	        // so we provide a safe default to avoid a 500.
	        'order_errors' => collect(),
        ]);
    }

    public function save(Request $request, Order $order)
    {
        $data = $request->validate([
            // pending = provisioning, active = ready, suspended = temporarily disabled
            'status' => 'required|in:pending,active,suspended',
            'public_ip' => 'nullable|string|max:100',
            'rdp_port'  => 'nullable|integer|min:1|max:65535',
            'username'  => 'nullable|string|max:100',
            'password'  => 'nullable|string|max:255',
            'notes'     => 'nullable|string|max:5000',
        ]);

        $access = WindowsVMAccess::firstOrCreate(['order_id' => $order->id], ['rdp_port' => 3389]);

        $access->public_ip = $data['public_ip'] ?? $access->public_ip;
        $access->rdp_port  = $data['rdp_port'] ?? ($access->rdp_port ?? 3389);
        $access->username  = $data['username'] ?? $access->username;

        if (!empty($data['password'])) {
            $access->password = $data['password']; // encrypted via mutator
        }

        $access->notes = $data['notes'] ?? $access->notes;
        $access->updated_by = auth()->id();

        // Persist provisioning status (newer versions have a dedicated column).
        $access->status = $data['status'];

        // Keep `ready_at` in sync for older templates/logic.
        if ($data['status'] === 'active') {
            $access->ready_at = $access->ready_at ?: now();
        } elseif ($data['status'] === 'pending') {
            $access->ready_at = null;
        }

        $access->save();

        return back()->with('success', 'WindowsVM access details saved.');
    }
}
