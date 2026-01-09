<?php

namespace App\Services\WindowsVM;

use App\Models\Order;
use App\Models\Package;
use App\Services\ServiceInterface;
use App\Services\WindowsVM\Models\WindowsVMAccess;

class Service implements ServiceInterface
{
    public static string $key = 'windowsvm';

    public function __construct(public Order $order)
    {
    }

    public static function metaData(): object
    {
        $config = require __DIR__ . '/Config/config.php';

        return (object) [
            'display_name' => $config['name'] ?? 'WindowsVM',
            'author' => $config['author'] ?? 'TheXHosting',
            'version' => $config['version'] ?? '1.0.0',
            'wemx_version' => $config['wemx_version'] ?? '>=1.0.0',
        ];
    }

    /**
     * Global service settings (Admin -> Services -> WindowsVM).
     * Keep empty for manual provisioning.
     */
    public static function setConfig(): array
    {
        return [
            [
                'key' => 'windowsvm::default_rdp_port',
                'name' => 'Default RDP Port',
                'description' => 'Default port used for new access records.',
                'type' => 'number',
                'default_value' => 3389,
                'rules' => ['required', 'integer', 'min:1', 'max:65535'],
            ],
        ];
    }

    /**
     * Package configuration (Admin -> Packages -> Service config).
     * These are NOT customer-editable at checkout unless you expose them through Configurable Options.
     *
     * IMPORTANT: keys with is_configurable => true will appear in the "Configurable Options (BETA)" Key dropdown.
     */
    public static function setPackageConfig(Package $package): array
    {
        return [
            [
                'key' => 'vm_cpu',
                'name' => 'vCPU',
                'description' => 'Number of virtual CPU cores.',
                'type' => 'number',
                'default_value' => 2,
                'rules' => ['required', 'integer', 'min:1', 'max:64'],
                'required' => true,
                'is_configurable' => true,
            ],
            [
                'key' => 'vm_ram_gb',
                'name' => 'RAM (GB)',
                'description' => 'Memory size in GB.',
                'type' => 'number',
                'default_value' => 4,
                'rules' => ['required', 'integer', 'min:1', 'max:512'],
                'required' => true,
                'is_configurable' => true,
            ],
            [
                'key' => 'vm_disk_gb',
                'name' => 'NVMe Disk (GB)',
                'description' => 'Disk size in GB.',
                'type' => 'number',
                'default_value' => 40,
                'rules' => ['required', 'integer', 'min:20', 'max:2000'],
                'required' => true,
                'is_configurable' => true,
            ],
            [
                'key' => 'vm_location',
                'name' => 'Location',
                'description' => 'Datacenter / region label shown to customer.',
                'type' => 'text',
                'default_value' => 'EU',
                'rules' => ['nullable', 'string', 'max:50'],
                'required' => false,
                'is_configurable' => true,
            ],
        ];
    }

    /**
     * Checkout fields (customer input at checkout).
     * Keep empty for manual provisioning.
     */
    public static function setCheckoutConfig(Package $package): array
    {
        return [];
    }

    /**
     * Data shown on the client "Manage" page.
     * WemX passes this as $service_data.
     */
    public function data(?Order $order = null): array
    {
        $order = $order ?? $this->order;
        $access = WindowsVMAccess::where('order_id', $order->id)->first();

        return [
            'access' => $access ? [
                'status' => $access->status,
                'public_ip' => $access->public_ip,
                'rdp_port' => $access->rdp_port,
                'username' => $access->username,
                'password' => $access->password,
                'notes' => $access->notes,
            ] : null,
        ];
    }

    public function create(array $data = [])
    {
        // Manual provisioning: create empty access record so admin UI has something to edit.
        $defaultPort = (int) (config('windowsvm.default_rdp_port') ?? 3389);

        WindowsVMAccess::firstOrCreate(
            ['order_id' => $this->order->id],
            ['rdp_port' => $defaultPort]
        );

        return [];
    }

    public function suspend(array $data = [])
    {
        // Manual: no action
        return [];
    }

    public function unsuspend(array $data = [])
    {
        // Manual: no action
        return [];
    }

    public function terminate(array $data = [])
    {
        // Optional: delete saved access details when terminated
        WindowsVMAccess::where('order_id', $this->order->id)->delete();
        return [];
    }
}
