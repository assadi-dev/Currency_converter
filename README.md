### Projet 3 Currency converter API


Dans le cadre de la formation , j'avais pour objectif de developpée une application de conversion de money

#### Installation

se placer dans le dossier backend et renseigner les info de connection vers la base de donées 
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE="NOM DE LA BDD"
DB_USERNAME=root
DB_PASSWORD=
```
ensuite lancer dans le terminal placer vous dans le dossier backend et lancer la commande 
```composer install ```

puis 
```
php artisan serve
 ```

insertion des donnée test toujours dans le dossier lancer la commande suivant

```
php artisan migrate:fresh --seed

```


pour la partie Frontend

creer le fichier .env sur ce dossier puis rennseigner les infos suivantes

```
VITE_SERVER_API_URL="http://localhost:8000/api"
VITE_BASE_URL="/"
VITE_APP_NAME="MoneyValue"
```

placer vous dans le dossier frontend qui se trouve à la racine du projet

Ouvrer le terminal et placer vous sur le dossier frontend

lancer la commande suivante

``` npm install ```

puis

```
npm run dev
 ```

connexion vers la page admin

Route vers la page admin

http://localhost:8000/admin

**email:** admin@currency.com

**Mot de passe:** password 


