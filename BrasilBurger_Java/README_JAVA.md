# Brasil Burger Management - Java Console

## Overview
This is the **Manager's Console Application** for Brasil Burger. It allows the management of resources (Burgers, Menus, Complements) via a Command Line Interface (CLI).
It connects to the same PostgreSQL database as the Web Application.

## Requirements
- Java 17+
- Maven 3.x
- PostgreSQL Database (running)

## Setup
1. **Database connection**: 
   The app tries to read environment variables for DB connection, or defaults to localhost.
   You can create a `.env` file in the root of `BrasilBurger_Java` with:
   ```env
   DB_URL=jdbc:postgresql://localhost:5432/BrasilBurger
   DB_USER=postgres
   DB_PASS=password
   ```

## Running the App
Run with Maven:
```bash
mvn clean compile exec:java
```

## Features
- **List/Add Burgers**: View current catalogue and add new burgers.
- **List/Add Menus**: Manage menus.
- **List/Add Complements**: Manage extras (fries, drinks).
- **Shared DB**: Changes made here immediately appear on the C# Web Website.
