# Environnement de développement

## Commandes utiles

### Manipuler les dépendances composer

> **ℹ** Le container `duralas_helper_tools_php` récupère `composer` le rendant accessible en ligne de commandes.

```shell
# Installation par docker
docker exec --interactive --tty \
  duralas_helper_tools_php \
  composer install

# Ajout d'une dépendance par docker
docker exec --interactive --tty \
  duralas_helper_tools_php \
  composer require foo/bar
```

### Installer les dépendances yarn

```shell
# Exemple par Docker
#sudo docker pull node
docker run --rm --interactive --tty \
  --volume $PWD:/app \
  --workdir /app \
  --user $(id -u):$(id -g) \
  node yarn install
```

### Mettre à jour les dépendances yarn

```shell
# Exemple par Docker
docker run --rm --interactive --tty \
  --volume $PWD:/app \
  --workdir /app \
  --user $(id -u):$(id -g) \
  node yarn encore dev
```

### Lancer le serveur web

```shell
# Exemple par docker-compose
#docker-compose build
docker-compose up -d
docker exec --interactive --tty \
  duralas_helper_tools_php \
  symfony serve 
```
