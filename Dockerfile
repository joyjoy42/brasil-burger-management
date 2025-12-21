# Dockerfile pour application .NET 6.0 ASP.NET Core
# Multi-stage build pour optimiser la taille de l'image

# Stage 1: Base runtime
FROM mcr.microsoft.com/dotnet/aspnet:6.0 AS base
WORKDIR /app
EXPOSE 10000
ENV ASPNETCORE_URLS=http://+:10000

# Stage 2: Build
FROM mcr.microsoft.com/dotnet/sdk:6.0 AS build
WORKDIR /src

# Copier les fichiers de projet (si .csproj à la racine)
# Si le projet est dans un sous-dossier, ajustez le chemin
COPY *.csproj ./
RUN dotnet restore

# Copier le reste des fichiers
COPY . ./
RUN dotnet publish -c Release -o /app/publish

# Stage 3: Final
FROM base AS final
WORKDIR /app
COPY --from=build /app/publish .
ENTRYPOINT ["dotnet", "BrasilBurger.Web.dll"]

