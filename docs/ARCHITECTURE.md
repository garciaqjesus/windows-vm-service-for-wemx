# Architecture (Quick)

## Database

Table: `windowsvm_access`

Columns:

- `order_id` (unique)
- `status` (`pending|active|suspended`)
- `public_ip`
- `rdp_port`
- `username`
- `password_encrypted`
- `notes`

## Routes

Routes are defined in:

- `WindowsVM/Routes/admin.php`

## Views

- Admin tab form: `WindowsVM/Resources/views/admin/edit-service.blade.php`
- Client status banner: `WindowsVM/Resources/views/client/tailwind/stats.blade.php`
- Client access details: `WindowsVM/Resources/views/client/tailwind/service/service.blade.php`
