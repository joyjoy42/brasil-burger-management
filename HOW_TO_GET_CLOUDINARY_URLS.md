# 📸 How to Get Cloudinary Image Delivery URLs

## ⚠️ Important: Console URL vs Delivery URL

The URL you provided:
```
https://console.cloudinary.com/app/c-f69ae335080562487aac4fd53a8890/assets/media_library/folders/...
```

This is a **dashboard/console URL** for viewing the folder in Cloudinary's interface. This is **NOT** the URL we need for displaying images.

## ✅ What We Need: Image Delivery URLs

We need the **delivery URL** format that looks like:
```
https://res.cloudinary.com/dbkji1d1j/image/upload/brasil-burger/burger-classique
```

## 📋 Step-by-Step Instructions

### Step 1: Open Your Folder in Cloudinary
1. Go to the folder URL you provided (or navigate to Media Library → brasil-burger folder)
2. You should see a list/grid of your uploaded images

### Step 2: Click on an Image
1. Click on any image (e.g., `burger-classique.jpg`)
2. This will open the image details panel

### Step 3: Find the Delivery URL
In the image details panel, look for one of these:

**Option A: "URL" or "Secure URL" field**
- Copy the URL that starts with `https://res.cloudinary.com/...`
- This is the delivery URL we need

**Option B: "Public ID" field**
- If you see a "Public ID" like `brasil-burger/burger-classique`
- The delivery URL would be: `https://res.cloudinary.com/dbkji1d1j/image/upload/brasil-burger/burger-classique`

### Step 4: Check the Format
The delivery URL should look like one of these:

**Format 1 (with folder in path):**
```
https://res.cloudinary.com/dbkji1d1j/image/upload/brasil-burger/burger-classique
```

**Format 2 (with version number):**
```
https://res.cloudinary.com/dbkji1d1j/image/upload/v1234567890/brasil-burger/burger-classique
```

**Format 3 (with file extension):**
```
https://res.cloudinary.com/dbkji1d1j/image/upload/brasil-burger/burger-classique.jpg
```

**Format 4 (no folder in path - Dynamic Folder Mode):**
```
https://res.cloudinary.com/dbkji1d1j/image/upload/burger-classique
```

### Step 5: Test the URL
1. Copy the delivery URL
2. Paste it in your browser's address bar
3. If the image displays → ✅ This is the correct format!
4. If you get 404 → ❌ The image might not be uploaded correctly

## 🔍 Quick Method: Right-Click on Image

1. In the Cloudinary Media Library, **right-click** on an image
2. Select **"Copy URL"** or **"Copy image address"**
3. This should give you the delivery URL directly

## 📝 What to Share

Once you have the delivery URL, please share:
1. **One example URL** from an image in your folder
2. The **format pattern** (with/without folder, with/without extension, etc.)

Example:
```
URL: https://res.cloudinary.com/dbkji1d1j/image/upload/brasil-burger/burger-classique
Format: {cloud_name}/image/upload/{folder}/{filename-without-extension}
```

## 🛠️ Once We Have the Format

Once you share the actual delivery URL format, I'll update the `ImageHelper.cs` to match your Cloudinary account's configuration.

---

**Note:** Cloudinary has two folder modes:
- **Fixed Folder Mode**: Folder is part of the public_id (URL includes folder)
- **Dynamic Folder Mode**: Folder is just for organization (URL doesn't include folder)

The delivery URL format depends on which mode your account uses.


