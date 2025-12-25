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
        options.LoginPath = "/Account/Login.cshtml";
        options.AccessDeniedPath = "/Account/AccessDenied.cshtml";
        options.ExpireTimeSpan = TimeSpan.FromDays(30); // Session persistante de 30 jours
        options.SlidingExpiration = true;
        options.Cookie.SameSite = Microsoft.AspNetCore.Http.SameSiteMode.Lax;
        options.Cookie.SecurePolicy = Microsoft.AspNetCore.Http.CookieSecurePolicy.SameAsRequest;
        options.Cookie.HttpOnly = true;
        options.Cookie.Name = "BrasilBurger.Auth"; // Nom explicite pour le cookie
        options.Events.OnSigningIn = async (context) =>
        {
            // S'assurer que la session est bien créée
            context.Properties.IsPersistent = true;
            context.Properties.ExpiresUtc = DateTimeOffset.UtcNow.AddDays(30);
            await Task.CompletedTask;
        };
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

    // REPAIR STEP: Fix existing bad URLs from previous runs
    // Check if any entity has the double URL pattern
    var badBurgers = context.Burgers.Where(b => b.Image.StartsWith("https://res.cloudinary.com") && b.Image.Contains("/https://")).ToList();
    if (badBurgers.Any())
    {
        foreach (var b in badBurgers)
        {
            var parts = b.Image.Split(new[] { "/https://" }, StringSplitOptions.None);
            if (parts.Length > 1) { b.Image = "https://" + parts[1]; }
        }
        context.SaveChanges();
    }

    var badMenus = context.Menus.Where(m => m.Image.StartsWith("https://res.cloudinary.com") && m.Image.Contains("/https://")).ToList();
    if (badMenus.Any())
    {
        foreach (var m in badMenus)
        {
            var parts = m.Image.Split(new[] { "/https://" }, StringSplitOptions.None);
            if (parts.Length > 1) { m.Image = "https://" + parts[1]; }
        }
        context.SaveChanges();
    }

    var badComplements = context.Complements.Where(c => c.Image.StartsWith("https://res.cloudinary.com") && c.Image.Contains("/https://")).ToList();
    if (badComplements.Any())
    {
        foreach (var c in badComplements)
        {
            var parts = c.Image.Split(new[] { "/https://" }, StringSplitOptions.None);
            if (parts.Length > 1) { c.Image = "https://" + parts[1]; }
        }
        context.SaveChanges();
    }

    if (!context.Burgers.Any())
    {
        // Burgers - Images hébergées sur Cloudinary
        var burgers = new[]
        {
            new Burger { Nom = "Burger Classique", Description = "Steak, salade, tomate, sauce", Prix = 2500m, Image = "https://res.cloudinary.com/dbkji1d1j/image/upload/v1766285318/burger-classique_lca8ou.jpg" },
            new Burger { Nom = "Cheeseburger", Description = "Burger classique avec fromage", Prix = 2800m, Image = "https://res.cloudinary.com/dbkji1d1j/image/upload/v1766285320/cheeseburger_rsrep0.jpg" }, 
            new Burger { Nom = "Burger Poulet Croustillant", Description = "Poulet frit croustillant", Prix = 2700m, Image = "https://res.cloudinary.com/dbkji1d1j/image/upload/v1766285378/poulet-1_kxpdwe.png" },
            new Burger { Nom = "Burger Épicé", Description = "Burger avec sauce épicée", Prix = 2900m, Image = "https://res.cloudinary.com/dbkji1d1j/image/upload/v1766285333/category-menu_jmt4uu.png" },
            new Burger { Nom = "Sandwich Shawarma Poulet", Description = "Shawarma au poulet", Prix = 3000m, Image = "https://res.cloudinary.com/dbkji1d1j/image/upload/v1766538227/Sandwich_Shawarma_Poulet_v0chel.png" },
            new Burger { Nom = "Sandwich Shawarma Bœuf", Description = "Shawarma au bœuf", Prix = 3200m, Image = "https://res.cloudinary.com/dbkji1d1j/image/upload/v1766538439/Sandwich_Shawarma_B%C5%93uf_sxtdni.png" },
            new Burger { Nom = "Hot-dog", Description = "Saucisse dans un pain", Prix = 2000m, Image = "https://res.cloudinary.com/dbkji1d1j/image/upload/v1766538728/Hot-dog_ywf3uk.png" }
        };
        context.Burgers.AddRange(burgers);

        // Complements (accompagnements et boissons)
        var complements = new[]
        {
            // Accompagnements
            new Complement { Nom = "Frites Classiques", Type = "frite", Prix = 1000m, Image = "https://res.cloudinary.com/dbkji1d1j/image/upload/v1766538975/frites_ozvjzz.png" },
            new Complement { Nom = "Frites Épicées", Type = "frite", Prix = 1200m, Image = "https://res.cloudinary.com/dbkji1d1j/image/upload/v1766538974/frites-epicees_fdwwo9.png" },
            new Complement { Nom = "Alloco", Type = "frite", Prix = 1500m, Image = "https://res.cloudinary.com/dbkji1d1j/image/upload/v1766538973/alloco_zzzf0e.png" },
            new Complement { Nom = "Potatoes", Type = "frite", Prix = 1300m, Image = "https://res.cloudinary.com/dbkji1d1j/image/upload/v1766538977/potatoes_fw4yuz.png" },
            new Complement { Nom = "Riz Sauté", Type = "frite", Prix = 1400m, Image = "https://res.cloudinary.com/dbkji1d1j/image/upload/v1766538965/riz-saute_ltyqgt.png" },
            new Complement { Nom = "Salade Fraîche", Type = "frite", Prix = 800m, Image = "https://res.cloudinary.com/dbkji1d1j/image/upload/v1766538971/salade_mjwseg.png" },

            // Boissons
            new Complement { Nom = "Eau Minérale", Type = "boisson", Prix = 500m, Image = "https://res.cloudinary.com/dbkji1d1j/image/upload/v1766538958/eau_pocakr.jpg" },
            new Complement { Nom = "Coca-Cola", Type = "boisson", Prix = 800m, Image = "https://res.cloudinary.com/dbkji1d1j/image/upload/v1766538961/coca_gozrr2.jpg" },
            new Complement { Nom = "Fanta", Type = "boisson", Prix = 800m, Image = "https://res.cloudinary.com/dbkji1d1j/image/upload/v1766539443/Fanta_ck57zb.jpg" },
            new Complement { Nom = "Sprite", Type = "boisson", Prix = 800m, Image = "https://res.cloudinary.com/dbkji1d1j/image/upload/v1766538957/sprite_grgtrp.jpg" },
            new Complement { Nom = "Jus Bissap", Type = "boisson", Prix = 1000m, Image = "https://res.cloudinary.com/dbkji1d1j/image/upload/v1766285348/jus-bissap_us4any.png" },
            new Complement { Nom = "Jus Gingembre", Type = "boisson", Prix = 1000m, Image = "https://res.cloudinary.com/dbkji1d1j/image/upload/v1766285348/jus-gingembre_qafveh.png" },
            new Complement { Nom = "Jus Ananas", Type = "boisson", Prix = 1000m, Image = "https://res.cloudinary.com/dbkji1d1j/image/upload/v1766285349/jus-ananas_x2ya5n.png" },
            new Complement { Nom = "Milkshake Vanille", Type = "boisson", Prix = 1500m, Image = "https://res.cloudinary.com/dbkji1d1j/image/upload/v1766285365/milkshake-vanille_e3m028.png" },
            new Complement { Nom = "Milkshake Chocolat", Type = "boisson", Prix = 1500m, Image = "https://res.cloudinary.com/dbkji1d1j/image/upload/v1766285360/milkshake-chocolat_qzcdcd.png" },
            new Complement { Nom = "Milkshake Fraise", Type = "boisson", Prix = 1500m, Image = "https://res.cloudinary.com/dbkji1d1j/image/upload/v1766285377/milkshake-fraise_us8fxy.png" }
        };
        context.Complements.AddRange(complements);

        // Poulet et grillades
        var pouletItems = new[]
        {
            new Burger { Nom = "Poulet Frit (1 morceau)", Description = "1 morceau de poulet frit", Prix = 1200m, Image = "https://res.cloudinary.com/dbkji1d1j/image/upload/v1766541789/Poulet_Frit_1_morceau_shoiri.png" },
            new Burger { Nom = "Poulet Frit (2 morceaux)", Description = "2 morceaux de poulet frit", Prix = 2200m, Image = "https://res.cloudinary.com/dbkji1d1j/image/upload/v1766285378/poulet-1_kxpdwe.png" },
            new Burger { Nom = "Poulet Frit (4 morceaux)", Description = "4 morceaux de poulet frit", Prix = 4000m, Image = "https://res.cloudinary.com/dbkji1d1j/image/upload/v1766285384/poulet-2_qe9kcz.png" },
            new Burger { Nom = "Chicken Wings BBQ", Description = "Ailes de poulet BBQ", Prix = 2500m, Image = "https://res.cloudinary.com/dbkji1d1j/image/upload/v1766285396/wings-bbq_l9ybuh.png" },
            new Burger { Nom = "Chicken Wings Épicés", Description = "Ailes de poulet épicées", Prix = 2600m, Image = "https://res.cloudinary.com/dbkji1d1j/image/upload/v1766285393/wings-epice_egfa51.png" },
            new Burger { Nom = "Nuggets de Poulet (6pcs)", Description = "6 nuggets de poulet", Prix = 1800m, Image = "https://res.cloudinary.com/dbkji1d1j/image/upload/v1766285378/nuggets_dsk1ys.png" },
            new Burger { Nom = "Brochettes de Poulet", Description = "Brochettes de poulet grillé", Prix = 2000m, Image = "https://res.cloudinary.com/dbkji1d1j/image/upload/v1766285334/brochettes-poulet_sqtdiq.png" },
            new Burger { Nom = "Poulet Braisé", Description = "Poulet braisé avec accompagnement", Prix = 3500m, Image = "https://res.cloudinary.com/dbkji1d1j/image/upload/v1766285377/poulet-braise_u7bnfd.png" }
        };
        context.Burgers.AddRange(pouletItems);

        // Wraps & Tacos
        var wraps = new[]
        {
            new Burger { Nom = "Wrap Poulet", Description = "Wrap au poulet", Prix = 2800m, Image = " https://res.cloudinary.com/dbkji1d1j/image/upload/v1766285395/wrap-poulet_ztcpb7.png" },
            new Burger { Nom = "Wrap Bœuf", Description = "Wrap au bœuf", Prix = 3000m, Image = "https://res.cloudinary.com/dbkji1d1j/image/upload/v1766285394/wrap-boeuf_yxiwl6.png" },
            new Burger { Nom = "Tacos Simple", Description = "Tacos simple", Prix = 2500m, Image = "https://res.cloudinary.com/dbkji1d1j/image/upload/v1766285385/tacos-simple_itkw4f.png" },
            new Burger { Nom = "Tacos XL", Description = "Tacos XL avec fromage, frites et viande", Prix = 4000m, Image = "https://res.cloudinary.com/dbkji1d1j/image/upload/v1766285388/tacos-xl_k8rqev.png" }
        };
        context.Burgers.AddRange(wraps);

        // Desserts
        var desserts = new[]
        {
            new Burger { Nom = "Glace", Description = "Glace vanille", Prix = 1000m, Image = "https://res.cloudinary.com/dbkji1d1j/image/upload/v1766285347/glace_p62g9a.png" },
            new Burger { Nom = "Donut", Description = "Donut sucré", Prix = 800m, Image = "https://res.cloudinary.com/dbkji1d1j/image/upload/v1766285344/donut_tiwwzt.png" },
            new Burger { Nom = "Crêpe Sucrée", Description = "Crêpe sucrée", Prix = 1200m, Image = "https://res.cloudinary.com/dbkji1d1j/image/upload/v1766285333/crepe-sucree_dbp0hb.png" },
            new Burger { Nom = "Crêpe Chocolat", Description = "Crêpe au chocolat", Prix = 1400m, Image = "https://res.cloudinary.com/dbkji1d1j/image/upload/v1766285334/crepe-chocolat_vrggq9.png" },
            new Burger { Nom = "Gâteau Simple", Description = "Gâteau simple", Prix = 1500m, Image = "https://res.cloudinary.com/dbkji1d1j/image/upload/v1766285346/gateau_audhwy.png" }
        };
        context.Burgers.AddRange(desserts);

        // Menus (combos)
        var menus = new[]
        {
            new Menu { Nom = "Menu Étudiant", Description = "Burger + frites + boisson", Prix = 4500m, Image = "https://res.cloudinary.com/dbkji1d1j/image/upload/v1766285358/menu-etudiant_xbjefv.png" },
            new Menu { Nom = "Menu Poulet", Description = "Poulet frit + frites + boisson", Prix = 5000m, Image = "https://res.cloudinary.com/dbkji1d1j/image/upload/v1766285363/menu-poulet_fd5vnz.png" },
            new Menu { Nom = "Menu Tacos", Description = "Tacos + boisson", Prix = 3500m, Image = "https://res.cloudinary.com/dbkji1d1j/image/upload/v1766285366/menu-tacos_skpcxe.png" },
            new Menu { Nom = "Menu Duo", Description = "2 burgers + 2 frites + 2 boissons", Prix = 8000m, Image = "https://res.cloudinary.com/dbkji1d1j/image/upload/v1766543317/Menu_Duo_utvgo0.png" },
            new Menu { Nom = "Menu Famille", Description = "Poulet entier + accompagnements + boissons", Prix = 12000m, Image = "https://res.cloudinary.com/dbkji1d1j/image/upload/v1766543633/Menu_Famille_rfgt65.png" }
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
