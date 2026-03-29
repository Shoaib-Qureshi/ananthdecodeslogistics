#!/bin/bash

echo "==================================="
echo "Laravel Deployment Script"
echo "==================================="

# Create deployment archive excluding unnecessary files
echo "Creating deployment archive..."
tar -czf laravel-deploy.tar.gz \
  --exclude='node_modules' \
  --exclude='vendor' \
  --exclude='.git' \
  --exclude='.env' \
  --exclude='storage/logs/*.log' \
  --exclude='database_backup.sql' \
  --exclude='laravel-deploy.tar.gz' \
  --exclude='deploy.sh' \
  .

echo "Deployment archive created: laravel-deploy.tar.gz"
ls -lh laravel-deploy.tar.gz

echo ""
echo "==================================="
echo "Next Steps:"
echo "==================================="
echo "1. Upload laravel-deploy.tar.gz to your server"
echo "2. Upload database_backup.sql to your server"
echo "3. Follow the SSH deployment instructions"
echo ""
