#!/usr/bin/env python3
"""
Storage Symlink Creator for Windows
Creates a junction link from public/storage to storage/app/public
"""

import os
import subprocess
import sys

project_path = os.path.dirname(os.path.abspath(__file__))
link_path = os.path.join(project_path, 'public', 'storage')
target_path = os.path.join(project_path, 'storage', 'app', 'public')

print("╔════════════════════════════════════════════════════════════════╗")
print("║         AmikomHub Storage Symlink Creator                      ║")
print("╚════════════════════════════════════════════════════════════════╝\n")

print(f"Project:  {project_path}")
print(f"Link:     {link_path}")
print(f"Target:   {target_path}\n")

# Check target exists
if not os.path.isdir(target_path):
    print(f"❌ Error: Target directory not found: {target_path}")
    sys.exit(1)

print(f"✓ Target directory exists")

# Remove existing
if os.path.exists(link_path) or os.path.islink(link_path):
    try:
        if os.path.isdir(link_path):
            os.rmdir(link_path)
        else:
            os.unlink(link_path)
        print("✓ Removed existing link/directory")
    except Exception as e:
        print(f"❌ Could not remove existing: {e}")
        sys.exit(1)

# Create symlink/junction
try:
    # Try symlink first (works on Windows 10+ with admin or developer mode)
    os.symlink(target_path, link_path, target_is_directory=True)
    print("✓ Symlink created successfully!")
except (OSError, NotImplementedError):
    # Fall back to mklink command
    try:
        cmd = f'mklink /D "{link_path}" "{target_path}"'
        result = subprocess.run(cmd, shell=True, capture_output=True, text=True)

        if result.returncode == 0:
            print("✓ Junction created with mklink!")
            print(f"  Output: {result.stdout.strip()}")
        else:
            print(f"❌ mklink failed with code {result.returncode}")
            print(f"  Error: {result.stderr}")
            sys.exit(1)
    except Exception as e:
        print(f"❌ Failed to create junction: {e}")
        sys.exit(1)

# Verify
if os.path.isdir(link_path) or os.path.islink(link_path):
    print("\n✅ SUCCESS! Storage setup complete!")
    print(f"   Location: {link_path}")
else:
    print("❌ Link not found after creation")
    sys.exit(1)

print("\nYou can now upload event posters from the Admin Dashboard!")
