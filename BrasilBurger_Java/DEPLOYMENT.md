# 🚀 Guide de Déploiement - Application Java Brasil Burger

## 📋 Options de Déploiement

### Option 1 : GitHub Actions (CI/CD Automatique) ✅

Le workflow GitHub Actions est déjà configuré dans `.github/workflows/build-java.yml`.

**Fonctionnalités :**
- ✅ Build automatique à chaque push sur la branche `java`
- ✅ Création de JAR exécutable
- ✅ Upload des artifacts
- ✅ Création de release automatique avec tags

**Utilisation :**
1. Le workflow s'exécute automatiquement à chaque push
2. Pour créer une release, créez un tag :
   ```bash
   git tag v1.0.0
   git push origin v1.0.0
   ```

### Option 2 : Build Local et Upload Manuel

#### Étape 1 : Build le JAR

```bash
cd BrasilBurger_Java
mvn clean package
```

Le JAR sera créé dans : `target/BrasilBurger_Java-1.0-SNAPSHOT.jar`

#### Étape 2 : Tester le JAR

```bash
java -jar target/BrasilBurger_Java-1.0-SNAPSHOT.jar
```

#### Étape 3 : Créer une Release GitHub

1. Allez sur GitHub → Releases → Draft a new release
2. Créez un tag (ex: `v1.0.0`)
3. Uploadez le JAR dans les assets
4. Publiez la release

### Option 3 : Render.com (Pour Application Web - Future)

Si vous voulez transformer l'application en service web (Spring Boot), vous pouvez déployer sur Render.

**Configuration Render :**
- **Build Command** : `cd BrasilBurger_Java && mvn clean package`
- **Start Command** : `java -jar target/BrasilBurger_Java-1.0-SNAPSHOT.jar`
- **Environment Variables** :
  - `DB_HOST`
  - `DB_NAME`
  - `DB_USER`
  - `DB_PASSWORD`

## 📦 Créer un JAR Exécutable avec Dépendances

Pour créer un JAR "fat jar" avec toutes les dépendances :

### Maven Shade Plugin

Ajoutez dans `pom.xml` :

```xml
<build>
    <plugins>
        <plugin>
            <groupId>org.apache.maven.plugins</groupId>
            <artifactId>maven-shade-plugin</artifactId>
            <version>3.4.1</version>
            <executions>
                <execution>
                    <phase>package</phase>
                    <goals>
                        <goal>shade</goal>
                    </goals>
                    <configuration>
                        <transformers>
                            <transformer implementation="org.apache.maven.plugins.shade.resource.ManifestResourceTransformer">
                                <mainClass>com.brasilburger.App</mainClass>
                            </transformer>
                        </transformers>
                    </configuration>
                </execution>
            </executions>
        </plugin>
    </plugins>
</build>
```

Puis :
```bash
mvn clean package
java -jar target/BrasilBurger_Java-1.0-SNAPSHOT.jar
```

## 🔧 Configuration pour Déploiement

### Variables d'Environnement

Pour le déploiement, utilisez les variables d'environnement au lieu de `database.properties` :

```bash
export DB_HOST="ep-withered-surf-a4zfsqbd-pooler.us-east-1.aws.neon.tech"
export DB_NAME="neondb"
export DB_USER="neondb_owner"
export DB_PASSWORD="npg_Q28lkcThzxRG"
```

### Fichier de Configuration

Le fichier `database.properties` sera utilisé en local, mais les variables d'environnement ont la priorité.

## ✅ Checklist de Déploiement

- [ ] Code poussé sur GitHub (branche `java`)
- [ ] Workflow GitHub Actions configuré
- [ ] Build réussi (vérifier dans Actions)
- [ ] JAR créé et testé localement
- [ ] Variables d'environnement configurées (si déploiement cloud)
- [ ] Release créée sur GitHub (optionnel)
- [ ] Documentation mise à jour

## 📝 Notes

- L'application Java est une **application console**, pas une application web
- Pour un déploiement web, il faudrait convertir en Spring Boot
- Le JAR peut être exécuté sur n'importe quelle machine avec Java 17+
- Les identifiants de base de données doivent être configurés via variables d'environnement en production

## 🔗 Liens Utiles

- **GitHub Actions** : Voir dans l'onglet "Actions" du repository
- **Releases** : https://github.com/joyjoy42/brasil-burger-management/releases
- **Render.com** : https://render.com

