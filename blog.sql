-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : ven. 09 déc. 2022 à 19:28
-- Version du serveur : 5.7.36
-- Version de PHP : 8.1.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `blog`
--

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `name_author` varchar(255) NOT NULL,
  `email_author` varchar(255) NOT NULL,
  `comment` longtext NOT NULL,
  `status_comm` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1=unpublished, 2=published',
  `date_comment` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `comments`
--

INSERT INTO `comments` (`id`, `post_id`, `name_author`, `email_author`, `comment`, `status_comm`, `date_comment`) VALUES
(67, 34, 'Sébastien', 'seb681@orange.com', 'Article très intéressant, cette API donne vraiment beaucoup de possibilités. Pourriez vous indiquer la solution pour créer un post ?', 2, '2022-07-19'),
(68, 34, 'Moby', 'mob452@yahoo.fr', 'Merci pour toutes ses informations sur l’API.', 1, '2022-07-19'),
(69, 34, 'Rajahona', 'rajpon298@hotmail.fr', 'Bonjour,\r\nMerci pour le tuto.\r\nJ’ai une question: est-il possible de faire un get d’un article de WordPress avec toute sa mise en forme(css) , afin de l’intégrer dans une autre appli. Actuellement, le get renvoie du json.\r\n\r\n \r\n\r\nMerci', 2, '2022-07-19'),
(71, 36, 'Tim Mousk', 'tmousk585@gmail.com', 'Thank you for this very insightful article.', 2, '2022-12-03'),
(73, 38, 'Gauthier', 'manugaut@yahoo.fr', 'Thanks for the tip about the prefix, this is an interesting shortcut!\r\nIn most cases the --force-with-lease option seems safer in case there are some additional commits as well: https://git-scm.com/docs/git-push#Documentation/git-push.txt—no-force-with-lease', 2, '2022-12-03');

-- --------------------------------------------------------

--
-- Structure de la table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `headline` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `image` varchar(255) NOT NULL,
  `status_post` tinyint(4) NOT NULL DEFAULT '1',
  `date_create` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `tag_id`, `title`, `headline`, `content`, `image`, `status_post`, `date_create`) VALUES
(34, 4, 3, 'Utilisation de l\'API REST, la nouvelle API de Wordpress 6', 'Qu\'est ce qu\'une API ?', 'Pour commencer, il faut comprendre qu’une API est simplement un accès « distant » à un système. Dans le cas de WordPress, c’est un accès qui permet d’accéder à du contenu de la base de données et d’exécuter des fonctionnalités à distance. Une API (Applications Programming Interface) permet à des développeurs, de concevoir des scripts qui pourront s’authentifier sur WordPress pour y créer, modifier, supprimer ou récupérer des contenus dans le but d’automatiser des actions. L’API de WordPress n’est pas une nouveauté. En effet, comme nous l’avions écrit dans notre article consacré à l’href=\"https://blog.wixiweb.fr/wordpress-api-webservices-xmlrpc/\" API XML-RPC de WordPress, une API est activée par défaut depuis WordPress 3.5. La nouveauté est qu’il s’agit d’une nouvelle API de type REST, conçue avec les standards d’aujourd’hui et entièrement intégrée au cœur de WordPress sans avoir besoin d’installer un plugin. Ce qu’il faut également retenir c’est que cette nouvelle API a été repensée de zéro pour être compatible avec les nouveaux usages du web. Bien que l’API REST soit native, elle ne fonctionne pas directement après une nouvelle installation de WordPress 4.7. Pour l’activer, il suffit d’activer la réécriture d’URL. Rassurez-vous, il est fort probable que vous ayez déjà activé cette option.                                ', '', 2, '2022-12-08'),
(36, 4, 14, 'CSS : autofill', 'Hell, we all autofill for our passwords and address information.', ' Autofilling HTML input elements is a frequent user action that can drastically improve user experience. I\'m really happy that browsers allow site and app developers to customize the styling of elements that have been changed by the browser. Autofill, to a degree, is an unnatural act, so signaling to that the value in an input was changed without control is important. But what control do we have when input elements have been autofilled ? Since different browsers and operating systems sometimes style autofilled elements differently,  :autofill is hugely beneficial !                                                                ', 'pexels-realtoughcandycom.jpg', 2, '2022-12-08'),
(38, 260, 2, 'How to flatten git commits', 'Rebasing is a frequent task for anyone using git. ', 'One of my least favorite tasks as a software engineer is resolving merge conflicts. A simple rebase is a frequent occurrence but the rare massive conflict is inevitable when many engineers work in a single codebase. One thing that helps me deal with large rebases with many merge conflicts is flattening a branch\'s commits before fixing merge conflicts. Let\'s have a look at how to flatten those commits before resolving those conflicts !                                                          ', 'roman-synkevych.jpg', 2, '2022-12-08'),
(39, 274, 2, 'Git force push', 'To flatten commits before the rebase', 'Rebasing is a frequent task for anyone using git. We sometimes use rebasing to branch our code from the last changes or even just to drop commits from a branch. Oftentimes when trying to push after a rebase, you\'ll see something like the following: hint: Updates were rejected because the tip of your current branch is behind\nhint: its remote counterpart. Integrate the remote changes (e.g.\nhint: \'git pull ...\') before pushing again.\nhint: See the \'Note about fast-forwards\' in \'git push --help\' for details.Commonly developers will use the --force or -f flags during a push to force pushing code changes: git push origin my-branch --force\n# or\ngit push origin my-branch -f I was recently surprised to find out that you could also prefix the branch name with + to force a push: git push origin +my-branch The + syntax is interesting but doesn\'t seem intuitive so it\'s not a practice I\'d use, but that doesn\'t mean you shouldn\'t!                                                                                                                       ', 'praveen-thirumurugan.jpg', 2, '2022-12-08'),
(40, 255, 5, 'Create auth tokens with PHP', 'Short amount of code but took a long time to find !', 'L\'API Blogger Data permet aux applications clientes d\'afficher et de mettre à jour le contenu de Blogger sous la forme de flux d\'API Google Data.\n\nVotre application cliente peut utiliser l\'API Blogger Data pour créer des articles de blog, modifier ou supprimer des articles de blog existants et rechercher des articles de blog correspondant à des critères particuliers.\n\nEn plus de vous familiariser avec les fonctionnalités de l\'API Data de Blogger, ce document fournit des exemples d\'interactions avec l\'API Data de base à l\'aide de la bibliothèque cliente Zend Google Data APIs. Si vous souhaitez en savoir plus sur le protocole sous-jacent utilisé par la bibliothèque, consultez la section Protocole de ce guide du développeur.                                                                                                                         ', 'ben-griffiths.jpg', 2, '2022-12-08'),
(41, 277, 4, 'HTML5 video player best practices', 'Cloudinary provides a full upload to deliver API for videos', 'Let\'s all be honest:  when it comes to media and the early days of the internet, we definitely did it all wrong.  We started with embedded video players like RealPlayer and Windows Media Player which required custom codecs and browser plugins, then moved on to Flash and Quicktime -- all of which made our browsers slow and sometimes even at risk from a security perspective.  It took more than a decade to create a <video> tag and actually get browser support for it -- far too long of a wait, so much so that many sites still use Flash to serve their videos.', 'growtika-developer.jpg', 1, '2022-12-05');

-- --------------------------------------------------------

--
-- Structure de la table `tags`
--

CREATE TABLE `tags` (
  `id` int(11) NOT NULL,
  `tagname` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tags`
--

INSERT INTO `tags` (`id`, `tagname`, `description`) VALUES
(2, 'Git/Github', '<p>Git is a versioning software, or version management software is software that allows you to keep a history of changes made to a project so that you can quickly identify the changes made and return to an old version in the event of a problem.</p>'),
(3, 'Wordpress', '<p>WordPress is a CMS (Content Management System), i.e. a tool for publishing and managing content on the Internet. It therefore allows you to create and administer your website. It is free and Open Source (GPL license), which means that WordPress can be downloaded, installed, modified and redistributed by anyone who retains this license.</p>'),
(4, 'HTML5', '<p>HTML5, for HyperText Markup Language 5, is a version of the famous HTML format used to design websites. This boils down to a markup language that is used to write the hypertext essential to the formatting of a Web page.</p>'),
(5, 'PHP', '<p>PHP, for Hypertext Preprocessor, designates a computer language, or a scripting language, used mainly for the design of dynamic websites. It is a programming language under a free license which can therefore be used by anyone completely free of charge.</p>'),
(8, 'Javascript', '<p>JavaScript designates a computer development language, and more precisely an object-oriented scripting language. It is mainly found on Internet pages. It allows, among other things, to introduce small animations or effects on a web or HTML page.</p>'),
(14, 'CSS', '<p>CSS for Cascading Style Sheets, is a computer language used on the Internet for formatting HTML files and pages. It is translated into French by cascading style sheets.</p>');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1=admin, 2=superadmin',
  `date_signup` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `activation` tinyint(4) DEFAULT '0' COMMENT '0=inactif,1=actif',
  `token_confirm` varchar(255) DEFAULT NULL,
  `token_date` datetime DEFAULT NULL,
  `forget_token` varchar(255) DEFAULT NULL,
  `forget_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `name`, `picture`, `email`, `password`, `role`, `date_signup`, `activation`, `token_confirm`, `token_date`, `forget_token`, `forget_date`) VALUES
(4, 'bouboul3W?', 'Michel', 'avatar.png', 'mhathier@yahoo.com', '$2y$10$CcNq6FImBHT93pAiN31J6uNnIMLC/GbdEYc6wJmm2UIjgib5YHwUO', 2, '2022-12-05 20:32:23', 1, NULL, NULL, NULL, NULL),
(255, 'orangeK1!', 'Marie', 'pink.jpg', 'papa@hotmail.fr', '$2y$10$ADvZGiYseJd/PN1Ez9Jd4e.IiJN.iAJjjnoe8sl/73VGAZ2L7NwSW', 1, '2022-07-19 16:03:43', 1, NULL, NULL, NULL, NULL),
(260, 'biloute9g@K', 'Tania', 'beauty.jpg', 'tania@orange.fr', '$2y$10$Zjh7QtYFjLWixlCM/e420O.30.276BT.lRrP4/DzoEEppCCwf2vTS', 1, '2022-09-23 16:14:07', 1, NULL, NULL, NULL, NULL),
(274, 'minetG!w2', 'Adrien', 'glasses.jpg', 'minet@free.com', '$2y$10$l13QihXLd1iIz8KdFbcB6uazhxDvVIarPXkZHr5mW/3TfomLl2nJC', 1, '2022-11-25 20:50:52', 1, NULL, NULL, NULL, NULL),
(275, 'core8*NP', 'Barry', 'charlie.jpg', 'dudul@gmail.com', '$2y$10$MUWhDIgWQARcytqtY.587.kpYIyqBW3d6.2ivz/heehjHcf79LxFe', 1, '2022-12-05 21:22:12', 1, NULL, NULL, NULL, NULL),
(277, 'concombreB8!', 'Charles', 'yellow.jpg', 'mouss@free.fr', '$2y$10$O7l.K4Z8btGv5YhYq8YohuK.2XsIox6AhRmWQA/dIg4rMqZsn.S/e', 1, '2022-12-05 19:45:03', 1, NULL, NULL, NULL, NULL),
(280, 'bruno0W$*', 'Bruno', 'funny.jpg', 'grizzly@hotmail.fr', '$2y$10$JhMjgnJ//9c41sTsgKuamuhLgVQPgPJ.oYuIiRk/Z2E7Ypkq/pRxS', 1, '2022-12-04 19:27:31', 1, NULL, NULL, NULL, NULL),
(302, 'john45*AC', 'John', NULL, 'jojo@yahoo.fr', '$2y$10$htMfENl7vT0iizgSVbGLXu7IxVRBD1JLYPsoSrDsC8NlxuLPnguN6', 1, '2022-12-09 20:08:15', 1, NULL, NULL, NULL, NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_comment_posts` (`post_id`);

--
-- Index pour la table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tag_posts` (`tag_id`),
  ADD KEY `fk_user_posts` (`user_id`);

--
-- Index pour la table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT pour la table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT pour la table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=303;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `fk_comment_posts` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `fk_tag_posts` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_user_posts` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
