# Environnement de développement

## Commandes utiles

### Installer les dépendances composer

```shell
# Exemple par docker
# sudo docker pull composer
docker run --rm --interactive --tty \
  --volume $PWD:/app \
  --user $(id -u):$(id -g) \
  composer install
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
