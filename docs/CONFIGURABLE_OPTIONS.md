# Configurable Options

This module supports optional keys so you can represent custom resources on the order (CPU/RAM/Disk/etc.).

## Supported keys

- `vm_cpu` (integer)
- `vm_ram_gb` (integer)
- `vm_disk_gb` (integer)
- `vm_location` (string)

## Notes

These keys are **optional**. If you don't use them, the module still works.

If you want the client to see these values, set them as configurable options in your product setup.

