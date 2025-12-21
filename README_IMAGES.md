# Where to Upload Menu Images

## Location

All images should be placed in the **`wwwroot/images/`** folder.

The folder structure should look like this:
```
brasil-burger-management/
├── wwwroot/
│   └── images/
│       ├── burger-classique.jpg
│       ├── cheeseburger.jpg
│       ├── menu-etudiant.jpg
│       └── ... (all other images)
```

## How It Works

In ASP.NET Core MVC, the `wwwroot` folder is the root for static files. Files placed in `wwwroot/images/` can be accessed via the URL path `/images/filename.jpg`.

## Image Paths in Database

The database stores image paths like `/images/burger-classique.jpg`. These paths are relative to the `wwwroot` folder.

## Example

If you upload an image file named `burger-classique.jpg` to `wwwroot/images/`, it will be accessible at:
- **File location**: `wwwroot/images/burger-classique.jpg`
- **URL**: `http://localhost:5000/images/burger-classique.jpg`

## Quick Steps

1. Navigate to the `wwwroot/images/` folder in your project
2. Upload all your product images there
3. Make sure the filenames match what's in the database (see `Program.cs` for the seed data)
4. The images will automatically be available in your web application

## Missing Images

If an image is missing, the application will:
- Show a placeholder image (if configured)
- Display an alternative text (alt attribute)
- Use a fallback image URL (configured in views)

For a complete list of required images, see `wwwroot/images/README.md`.

