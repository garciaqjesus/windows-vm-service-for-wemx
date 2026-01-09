# Client Guide (WindowsVM Module)

## Where to find your VM connection details

1. Login to the client area
2. Go to **Services**
3. Open your **Windows Virtual Machine** service
4. Open the **WindowsVM** tab

If your VM is **Active**, you will see:

- Public IP
- RDP Port
- Username
- Password
- Optional notes from the admin

## How to connect (RDP)

### Windows

1. Press `Win + R`
2. Type: `mstsc`
3. Enter:

   ```
   <IP>:<PORT>
   ```

4. Login with the username/password provided.

### macOS

Use "Microsoft Remote Desktop" from the App Store.

### Linux

Use Remmina or any RDP client.

## What does the status mean?

- **Pending**: provisioning is in progress
- **Active**: VM is ready and you can connect
- **Suspended**: service is temporarily disabled (contact support)

