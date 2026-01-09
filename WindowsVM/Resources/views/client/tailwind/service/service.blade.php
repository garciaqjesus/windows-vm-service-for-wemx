@php
    use App\Services\WindowsVM\Models\WindowsVMAccess;
    $access = WindowsVMAccess::where('order_id', $order->id)->first();
@endphp

@php
    $isReady = $access && ($access->status === 'active');
@endphp

<div class="bg-white dark:bg-gray-900 rounded-2xl shadow p-5">
    <div class="flex items-center justify-between mb-3">
        <h3 class="text-lg font-semibold">WindowsVM Access Details</h3>
        @if($isReady)
            <span class="text-xs px-2 py-1 rounded bg-emerald-100 text-emerald-800 dark:bg-emerald-500/20 dark:text-emerald-200">Ready</span>
        @else
            <span class="text-xs px-2 py-1 rounded bg-blue-100 text-blue-800 dark:bg-blue-500/20 dark:text-blue-200">Preparing</span>
        @endif
    </div>

    @if(!$isReady)
        <div class="p-3 rounded bg-emerald-50 text-emerald-900 dark:bg-emerald-500/10 dark:text-emerald-100 text-sm">
            Your Windows VM is being prepared. Provisioning can take up to <b>24 hours</b>.
            Once ready, your IP address and RDP credentials will appear here.
        </div>
    @else
        <div class="p-3 rounded bg-emerald-50 text-emerald-900 dark:bg-emerald-500/10 dark:text-emerald-100 text-sm mb-4">
            Your VM is ready.
        </div>

        <div class="text-sm space-y-2 text-gray-900 dark:text-gray-100">
            <div><b>Public IP:</b> <span class="font-mono">{{ $access->public_ip }}</span></div>
            <div><b>RDP Port:</b> <span class="font-mono">{{ $access->rdp_port ?? 3389 }}</span></div>
            <div><b>Username:</b> <span class="font-mono">{{ $access->username }}</span></div>

            <div class="flex items-center gap-2">
                <b>Password:</b>
                <span class="font-mono">{{ str_repeat('•', 10) }}</span>
                @if($access->password)
                    <button class="px-2 py-1 border rounded text-xs dark:border-gray-700"
                        onclick="navigator.clipboard.writeText(@json($access->password))">
                        Copy
                    </button>
                @endif
            </div>

            <div class="pt-2 text-gray-600 dark:text-gray-300">
                <b>RDP:</b> Connect to <span class="font-mono">{{ $access->public_ip }}:{{ $access->rdp_port ?? 3389 }}</span>
            </div>

            @if($access->notes)
                <div class="pt-2">
                    <b>Notes:</b>
                    <div class="text-gray-600 dark:text-gray-300">{!! nl2br(e($access->notes)) !!}</div>
                </div>
            @endif
        </div>
    @endif
</div>
