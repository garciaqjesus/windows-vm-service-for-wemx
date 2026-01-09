@php
    use App\Services\WindowsVM\Models\WindowsVMAccess;
    $access = WindowsVMAccess::firstOrCreate(['order_id' => $order->id], ['rdp_port' => 3389]);
@endphp

<div class="card">
    <div class="card-header">
        <strong>WindowsVM - Manual Provisioning</strong>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('windowsvm.admin.orders.access.save', $order->id) }}">
            @csrf

            <div class="form-group">
                <label>Status</label>
                <select class="form-control" name="status">
                    <option value="pending" {{ !$access->ready_at ? 'selected' : '' }}>Pending (can take up to 24h)</option>
                    <option value="ready" {{ $access->ready_at ? 'selected' : '' }}>Ready</option>
                </select>
            </div>

            <div class="form-group">
                <label>Public IP</label>
                <input class="form-control" name="public_ip" value="{{ $access->public_ip }}" placeholder="1.2.3.4">
            </div>

            <div class="form-group">
                <label>RDP Port</label>
                <input class="form-control" name="rdp_port" value="{{ $access->rdp_port ?? 3389 }}" placeholder="3389">
            </div>

            <div class="form-group">
                <label>Username</label>
                <input class="form-control" name="username" value="{{ $access->username }}" placeholder="Administrator">
            </div>

            <div class="form-group">
                <label>Password (leave empty to keep current)</label>
                <input class="form-control" name="password" placeholder="********">
            </div>

            <div class="form-group">
                <label>Notes</label>
                <textarea class="form-control" name="notes" rows="4" placeholder="Optional instructions...">{{ $access->notes }}</textarea>
            </div>

            <button class="btn btn-success">Save</button>
        </form>

        <div class="mt-2 text-muted" style="font-size: 12px;">
            Customer will see these details in Client Area → Services → Manage.
        </div>
    </div>
</div>
