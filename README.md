# WindowsVM Manual Service for WemX

A **manual Windows Virtual Machine** service module for **WemX**.

This module is perfect when you sell Windows VPS/VMs that are provisioned **outside** WemX (for example on your reseller VPS provider, Proxmox, Hyper‑V, etc.) and you simply want a clean place to:

- Store the connection details (IP / RDP port / username / password / notes)
- Show them to the customer in the Client Area
- Keep the service status in sync with the order (Pending → Active → Suspended)

---

## What the customer sees

When the provisioning status is **Active**, the client will see a clean **“Connection Details”** section in *Services → Manage*:

- Public IP
- RDP Port (default 3389)
- Username
- Password
- Optional Notes

If the status is **Pending** or **Suspended**, a green banner explains that provisioning is still in progress (or that the VM is not ready).

---

## What the admin sees

In *Admin → Orders → Edit → WindowsVM tab*, admins can:

- Set provisioning status: `pending`, `active`, `suspended`
- Save Public IP, RDP port, username, password, notes
- Instantly update what the client sees

---

## Features

- ✅ Manual provisioning workflow (no automatic VM creation)
- ✅ Admin form inside the Order edit page
- ✅ Client “Access Details” panel
- ✅ Password stored encrypted using Laravel `Crypt`
- ✅ Works with light **and** dark themes (status banners are readable in both)
- ✅ Optional “Configurable Options (BETA)” keys (CPU/RAM/Disk/Location)

---

## Installation

1) **Copy module folder**

Upload the module to:

```
app/Services/WindowsVM
```

2) **Clear caches**

```
php artisan optimize:clear
```

3) **Run module migrations**

```
php artisan module:migrate WindowsVM
```

4) **Enable service & assign to a Package**

- Go to **Admin → Services**
- Enable **WindowsVM**
- Assign it to your **Package**

---

## Usage

### Admin workflow

1. Client places an order for the Windows VM package.
2. You provision the VM manually (your VPS provider, Proxmox, etc.).
3. Go to **Admin → Orders → Edit → WindowsVM**.
4. Fill in IP / Port / Username / Password / Notes.
5. Set **Provisioning Status = Active**.
6. Click **Save Access Details**.

### Client workflow

Client goes to:

- **Client Area → Services → Manage**

If the VM is Active, they can immediately connect via RDP.

---

## Configurable Options (BETA)

The module exposes these optional keys so they can appear in configurable options:

- `vm_cpu` (integer)
- `vm_ram_gb` (integer)
- `vm_disk_gb` (integer)
- `vm_location` (string)

See: **docs/CONFIGURABLE_OPTIONS.md**

---

## Documentation

- **Admin guide:** docs/ADMIN_GUIDE.md
- **Client guide:** docs/CLIENT_GUIDE.md
- **Configurable options:** docs/CONFIGURABLE_OPTIONS.md
- **Troubleshooting:** docs/TROUBLESHOOTING.md

---

## Security notes

- Passwords are stored encrypted (Laravel `Crypt`).
- Do **not** enable `APP_DEBUG=true` in production.
- Restrict admin access to trusted staff only.

---

## License

MIT 

