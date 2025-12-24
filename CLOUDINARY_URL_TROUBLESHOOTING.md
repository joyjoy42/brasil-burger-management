# 🔍 Cloudinary URL Troubleshooting Guide

## Issue: Images uploaded but still showing 404

If you've uploaded images to the `brasil-burger` folder on Cloudinary but they're still not displaying, follow these steps:

## Step 1: Verify Image URLs in Cloudinary Dashboard

1. Go to https://console.cloudinary.com
2. Navigate to **Media Library** → **brasil-burger** folder
3. Click on an image (e.g., `burger-classique.jpg`)
4. **Copy the full URL** shown in the details panel

The URL will look like one of these formats:
- `https://res.cloudinary.com/dbkji1d1j/image/upload/v1234567890/brasil-burger/burger-classique`
- `https://res.cloudinary.com/dbkji1d1j/image/upload/brasil-burger/burger-classique`
- `https://res.cloudinary.com/dbkji1d1j/image/upload/v1234567890/brasil-burger/burger-classique.jpg`

## Step 2: Test the URL in Browser

1. Paste the URL from Cloudinary into your browser
2. If the image displays → The URL format is correct
3. If you get 404 → The image might not be uploaded correctly

## Step 3: Check Public ID Format

In Cloudinary, the **Public ID** is what matters, not the filename. 

**Common formats:**
- Public ID: `brasil-burger/burger-classique` (folder included, no extension)
- Public ID: `burger-classique` (no folder, no extension)
- Public ID: `brasil-burger/burger-classique.jpg` (folder included, with extension)

**The URL format is:**
```
https://res.cloudinary.com/{cloud_name}/image/upload/{public_id}
```

## Step 4: Verify Database URLs

Check what URLs are stored in your database:

```sql
-- Check burger images
SELECT id, nom, image FROM burgers LIMIT 5;

-- Check menu images  
SELECT id, nom, image FROM menus LIMIT 5;
```

**Expected format:**
```
https://res.cloudinary.com/dbkji1d1j/image/upload/brasil-burger/burger-classique
```

**Note:** Cloudinary typically stores public_ids **without file extensions**, even if you uploaded a `.jpg` file.

## Step 5: Common Issues & Solutions

### Issue 1: Public ID includes extension but shouldn't
**Solution:** Remove extension from URLs in database or update ImageHelper

### Issue 2: Folder not in public_id
**Solution:** If images are in root, remove `brasil-burger/` from URLs

### Issue 3: Version number required
**Solution:** Cloudinary URLs work with or without version numbers (`v1234567890`)

### Issue 4: Images uploaded to wrong folder
**Solution:** Check actual folder name in Cloudinary dashboard

## Step 6: Use Test Endpoint

Visit: `/CloudinaryTest/TestUrls` to test different URL formats automatically.

## Step 7: Update Code if Needed

If the URL format in Cloudinary is different from what we're using, we can update `ImageHelper.cs` to match.

**Current format in code:**
```
https://res.cloudinary.com/dbkji1d1j/image/upload/brasil-burger/{filename-without-extension}
```

**If your Cloudinary URLs are different, share the format and we'll update the code.**

## Quick Fix: Use Actual Cloudinary URLs

If you have the actual URLs from Cloudinary dashboard, you can update the database directly:

```sql
UPDATE burgers 
SET image = 'https://res.cloudinary.com/dbkji1d1j/image/upload/v1234567890/brasil-burger/burger-classique'
WHERE nom = 'Burger Classique';
```

Replace with the actual URL format from your Cloudinary dashboard.

---

**Next Steps:**
1. Check Cloudinary dashboard for actual URL format
2. Test one URL in browser
3. Share the format if different from expected
4. We'll update the code accordingly


