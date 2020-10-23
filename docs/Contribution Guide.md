# Contribution Guide

Comment contribuer au projet :

1. Réaliser un fork du répertoire Github du projet
2. Cloner localement de votre fork
```
https://github.com/lechatgraphique/todo-and-co.git
```
3. Installer le projet et ses dépendances [voir instructions](../README.md)
4. Créer une branche
```
git checkout -b nouvelle-branch
```
5. Push la branch sur votre fork
```
git push origin nouvelle-branch
```
6. Ouvrir une pull request sur le répertoire Github du projet
7. Attendre la validation de la pull request

# Processus de qualité

Lancer les tests avec génération d'un rapport de code coverage :
```
php bin/phpunit --coverage-html docs/code-coverage
```
Pour implémenter de nouveaux tests, se référer à la [documentation officielle de Symfony](https://symfony.com/doc/4.2/testing.html)