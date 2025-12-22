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

# Copier le fichier .csproj et restaurer les dépendances
COPY BrasilBurger.Web.csproj ./
RUN dotnet restore BrasilBurger.Web.csproj

# Copier le reste des fichiers
COPY . ./
RUN dotnet build BrasilBurger.Web.csproj -c Release --no-restore

# Publier l'application
RUN dotnet publish BrasilBurger.Web.csproj -c Release -o /app/publish --no-build

# Stage 3: Final
FROM base AS final
WORKDIR /app
COPY --from=build /app/publish .
ENTRYPOINT ["dotnet", "BrasilBurger.Web.dll"]
