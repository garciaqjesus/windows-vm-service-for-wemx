@php
    // WemX may render the manage page without passing full $service_data.
    // To ensure the access details always show up, we also pull the latest record from the DB.
    $access = $service_data['access'] ?? null;

    if ((!$access || !is_array($access)) && isset($order) && $order?->id) {
        $record = \App\Services\WindowsVM\Models\WindowsVMAccess::where('order_id', $order->id)->first();

        if ($record) {
            $access = [
                'status' => $record->status,
                'public_ip' => $record->public_ip,
                'rdp_port' => $record->rdp_port,
                'username' => $record->username,
                'password' => $record->password,
                'notes' => $record->notes,
                'ready_at' => $record->ready_at,
            ];
        }
    }

    $status = $access['status'] ?? 'pending';
@endphp

{{-- Status banner (visible in both light & dark themes) --}}
@if(!$access || ($status !== 'active'))
    <div class="mb-6 rounded-xl border border-emerald-500/30 bg-emerald-600/10 px-4 py-3 text-emerald-700 dark:text-emerald-200">
        <div class="font-semibold">WindowsVM provisioning in progress</div>
        <div class="text-sm opacity-90">
            Your VM access details will appear here once provisioning is complete.
        </div>
    </div>
@else
    <div class="mb-6 rounded-xl border border-emerald-500/30 bg-emerald-600/15 px-4 py-3 text-emerald-800 dark:text-emerald-200">
        <div class="font-semibold">WindowsVM is ready ✅</div>
        <div class="text-sm opacity-90">Use the details below to connect via RDP.</div>
    </div>
@endif

@if($access)
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="rounded-xl p-4 border bg-white text-gray-900 border-gray-200 dark:bg-[#141625] dark:text-white dark:border-white/5">
            <div class="text-xs opacity-70 mb-1">Connection</div>
            <div class="text-lg font-semibold">RDP</div>
            <div class="text-sm mt-2">
                <span class="opacity-70">Address:</span>
                <span class="font-mono">{{ $access['public_ip'] ?: 'Pending' }}{{ $access['public_ip'] ? ':' . ($access['rdp_port'] ?: 3389) : '' }}</span>
            </div>
        </div>

        <div class="rounded-xl p-4 border bg-white text-gray-900 border-gray-200 dark:bg-[#141625] dark:text-white dark:border-white/5">
            <div class="text-xs opacity-70 mb-1">Login</div>
            <div class="text-sm">
                @if($status === 'active')
                    <div><span class="opacity-70">Username:</span> <span class="font-mono">{{ $access['username'] ?: 'Pending' }}</span></div>
                    <div class="mt-2"><span class="opacity-70">Password:</span> <span class="font-mono">{{ $access['password'] ?: 'Pending' }}</span></div>
                @elseif($status === 'suspended')
                    <div class="opacity-70">Your VM is currently suspended. Login details are hidden.</div>
                @else
                    <div class="opacity-70">Provisioning in progress. Login details will appear once active.</div>
                @endif
            </div>
        </div>

        <div class="rounded-xl p-4 border bg-white text-gray-900 border-gray-200 dark:bg-[#141625] dark:text-white dark:border-white/5">
            <div class="text-xs opacity-70 mb-1">Status</div>
            <div class="text-lg font-semibold capitalize">{{ $status }}</div>
            <div class="text-sm mt-2 opacity-70">
                @if($status === 'pending')
                    Your VM is being provisioned. This can take up to 24 hours.
                @elseif($status === 'suspended')
                    Your VM is suspended. Please contact support if you believe this is a mistake.
                @else
                    Your VM is ready. Use the details to connect via Remote Desktop.
                @endif
            </div>
        </div>
    </div>

    @if(!empty($access['notes']))
        <div class="rounded-xl p-4 border bg-white text-gray-900 border-gray-200 dark:bg-[#141625] dark:text-white dark:border-white/5 mb-6">
            <div class="text-xs opacity-70 mb-2">Notes</div>
            <div class="text-sm">{{ $access['notes'] }}</div>
        </div>
    @endif
@else
    <div class="rounded-xl p-4 border bg-white text-gray-900 border-gray-200 dark:bg-[#141625] dark:text-white dark:border-white/5 mb-6">
        <div class="text-sm opacity-70">Your VM access details will appear here once provisioning is complete.</div>
    </div>
@endif
