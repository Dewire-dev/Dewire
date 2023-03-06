# Installation

## Linux : Containers avec Docker et Sail

Prérequis :
- Linux ou [WSL 2 sous Windows](https://learn.microsoft.com/fr-fr/windows/wsl/) ([+ d'infos](#mise-en-place-de-wsl-2-sous-windows))
- Docker

1. Cloner le projet dans le dossier du système Linux

```console
$ git clone git@github.com:Dewire-dev/Dewire.git
$ cd Dewire
```

2. Ajouter un alias pour sail

```console
$ nano ~/.bash_aliases

Ajouter la ligne suivante :
alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'

$ source ~/.bashrc
```

1. Copier le fichier `.env.example` et le renommer `.env`

2. Installer les dépendances composer (dont sail)

```sh
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php82-composer:latest \
    composer install --ignore-platform-reqs
```

4. Lancer les containers en mode détaché

```console
$ sail up -d
```

5. Générer une clé unique pour sécuriser l'application

```console
$ sail artisan key:generate
```

6. Installer les dépendances npm puis compiler les assets

```console
$ sail npm i && sail npm run dev
```

7. Se rendre sur https://localhost

Commandes utiles :

- Arrêter et supprimer les containers : `sail down`

- Arrêter les containers : `sail stop`

- Partager le site : `sail share`

- Autres commandes sail : [Documentation](https://laravel.com/docs/10.x/sail)

### Mise en place de WSL 2 sous Windows

Prérequis :
- Version de build Windows > 19041+ (Windows + R > "winver")
- [Windows Terminal](https://apps.microsoft.com/store/detail/windows-terminal/9N0DX20HK701)
- [Docker Desktop](https://www.docker.com/products/docker-desktop/)

1. Ouvrir Windows Terminal en mode administrateur

2. Installer les dépendances nécessaires puis redémarrer le pc

```console
> wsl --install
```

3. Définir la version par défaut de WSL sur 2 et installer la distribution Ubuntu

```console
> wsl --set-default-version 2
> wsl --install -d ubuntu 
```

4. Vérifier qu'Ubuntu soit en version 2, sinon le mettre à jour

```console
> wsl -l -v

Si Ubuntu en version 1 :
> wsl --set-version ubuntu 2
```

5. Ouvrir Docker Desktop et activer le support de WSL 2 dans Settings > Resources > WSL Integration : cocher Ubuntu puis enregistrer

6. Ouvrir un terminal Ubuntu

```console
> wsl
```

7. Configuration SSH

```console
$ cp -r /mnt/c/Users/<username>/.ssh ~/.ssh
$ chmod 600 ~/.ssh/id_rsa

$ eval $(ssh-agent)
$ ssh-add ~/.ssh/id_rsa
```

8. Configuration Git

```console
$ git config --global user.name "<github_name>"
$ git config --global user.email "<github_email>"
$ git config --global credential.helper "/mnt/c/Program\ Files/Git/mingw64/libexec/git-core/git-credential-wincred.exe"
```

## Windows : Serveur web avec Laragon ou WAMP

Prérequis :
- Laragon ou WAMP
- PHP 8.1+
- Node 18+
- MySQL 8+

1. Cloner le projet dans le dossier `C:\laragon\www` (ou `C:\wamp\www`)

```console
> git clone git@github.com:Dewire-dev/Dewire.git
> cd Dewire
```

2. Installer les dépendances composer et npm puis compiler les assets

```console
> composer install
> npm install && npm run dev
```

3. Créer une base de données MySQL nommée `'dewire'`

4. Copier le fichier `.env.example` et le renommer `.env`

5. Générer une clé unique pour sécuriser l'application

```console
> php artisan key:generate
```

6. Lancer les migrations et ajouter les données de base

```console
> php artisan migrate --seed
```

7. Recharger le serveur Apache/Nginx et se rendre sur https://dewire.test

Commandes utiles :

- Créer les comptes admins pour accéder au back-office : `php artisan db:seed --class=AdminsSeeder`

- Relancer les migrations et rafraîchir les données : `php artisan migrate:fresh --seed`

- Lancer le serveur web via ligne de commande : `php artisan serve`

- Autres commandes artisan : [Documentation](https://laravel.com/docs/10.x/artisan)

## Mac : Boîte Vagrant avec Homestead ou Valet

> Prochainement...
