# Troubleshooting

## Client page says “provisioning in progress” but the VM is already ready

This means **WemX does not have Active access details stored for this order**.

Checklist:

1. Go to **Admin → Orders → (select order) → Edit Service → WindowsVM tab**.
2. Ensure **Provisioning Status = Active**.
3. Fill in at least:
   - Public IP
   - RDP Port
   - Username
   - Password
4. Click **Save Access Details**.
5. Refresh the client page.

## “The selected status is invalid” in the admin page

Make sure you are using one of these values:

- `pending`
- `active`
- `suspended`

If you changed the dropdown labels/translations, keep the **option values** unchanged.

## I updated the code but the old UI still shows

Clear caches:

```bash
php artisan optimize:clear
```

Then refresh the page in a private window to bypass browser cache.
