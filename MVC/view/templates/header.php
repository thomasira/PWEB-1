
<!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="Thomas Aucoin-Lo">
        <meta name="description" content="Des timbres en enchères de toutes les sortes.">
        <link rel="stylesheet" href="{{ path }}assets/style/main.css">
        <script type="module" src="./assets/script/main.js"></script>
    
        <!-- BOOTSTRAP POUR CAROUSSEL -->

        <script src="./assets/script/bootstrap.bundle.min.js" defer></script>
        <link href="./assets/style/carousel/bootstrap.min.css" rel="stylesheet">
        <link href="./assets/style/carousel/carousel.css" rel="stylesheet">
        <title>STAMPEE | {{ title }}</title>
    </head>
    <body>
    <header>
        <h1>PWEB-Stampee</h1>
        <p>OOP | MVC</p>
    </header>
        <!-- nav main -->
        <nav class="navigation-main">
        <div>
            <div>
                <a href="{{ path }}home">stampee</a>
                <a href="catalogue.html">Enchères</a>
                <a href="#">Timbres</a>
            </div>
            <div>
                <form class="recherche">
                    <label>
                        <img src="{{ path }}assets/icons/magnifier.svg" alt="loupe recherche" title="rechercher" loading="lazy">
                        <input type="text" name="recherche">
                        <span title="plus d'option">+</span>
                    </label>
                </form>
                <a href="{{ path }}membre/profil"><img src="{{ path }}assets/icons/profile.svg" alt="profile-icon" title="profil" loading="lazy"></a>
            </div>
        </div>
    </nav>

    <!-- nav sec -->
    <nav class="navigation-sec">
        <div>
            <div>
                <a href="#">Lord Stampee</a>
                <div>
                    <a href="#">Bio</a>
                    <a href="#">Historique</a>
                </div>
            </div>
            <div>
                <a href="#">Actualités</a>
                <div>
                    <a href="#">Philatélie</a>
                    <a href="#">Tendance</a>
                    <a href="#">Timbres</a>
                </div>
            </div>
            <div>
                <a href="#">Aide</a>
                <div>
                    <a href="#">Encan</a>
                    <a href="#">Profil</a>
                    <a href="#">FAQ</a>
                </div>
            </div>
            <div>
                <a href="#">Contact</a>
                <div>
                    <a href="#">Angleterre</a>
                    <a href="#">Canada</a>
                    <a href="#">USA</a>
                    <a href="#">Australie</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- nav icon -->
    <aside class="navigation-icon">
        <button><img src="{{ path }}assets/shapes/nav-icon/magnifier.svg" alt="recherche" loading="lazy"></button>
        <button><img src="{{ path }}assets/shapes/nav-icon/burger.svg" alt="menu" loading="lazy"></button>
        <button><img src="{{ path }}assets/shapes/nav-icon/profileS.svg" alt="profil" loading="lazy"></button>
    </aside>

