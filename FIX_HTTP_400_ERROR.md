# 🔧 Résolution Erreur HTTP 400 (Bad Request)

## ❌ Erreur

```
HTTP ERROR 400
This page isn't working
```

## 🔍 Causes Possibles

Une erreur **HTTP 400 (Bad Request)** indique généralement :

1. **Problème de validation de formulaire** (ModelState invalide)
2. **Problème avec AntiForgeryToken** (CSRF token manquant ou invalide)
3. **Problème avec les cookies/session** (cookies bloqués)
4. **Problème de configuration HTTPS/HTTP** (mixed content)
5. **Problème avec les données du formulaire** (champs requis manquants)

---

## ✅ Solutions

### Solution 1 : Vérifier les Logs Render

1. **Render Dashboard** → Service → **Logs**
2. **Cherchez** les erreurs récentes
3. **Notez** les messages d'erreur spécifiques

### Solution 2 : Désactiver Temporairement la Validation AntiForgery (Test)

Pour tester si c'est un problème de token CSRF, modifiez temporairement `AccountController.cs` :

```csharp
[HttpPost]
// [ValidateAntiForgeryToken]  // ← Commenter temporairement
public async Task<IActionResult> Register(RegisterViewModel model)
{
    // ...
}
```

**⚠️ Important** : Remettez-le après le test pour la sécurité.

### Solution 3 : Vérifier la Configuration des Cookies

Dans `Program.cs`, vérifiez que les cookies sont correctement configurés :

```csharp
builder.Services.AddAuthentication(CookieAuthenticationDefaults.AuthenticationScheme)
    .AddCookie(options =>
    {
        options.LoginPath = "/Account/Login";
        options.AccessDeniedPath = "/Account/AccessDenied";
        options.ExpireTimeSpan = TimeSpan.FromMinutes(30);
        options.SlidingExpiration = true;
        options.Cookie.SameSite = SameSiteMode.Lax;  // ← Ajouter
        options.Cookie.SecurePolicy = CookieSecurePolicy.SameAsRequest;  // ← Ajouter
    });
```

### Solution 4 : Vérifier les Routes

Assurez-vous que les routes sont correctement configurées dans `Program.cs` :

```csharp
app.MapControllerRoute(
    name: "default",
    pattern: "{controller=Catalogue}/{action=Index}/{id?}");
```

### Solution 5 : Ajouter un Gestionnaire d'Erreurs

Ajoutez un middleware pour capturer les erreurs 400 :

```csharp
app.UseStatusCodePagesWithReExecute("/Home/Error", "?statusCode={0}");
```

---

## 🔍 Diagnostic Détaillé

### Étape 1 : Vérifier les Logs Render

Les logs Render devraient montrer l'erreur exacte :
- Erreur de validation ?
- Token CSRF manquant ?
- Cookie non défini ?

### Étape 2 : Tester avec un Navigateur Différent

Parfois, les extensions de navigateur ou les paramètres bloquent les cookies.

### Étape 3 : Vérifier la Console du Navigateur

**F12** → **Console** → Cherchez les erreurs JavaScript ou CORS.

### Étape 4 : Tester l'Inscription en Local

Si ça fonctionne en local mais pas sur Render, c'est probablement un problème de configuration.

---

## 🚀 Solution Immédiate

### Option 1 : Ajouter un Gestionnaire d'Erreurs Global

Créez `Controllers/ErrorController.cs` :

```csharp
public class ErrorController : Controller
{
    [Route("/Error/{statusCode}")]
    public IActionResult Error(int statusCode)
    {
        ViewBag.StatusCode = statusCode;
        return View();
    }
}
```

### Option 2 : Améliorer la Gestion des Erreurs dans Register

Modifiez `AccountController.cs` pour mieux gérer les erreurs :

```csharp
[HttpPost]
[ValidateAntiForgeryToken]
public async Task<IActionResult> Register(RegisterViewModel model)
{
    try
    {
        if (!ModelState.IsValid)
        {
            return View(model);
        }
        // ... reste du code
    }
    catch (Exception ex)
    {
        // Logger l'erreur
        ModelState.AddModelError(string.Empty, "Une erreur est survenue. Veuillez réessayer.");
        return View(model);
    }
}
```

---

## 📝 Checklist

- [ ] Vérifier les logs Render pour l'erreur exacte
- [ ] Tester avec un navigateur différent
- [ ] Vérifier la console du navigateur (F12)
- [ ] Vérifier que les cookies sont activés
- [ ] Tester l'inscription en local
- [ ] Vérifier la configuration HTTPS/HTTP

---

**Date** : Décembre 2025

