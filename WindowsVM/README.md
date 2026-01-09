# WindowsVM Service (Manual)

This service adds a **manual** Windows VM product to WemX:

- Admin enters IP / RDP port / username / password / notes.
- Customer sees the details in Client Area -> Services -> Manage.
- Provides configurable keys (vm_cpu, vm_ram_gb, vm_disk_gb, vm_location) so they appear in **Configurable Options (BETA)**.

## Install

1. Copy the folder to:
   `app/Services/WindowsVM`

2. Clear caches:
   `php artisan optimize:clear`

3. Run module migrations:
   `php artisan module:migrate WindowsVM`

4. Enable the service in Admin -> Services, then assign it to your Package.

## Notes

- No automatic provisioning is performed.
- Password is stored encrypted using Laravel Crypt.
