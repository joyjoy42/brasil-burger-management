FROM mcr.microsoft.com/dotnet/sdk:8.0 AS build
WORKDIR /app

# Copy csproj and restore
COPY csharp-app/BrasilBurgerClient.csproj ./
RUN dotnet restore BrasilBurgerClient.csproj

# Copy everything else and build app
COPY csharp-app/. ./
RUN dotnet publish -c Release -o out

# Build runtime image
FROM mcr.microsoft.com/dotnet/aspnet:8.0
WORKDIR /app
COPY --from=build /app/out .
ENTRYPOINT ["dotnet", "BrasilBurgerClient.dll"]
