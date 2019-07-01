# php-mvc-tutoriel
Un tutoriel sur l'architecture mvc en php.
# Installations
Télécharger la dernière version de wampserver ou de xampp. Moi, j'utilise xampp. Décommenter la ligne "LoadModule rewrite_module modules/mod_rewrite.so" se trouvant dans le fichier de configuration "httpd.conf"
Copier le dossier dans www (wampserver) ou htdocs (xampp)
# Explications

1. Ce projet comporte 2 dossiers à la racine : app et public
Le dossier app contient les fichiers de l'application. C'est lui qui comporte l'architecture mvc : models-views-controllers
Le dossier public contient les fichiers css et js.

2. Ce projet contient 3 fichiers .htaccess :
- Celui se trouvant à la racine indique que tous les liens doivent passer dans le dossier public
- Celui se trouvant dans public indique que tous les liens doivent passer par le fichier index.php
- Celui se trouvant dans le dossier bloque tous les liens passant directement par le dossier app

3. Le fichier config contenu dans le dossier config permet de créer des constantes pour minimiser l'accès aux fichiers
# Recommandations

Pour utiliser ce tutoriel, il faut avoir des connaissances en php surtout dans le programmation orientée object en php.
