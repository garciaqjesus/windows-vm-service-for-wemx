@extends(AdminTheme::path('orders.edit.wrapper'), ['active' => 'service'])

@section('order-section')
    <div class="card">
        <div class="card-body">
            <h4 class="mb-4">WindowsVM Access Details</h4>

            <form method="POST" action="{{ route('windowsvm.admin.orders.edit-service.save', $order) }}">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Provisioning Status</label>
                        <select name="status" class="form-control">
                            @php($currentStatus = old('status', $access->status ?? 'pending'))
                            <option value="pending" {{ $currentStatus === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="active" {{ $currentStatus === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="suspended" {{ $currentStatus === 'suspended' ? 'selected' : '' }}>Suspended</option>
                        </select>
                        <small class="text-muted">Show customers if the VM is ready (can take up to 24 hours).</small>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Public IP</label>
                        <input type="text" name="public_ip" class="form-control" value="{{ old('public_ip', $access->public_ip ?? '') }}" placeholder="e.g. 147.189.169.104">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">RDP Port</label>
                        <input type="number" name="rdp_port" class="form-control" min="1" max="65535" value="{{ old('rdp_port', $access->rdp_port ?? 3389) }}">
                        <small class="text-muted">Port can be different per VM (same IP, different ports supported).</small>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" value="{{ old('username', $access->username ?? '') }}" placeholder="Administrator">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Password</label>
                        <input type="text" name="password" class="form-control" value="{{ old('password', $access->password ?? '') }}" placeholder="(set password)">
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label">Notes (optional)</label>
                        <textarea name="notes" class="form-control" rows="3" placeholder="Extra instructions for the customer...">{{ old('notes', $access->notes ?? '') }}</textarea>
                    </div>
                </div>

                <button class="btn btn-primary">Save Access Details</button>
            </form>

            @if(session('success'))
                <div class="alert alert-success mt-3">{{ session('success') }}</div>
            @endif
        </div>
    </div>
@endsection
