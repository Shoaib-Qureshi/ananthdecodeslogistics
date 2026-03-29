#!/bin/bash

echo "Creating update package with only changed files..."

# Create a directory for changed files
mkdir -p deployment_update

# Copy only the modified files maintaining directory structure
mkdir -p deployment_update/resources/views/blogs
mkdir -p deployment_update/resources/views/admin
mkdir -p deployment_update/resources/views/front
mkdir -p deployment_update/app/Http/Controllers/Admin
mkdir -p deployment_update/app/Http/Controllers/Front
mkdir -p deployment_update/public

# Copy modified files
cp resources/views/blogs/articlePage.blade.php deployment_update/resources/views/blogs/
cp resources/views/blogs/authorPage.blade.php deployment_update/resources/views/blogs/
cp resources/views/blogs/categoryPage.blade.php deployment_update/resources/views/blogs/
cp resources/views/blogs/allPost.blade.php deployment_update/resources/views/blogs/
cp resources/views/admin/editAboutPage.blade.php deployment_update/resources/views/admin/
cp resources/views/front/aboutUs.blade.php deployment_update/resources/views/front/
cp app/Http/Controllers/Admin/BlogController.php deployment_update/app/Http/Controllers/Admin/
cp app/Http/Controllers/Front/ArticleController.php deployment_update/app/Http/Controllers/Front/
cp public/.htaccess deployment_update/public/

# Create a small archive
cd deployment_update
tar -czf ../updates.tar.gz .
cd ..

echo "Update package created: updates.tar.gz"
ls -lh updates.tar.gz

rm -rf deployment_update

