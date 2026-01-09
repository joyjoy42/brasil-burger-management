FROM mcr.microsoft.com/dotnet/sdk:8.0 AS build
WORKDIR /app

# Copy csproj and restore as distinct layers
COPY csharp-app/*.csproj ./csharp-app/
RUN dotnet restore csharp-app/BrasilBurgerClient.csproj

# Copy everything else and build app
COPY csharp-app/. ./csharp-app/
WORKDIR /app/csharp-app
RUN dotnet publish -c Release -o out

# Build runtime image
FROM mcr.microsoft.com/dotnet/aspnet:8.0
WORKDIR /app
COPY --from=build /app/csharp-app/out .
ENTRYPOINT ["dotnet", "BrasilBurgerClient.dll"]
