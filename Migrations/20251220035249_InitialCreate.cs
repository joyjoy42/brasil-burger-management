using System;
using Microsoft.EntityFrameworkCore.Migrations;

#nullable disable

namespace BrasilBurger.Web.Migrations
{
    public partial class InitialCreate : Migration
    {
        protected override void Up(MigrationBuilder migrationBuilder)
        {
            migrationBuilder.CreateTable(
                name: "burgers",
                columns: table => new
                {
                    id = table.Column<int>(type: "INTEGER", nullable: false)
                        .Annotation("Sqlite:Autoincrement", true),
                    nom = table.Column<string>(type: "TEXT", maxLength: 100, nullable: false),
                    description = table.Column<string>(type: "TEXT", nullable: true),
                    prix = table.Column<decimal>(type: "TEXT", nullable: false),
                    image = table.Column<string>(type: "TEXT", nullable: true)
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_burgers", x => x.id);
                });

            migrationBuilder.CreateTable(
                name: "clients",
                columns: table => new
                {
                    id = table.Column<int>(type: "INTEGER", nullable: false)
                        .Annotation("Sqlite:Autoincrement", true),
                    nom = table.Column<string>(type: "TEXT", maxLength: 100, nullable: false),
                    prenom = table.Column<string>(type: "TEXT", maxLength: 100, nullable: false),
                    telephone = table.Column<string>(type: "TEXT", maxLength: 20, nullable: false),
                    email = table.Column<string>(type: "TEXT", maxLength: 150, nullable: false),
                    password = table.Column<string>(type: "TEXT", nullable: false),
                    adresse = table.Column<string>(type: "TEXT", maxLength: 255, nullable: true),
                    created_at = table.Column<DateTime>(type: "TEXT", nullable: false)
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_clients", x => x.id);
                });

            migrationBuilder.CreateTable(
                name: "complements",
                columns: table => new
                {
                    id = table.Column<int>(type: "INTEGER", nullable: false)
                        .Annotation("Sqlite:Autoincrement", true),
                    nom = table.Column<string>(type: "TEXT", maxLength: 100, nullable: false),
                    type = table.Column<string>(type: "TEXT", maxLength: 50, nullable: false),
                    prix = table.Column<decimal>(type: "TEXT", nullable: false),
                    image = table.Column<string>(type: "TEXT", maxLength: 255, nullable: true),
                    archive = table.Column<bool>(type: "INTEGER", nullable: false),
                    created_at = table.Column<DateTime>(type: "TEXT", nullable: false)
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_complements", x => x.id);
                });

            migrationBuilder.CreateTable(
                name: "commandes",
                columns: table => new
                {
                    id = table.Column<int>(type: "INTEGER", nullable: false)
                        .Annotation("Sqlite:Autoincrement", true),
                    numero = table.Column<string>(type: "TEXT", maxLength: 50, nullable: false),
                    client_id = table.Column<int>(type: "INTEGER", nullable: false),
                    type_livraison = table.Column<string>(type: "TEXT", maxLength: 20, nullable: true),
                    zone_id = table.Column<int>(type: "INTEGER", nullable: true),
                    montant_total = table.Column<decimal>(type: "TEXT", nullable: false),
                    etat = table.Column<string>(type: "TEXT", maxLength: 20, nullable: false),
                    date_commande = table.Column<DateTime>(type: "TEXT", nullable: false)
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_commandes", x => x.id);
                    table.ForeignKey(
                        name: "FK_commandes_clients_client_id",
                        column: x => x.client_id,
                        principalTable: "clients",
                        principalColumn: "id",
                        onDelete: ReferentialAction.Cascade);
                });

            migrationBuilder.CreateTable(
                name: "menus",
                columns: table => new
                {
                    id = table.Column<int>(type: "INTEGER", nullable: false)
                        .Annotation("Sqlite:Autoincrement", true),
                    nom = table.Column<string>(type: "TEXT", maxLength: 100, nullable: false),
                    description = table.Column<string>(type: "TEXT", nullable: true),
                    prix = table.Column<decimal>(type: "TEXT", nullable: false),
                    image = table.Column<string>(type: "TEXT", nullable: true),
                    BurgerId = table.Column<int>(type: "INTEGER", nullable: true),
                    BoissonId = table.Column<int>(type: "INTEGER", nullable: true)
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_menus", x => x.id);
                    table.ForeignKey(
                        name: "FK_menus_burgers_BurgerId",
                        column: x => x.BurgerId,
                        principalTable: "burgers",
                        principalColumn: "id");
                    table.ForeignKey(
                        name: "FK_menus_complements_BoissonId",
                        column: x => x.BoissonId,
                        principalTable: "complements",
                        principalColumn: "id");
                });

            migrationBuilder.CreateTable(
                name: "lignes_commande",
                columns: table => new
                {
                    id = table.Column<int>(type: "INTEGER", nullable: false)
                        .Annotation("Sqlite:Autoincrement", true),
                    commande_id = table.Column<int>(type: "INTEGER", nullable: false),
                    type_produit = table.Column<string>(type: "TEXT", maxLength: 20, nullable: false),
                    produit_id = table.Column<int>(type: "INTEGER", nullable: false),
                    quantite = table.Column<int>(type: "INTEGER", nullable: false),
                    prix_unitaire = table.Column<decimal>(type: "TEXT", nullable: false),
                    complements = table.Column<string>(type: "TEXT", nullable: true)
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_lignes_commande", x => x.id);
                    table.ForeignKey(
                        name: "FK_lignes_commande_commandes_commande_id",
                        column: x => x.commande_id,
                        principalTable: "commandes",
                        principalColumn: "id",
                        onDelete: ReferentialAction.Cascade);
                });

            migrationBuilder.CreateTable(
                name: "paiements",
                columns: table => new
                {
                    id = table.Column<int>(type: "INTEGER", nullable: false)
                        .Annotation("Sqlite:Autoincrement", true),
                    commande_id = table.Column<int>(type: "INTEGER", nullable: false),
                    montant = table.Column<decimal>(type: "TEXT", nullable: false),
                    methode = table.Column<string>(type: "TEXT", maxLength: 50, nullable: false),
                    date_paiement = table.Column<DateTime>(type: "TEXT", nullable: false),
                    reference = table.Column<string>(type: "TEXT", maxLength: 100, nullable: true),
                    statut = table.Column<string>(type: "TEXT", maxLength: 50, nullable: false)
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_paiements", x => x.id);
                    table.ForeignKey(
                        name: "FK_paiements_commandes_commande_id",
                        column: x => x.commande_id,
                        principalTable: "commandes",
                        principalColumn: "id",
                        onDelete: ReferentialAction.Cascade);
                });

            migrationBuilder.CreateIndex(
                name: "IX_commandes_client_id",
                table: "commandes",
                column: "client_id");

            migrationBuilder.CreateIndex(
                name: "IX_lignes_commande_commande_id",
                table: "lignes_commande",
                column: "commande_id");

            migrationBuilder.CreateIndex(
                name: "IX_menus_BoissonId",
                table: "menus",
                column: "BoissonId");

            migrationBuilder.CreateIndex(
                name: "IX_menus_BurgerId",
                table: "menus",
                column: "BurgerId");

            migrationBuilder.CreateIndex(
                name: "IX_paiements_commande_id",
                table: "paiements",
                column: "commande_id",
                unique: true);
        }

        protected override void Down(MigrationBuilder migrationBuilder)
        {
            migrationBuilder.DropTable(
                name: "lignes_commande");

            migrationBuilder.DropTable(
                name: "menus");

            migrationBuilder.DropTable(
                name: "paiements");

            migrationBuilder.DropTable(
                name: "burgers");

            migrationBuilder.DropTable(
                name: "complements");

            migrationBuilder.DropTable(
                name: "commandes");

            migrationBuilder.DropTable(
                name: "clients");
        }
    }
}
