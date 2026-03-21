#!/bin/bash

# NiDrip Local Startup Script
# This script starts both the Node.js frontend and the PHP Admin Panel.

# 1. Kill any existing processes on ports 3001 and 8001
echo "Cleaning up ports 3001 and 8001..."
fuser -k 3001/tcp 2>/dev/null
fuser -k 8001/tcp 2>/dev/null

# 2. Start Node.js Application (Port 3001)
echo "Starting Node.js App on http://localhost:3001..."
npm start &

# 3. Start PHP Admin Panel (Port 8001)
# Using PHP's built-in server for simplicity.
echo "Starting PHP Admin Panel on http://localhost:8001/admin/dashboard/..."
php -S localhost:8001 -t cms &

echo "-------------------------------------------------------"
echo "Done! You can now access:"
echo "- Customer App: http://localhost:3001"
echo "- Admin Panel:  http://localhost:8001/admin/dashboard/"
echo "-------------------------------------------------------"
echo "Press Ctrl+C to stop both servers."

# Keep the script running to catch Ctrl+C
wait
