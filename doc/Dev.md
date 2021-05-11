# Environnement de développement

L'environnement de développement est fourni par `Docker` et l'utilitaire `docker-compose`.

## Commandes utiles

### Manipuler les dépendances composer

```shell
# Installer les dépendances
bin/composer install

# Ajout d'une dépendance
bin/composer require foo/bar
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
# Si besoin de recréer le container php "duralas_helper_tools_php" :
# docker-compose build
bin/start
```
