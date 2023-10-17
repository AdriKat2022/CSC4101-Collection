# Purger et restaurer une base de donnée (NE PAS A FAIRE SI EN PRODUCTION)

`symfony console doctrine:database:drop --force`
`symfony console doctrine:database:create`
`symfony console doctrine:schema:create`
`echo yes |symfony console doctrine:fixtures:load`

# Migrer la base de données pour la mettre à jour (si en production)

`symfony console make:entity`
`symfony console doctrine:migrations:migrate`