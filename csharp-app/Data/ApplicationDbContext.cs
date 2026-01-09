using Microsoft.EntityFrameworkCore;
using BrasilBurgerClient.Models;

namespace BrasilBurgerClient.Data;

public class ApplicationDbContext : DbContext
{
    public ApplicationDbContext(DbContextOptions<ApplicationDbContext> options)
        : base(options)
    {
    }

    public DbSet<User> Users { get; set; }
    public DbSet<Product> Products { get; set; }
    public DbSet<Menu> Menus { get; set; }
    public DbSet<MenuItem> MenuItems { get; set; }
    public DbSet<Order> Orders { get; set; }
    public DbSet<OrderDetail> OrderDetails { get; set; }
    public DbSet<Zone> Zones { get; set; }

    protected override void OnModelCreating(ModelBuilder modelBuilder)
    {
        base.OnModelCreating(modelBuilder);
        
        // Composite key for MenuItem
        modelBuilder.Entity<MenuItem>()
            .HasKey(mi => new { mi.MenuId, mi.ProductId });

        // Table mapping (to match SQL schema)
        modelBuilder.Entity<User>().ToTable("users");
        modelBuilder.Entity<Product>().ToTable("products");
        modelBuilder.Entity<Menu>().ToTable("menus");
        modelBuilder.Entity<MenuItem>().ToTable("menu_items");
        modelBuilder.Entity<Order>().ToTable("commandes");
        modelBuilder.Entity<OrderDetail>().ToTable("commande_details");
        modelBuilder.Entity<Zone>().ToTable("zones");

        // Column mappings for snake_case
        modelBuilder.Entity<User>().Property(u => u.Nom).HasColumnName("nom");
        modelBuilder.Entity<User>().Property(u => u.Prenom).HasColumnName("prenom");
        modelBuilder.Entity<User>().Property(u => u.Telephone).HasColumnName("telephone");
        modelBuilder.Entity<User>().Property(u => u.Adresse).HasColumnName("adresse");
        modelBuilder.Entity<User>().Property(u => u.Login).HasColumnName("login");
        modelBuilder.Entity<User>().Property(u => u.Password).HasColumnName("password");
        modelBuilder.Entity<User>().Property(u => u.Role).HasColumnName("role").HasColumnType("user_role");

        modelBuilder.Entity<Product>().Property(p => p.Nom).HasColumnName("nom");
        modelBuilder.Entity<Product>().Property(p => p.Prix).HasColumnName("prix");
        modelBuilder.Entity<Product>().Property(p => p.Type).HasColumnName("type").HasColumnType("product_type");
        modelBuilder.Entity<Product>().Property(p => p.Image).HasColumnName("image");
        modelBuilder.Entity<Product>().Property(p => p.EstArchive).HasColumnName("est_archive");

        modelBuilder.Entity<Menu>().Property(m => m.Nom).HasColumnName("nom");
        modelBuilder.Entity<Menu>().Property(m => m.Image).HasColumnName("image");
        modelBuilder.Entity<Menu>().Property(m => m.EstArchive).HasColumnName("est_archive");

        modelBuilder.Entity<Order>().Property(o => o.ClientId).HasColumnName("client_id");
        modelBuilder.Entity<Order>().Property(o => o.ZoneId).HasColumnName("zone_id");
        modelBuilder.Entity<Order>().Property(o => o.DateCommande).HasColumnName("date_commande");
        modelBuilder.Entity<Order>().Property(o => o.Etat).HasColumnName("etat").HasColumnType("order_status");
        modelBuilder.Entity<Order>().Property(o => o.TypeCommande).HasColumnName("type_commande").HasColumnType("order_type");
        modelBuilder.Entity<Order>().Property(o => o.PrixTotal).HasColumnName("prix_total");
        modelBuilder.Entity<Order>().Property(o => o.LivreurId).HasColumnName("livreur_id");

        modelBuilder.Entity<OrderDetail>().Property(od => od.CommandeId).HasColumnName("commande_id");
        modelBuilder.Entity<OrderDetail>().Property(od => od.ProductId).HasColumnName("product_id");
        modelBuilder.Entity<OrderDetail>().Property(od => od.MenuId).HasColumnName("menu_id");
        modelBuilder.Entity<OrderDetail>().Property(od => od.Quantite).HasColumnName("quantite");
        modelBuilder.Entity<OrderDetail>().Property(od => od.PrixUnitaire).HasColumnName("prix_unitaire");

        modelBuilder.Entity<Zone>().Property(z => z.Nom).HasColumnName("nom");
        modelBuilder.Entity<Zone>().Property(z => z.FraisLivraison).HasColumnName("frais_livraison");
    }
}
