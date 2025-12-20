using Microsoft.AspNetCore.Builder;
using Microsoft.Extensions.DependencyInjection;
using Microsoft.Extensions.Hosting;
using Microsoft.AspNetCore.Authentication.Cookies;
using Microsoft.EntityFrameworkCore;
using BrasilBurger.Web.Services;
using BrasilBurger.Web.Data;

var builder = WebApplication.CreateBuilder(args);

// Configuration
builder.Services.AddControllersWithViews();

// DbContext (ensure AppDbContext exists and package Microsoft.EntityFrameworkCore.SqlServer is referenced)
var connectionString = builder.Configuration.GetConnectionString("DefaultConnection");
if (!string.IsNullOrEmpty(connectionString))
{
    builder.Services.AddDbContext<AppDbContext>(options =>
        options.UseSqlServer(connectionString));
}

// Authentication - cookies
builder.Services.AddAuthentication(CookieAuthenticationDefaults.AuthenticationScheme)
    .AddCookie(options =>
    {
        options.LoginPath = "/Account/Login";
        options.AccessDeniedPath = "/Account/AccessDenied";
    });

// Session
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
