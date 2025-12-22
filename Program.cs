using Microsoft.AspNetCore.Builder;
using Microsoft.Extensions.DependencyInjection;
using Microsoft.Extensions.Hosting;
using Microsoft.AspNetCore.Authentication.Cookies;
using Microsoft.EntityFrameworkCore;
using BrasilBurger.Web.Services;
using BrasilBurger.Web.Data;
using BrasilBurger.Web.Models.Entities;
using System.Linq;

var builder = WebApplication.CreateBuilder(args);

// Configuration
builder.Services.AddControllersWithViews();

// DbContext - PostgreSQL (Neon)
var connectionString = builder.Configuration.GetConnectionString("DefaultConnection");
if (!string.IsNullOrEmpty(connectionString))
{
    builder.Services.AddDbContext<AppDbContext>(options =>
    {
        options.UseNpgsql(connectionString);
        // PostgreSQL requires UTC timestamps
        AppContext.SetSwitch("Npgsql.EnableLegacyTimestampBehavior", true);
    });
}

// Authentication - cookies
builder.Services.AddAuthentication(CookieAuthenticationDefaults.AuthenticationScheme)
    .AddCookie(options =>
    {
        options.LoginPath = "/Account/Login";
        options.AccessDeniedPath = "/Account/AccessDenied";
        options.ExpireTimeSpan = TimeSpan.FromMinutes(30);
        options.SlidingExpiration = true;
    });

// Session
builder.Services.AddDistributedMemoryCache();
var idleMinutes = builder.Configuration.GetValue<int?>("Session:IdleTimeoutMinutes") ?? 30;
builder.Services.AddSession(options =>
{
    options.IdleTimeout = TimeSpan.FromMinutes(idleMinutes);
    options.Cookie.HttpOnly = true;
    options.Cookie.IsEssential = true;
});

// DI for services
builder.Services.AddScoped<ICatalogueService, CatalogueService>();
builder.Services.AddScoped<ICommandeService, CommandeService>();
builder.Services.AddScoped<IClientService, ClientService>();

var app = builder.Build();

// Seed the database
using (var scope = app.Services.CreateScope())
{
    var services = scope.ServiceProvider;
    var context = services.GetRequiredService<AppDbContext>();
    context.Database.EnsureCreated();
    if (!context.Burgers.Any())
    {
        // Burgers - Images hébergées sur Cloudinary
        // Si les images ne s'affichent pas, vérifiez qu'elles existent sur Cloudinary dans le dossier "brasil-burger"
        var cloudinaryBase = "https://res.cloudinary.com/dbkji1d1j/image/upload/brasil-burger";
        // Alternative avec placeholders : var cloudinaryBase = "https://via.placeholder.com/800x600?text=";
        var burgers = new[]
        {
            new Burger { Nom = "Burger Classique", Description = "Steak, salade, tomate, sauce", Prix = 2500m, Image = $"{cloudinaryBase}/burger-classique.jpg" },
            new Burger { Nom = "Cheeseburger", Description = "Burger classique avec fromage", Prix = 2800m, Image = $"{cloudinaryBase}/cheeseburger.jpg" },
            new Burger { Nom = "Burger Poulet Croustillant", Description = "Poulet frit croustillant", Prix = 2700m, Image = $"{cloudinaryBase}/burger-classique.jpg" },
            new Burger { Nom = "Burger Épicé", Description = "Burger avec sauce épicée", Prix = 2900m, Image = $"{cloudinaryBase}/cheeseburger.jpg" },
            new Burger { Nom = "Sandwich Shawarma Poulet", Description = "Shawarma au poulet", Prix = 3000m, Image = $"{cloudinaryBase}/wrap-poulet.png" },
            new Burger { Nom = "Sandwich Shawarma Bœuf", Description = "Shawarma au bœuf", Prix = 3200m, Image = $"{cloudinaryBase}/wrap-boeuf.png" },
            new Burger { Nom = "Hot-dog", Description = "Saucisse dans un pain", Prix = 2000m, Image = $"{cloudinaryBase}/burger-classique.jpg" }
        };
        context.Burgers.AddRange(burgers);

        // Complements (accompagnements et boissons) - Images Cloudinary
        var complements = new[]
        {
            // Accompagnements
            new Complement { Nom = "Frites Classiques", Type = "frite", Prix = 1000m, Image = $"{cloudinaryBase}/nuggets.png" },
            new Complement { Nom = "Frites Épicées", Type = "frite", Prix = 1200m, Image = $"{cloudinaryBase}/nuggets.png" },
            new Complement { Nom = "Alloco", Type = "frite", Prix = 1500m, Image = $"{cloudinaryBase}/nuggets.png" },
            new Complement { Nom = "Potatoes", Type = "frite", Prix = 1300m, Image = $"{cloudinaryBase}/nuggets.png" },
            new Complement { Nom = "Riz Sauté", Type = "frite", Prix = 1400m, Image = $"{cloudinaryBase}/poulet-braise.png" },
            new Complement { Nom = "Salade Fraîche", Type = "frite", Prix = 800m, Image = $"{cloudinaryBase}/wrap-poulet.png" },

            // Boissons
            new Complement { Nom = "Eau Minérale", Type = "boisson", Prix = 500m, Image = $"{cloudinaryBase}/jus-ananas.png" },
            new Complement { Nom = "Coca-Cola", Type = "boisson", Prix = 800m, Image = $"{cloudinaryBase}/jus-ananas.png" },
            new Complement { Nom = "Fanta", Type = "boisson", Prix = 800m, Image = $"{cloudinaryBase}/jus-ananas.png" },
            new Complement { Nom = "Sprite", Type = "boisson", Prix = 800m, Image = $"{cloudinaryBase}/jus-ananas.png" },
            new Complement { Nom = "Jus Bissap", Type = "boisson", Prix = 1000m, Image = $"{cloudinaryBase}/jus-bissap.png" },
            new Complement { Nom = "Jus Gingembre", Type = "boisson", Prix = 1000m, Image = $"{cloudinaryBase}/jus-gingembre.png" },
            new Complement { Nom = "Jus Ananas", Type = "boisson", Prix = 1000m, Image = $"{cloudinaryBase}/jus-ananas.png" },
            new Complement { Nom = "Milkshake Vanille", Type = "boisson", Prix = 1500m, Image = $"{cloudinaryBase}/milkshake-vanille.png" },
            new Complement { Nom = "Milkshake Chocolat", Type = "boisson", Prix = 1500m, Image = $"{cloudinaryBase}/milkshake-chocolat.png" },
            new Complement { Nom = "Milkshake Fraise", Type = "boisson", Prix = 1500m, Image = $"{cloudinaryBase}/milkshake-fraise.png" }
        };
        context.Complements.AddRange(complements);

        // Poulet et grillades - Images Cloudinary
        var pouletItems = new[]
        {
            new Burger { Nom = "Poulet Frit (1 morceau)", Description = "1 morceau de poulet frit", Prix = 1200m, Image = $"{cloudinaryBase}/poulet-1.png" },
            new Burger { Nom = "Poulet Frit (2 morceaux)", Description = "2 morceaux de poulet frit", Prix = 2200m, Image = $"{cloudinaryBase}/poulet-2.png" },
            new Burger { Nom = "Poulet Frit (4 morceaux)", Description = "4 morceaux de poulet frit", Prix = 4000m, Image = $"{cloudinaryBase}/poulet-1.png" },
            new Burger { Nom = "Chicken Wings BBQ", Description = "Ailes de poulet BBQ", Prix = 2500m, Image = $"{cloudinaryBase}/wings-bbq.png" },
            new Burger { Nom = "Chicken Wings Épicés", Description = "Ailes de poulet épicées", Prix = 2600m, Image = $"{cloudinaryBase}/wings-epice.png" },
            new Burger { Nom = "Nuggets de Poulet (6pcs)", Description = "6 nuggets de poulet", Prix = 1800m, Image = $"{cloudinaryBase}/nuggets.png" },
            new Burger { Nom = "Brochettes de Poulet", Description = "Brochettes de poulet grillé", Prix = 2000m, Image = $"{cloudinaryBase}/brochettes-poulet.png" },
            new Burger { Nom = "Poulet Braisé", Description = "Poulet braisé avec accompagnement", Prix = 3500m, Image = $"{cloudinaryBase}/poulet-braise.png" }
        };
        context.Burgers.AddRange(pouletItems);

        // Wraps & Tacos - Images Cloudinary
        var wraps = new[]
        {
            new Burger { Nom = "Wrap Poulet", Description = "Wrap au poulet", Prix = 2800m, Image = $"{cloudinaryBase}/wrap-poulet.png" },
            new Burger { Nom = "Wrap Bœuf", Description = "Wrap au bœuf", Prix = 3000m, Image = $"{cloudinaryBase}/wrap-boeuf.png" },
            new Burger { Nom = "Tacos Simple", Description = "Tacos simple", Prix = 2500m, Image = $"{cloudinaryBase}/tacos-simple.png" },
            new Burger { Nom = "Tacos XL", Description = "Tacos XL avec fromage, frites et viande", Prix = 4000m, Image = $"{cloudinaryBase}/tacos-xl.png" }
        };
        context.Burgers.AddRange(wraps);

        // Desserts - Images Cloudinary
        var desserts = new[]
        {
            new Burger { Nom = "Glace", Description = "Glace vanille", Prix = 1000m, Image = $"{cloudinaryBase}/glace.png" },
            new Burger { Nom = "Donut", Description = "Donut sucré", Prix = 800m, Image = $"{cloudinaryBase}/donut.png" },
            new Burger { Nom = "Crêpe Sucrée", Description = "Crêpe sucrée", Prix = 1200m, Image = $"{cloudinaryBase}/crepe-sucree.png" },
            new Burger { Nom = "Crêpe Chocolat", Description = "Crêpe au chocolat", Prix = 1400m, Image = $"{cloudinaryBase}/crepe-chocolat.png" },
            new Burger { Nom = "Gâteau Simple", Description = "Gâteau simple", Prix = 1500m, Image = $"{cloudinaryBase}/gateau.png" }
        };
        context.Burgers.AddRange(desserts);

        // Menus (combos) - Images Cloudinary
        var menus = new[]
        {
            new Menu { Nom = "Menu Étudiant", Description = "Burger + frites + boisson", Prix = 4500m, Image = $"{cloudinaryBase}/menu-etudiant.png" },
            new Menu { Nom = "Menu Poulet", Description = "Poulet frit + frites + boisson", Prix = 5000m, Image = $"{cloudinaryBase}/menu-poulet.png" },
            new Menu { Nom = "Menu Tacos", Description = "Tacos + boisson", Prix = 3500m, Image = $"{cloudinaryBase}/menu-tacos.png" },
            new Menu { Nom = "Menu Duo", Description = "2 burgers + 2 frites + 2 boissons", Prix = 8000m, Image = $"{cloudinaryBase}/menu-etudiant.png" },
            new Menu { Nom = "Menu Famille", Description = "Poulet entier + accompagnements + boissons", Prix = 12000m, Image = $"{cloudinaryBase}/menu-famille.png" }
        };
        context.Menus.AddRange(menus);

        context.SaveChanges();
    }
}

// Configure the HTTP request pipeline
if (!app.Environment.IsDevelopment())
{
    app.UseExceptionHandler("/Home/Error");
    app.UseHsts();
}

app.UseHttpsRedirection();
app.UseStaticFiles();

app.UseRouting();

app.UseSession();
app.UseAuthentication();
app.UseAuthorization();

app.MapControllerRoute(
    name: "default",
    pattern: "{controller=Catalogue}/{action=Index}/{id?}");

app.Run();
