Système de chat privé, sans bundle, dans librairie, sous Symfony 5, PHP et Vanilla Javascript.

Un administrateur et des utilisateurs.
Seul l'administrateur peut débuter une  discussion, en choisissant le destinataire dans le menu déroulant (utilisateurs inscrits.)
Les utilisateurs ne peuvent pas discuter entre eux. Le chat se déroule donc entre l'utilisateur et l'administrateur (si ce dernier a débuté la conversation).

Un message contient un destinataire, un auteur, une date, un contenu et fait partie d'une conversation. Un utilisateur ne peut avoir qu'une conversation. Sauf l'administrateur. Ainsi, lorsque le user se connecte, on charge sa conversation. Lorsque l'administrateur choisit avec qui discuter, on charge la conversation de cet utilisataur.

Modifier le .env pour configurer et créer la base de données.
Lancer la migration.
Charger les fixtures pour avoir un administrateur et des utilisateurs fictifs. Mot de passe par défaut = 'password'