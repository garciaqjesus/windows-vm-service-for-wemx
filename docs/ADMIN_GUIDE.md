# Admin Guide (WindowsVM Module)

## Installation

1. Upload/copy the module to:

   ```
   app/Services/WindowsVM
   ```

2. Clear caches:

   ```bash
   php artisan optimize:clear
   ```

3. Run the DB migration:

   ```bash
   php artisan migrate
   ```

The migration creates a table called `windowsvm_access` which stores the connection data per order.

## Creating the product

1. In **Admin → Products & Services**, create a product (e.g. **Windows Virtual Machine**).
2. Set the product **Service/Module** to **WindowsVM**.
3. Configure pricing and (optional) configurable options (extra RAM / vCPU / Disk). The module will display these options on the client side.

## Managing an order

Open an order in the admin panel and click **WindowsVM** tab (inside the order edit page).

Fill in:

- **Provisioning Status**
  - `pending`: VM is not ready yet
  - `active`: VM is ready and access details should be shown to the customer
  - `suspended`: temporarily disabled
- **Public IP**: the VM public IP
- **RDP Port**: default `3389` (or your forwarded port)
- **Username / Password**: RDP credentials
- **Notes**: any extra instructions (e.g., “Change password on first login”)

Click **Save Access Details**.

### Important

- The client portal shows the access card when the status is **active**.
- If you set status to **pending** or **suspended**, the client sees a provisioning message instead of credentials.

## Security recommendations

- Use **strong passwords**.
- Consider showing a **temporary password** and asking users to change it on first login.
- Disable `APP_DEBUG` in production.
