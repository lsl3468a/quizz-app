<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz App</title>
    <link rel="stylesheet" href="./public/style/style.css">
    <link rel="icon" href="./public/images/wib.png" />
  
</head>
<body>

    <div class="container">
        <!-- Écran d'accueil -->
        <div id="welcome-screen" class="content">
            <h1>Bienvenue au jeu de piste spécial Octobre Rose !</h1>
            <p>Le principe est simple : une énigme vous guidera vers un lieu précis au sein de l’université. Une fois sur place, trouvez le mot clé à entrer dans le questionnaire.</p>
            <p>Bonne chance et soyez attentif à chaque détail !</p>
            <button class="styled-button" onclick="startQuiz()"> 
                <span class="button-text">C'est parti !</span>
                <img src="./public/images/icone.png" alt="Icône" class="button-icon">
            </button>
        </div>

        <!-- Écran d'énigme -->
        <div id="quiz-screen" class="hidden" >
            <h1 id="enigmeid" >Énigme 1/5</h1>
            <p id="question">16.224196, -61.528309</p>
            <input type="text" id="reponse" placeholder="Votre réponse" >
            <button class="styled-button" onclick="validerReponse()" >
                <span class="button-text" >Valider</span>
                <img src="./public/images/icone.png" alt="Icône" class="button-icon" >
            </button>
            <p id="message"></p>
        </div>

        <!--Question bonus-->
        <div id="bonus" class="hidden" >
            <h1 id="bonusid" >Question bonus :</h1>
            <p id="question">En quelle année l'intelligence artificielle a-t-elle été utilisée pour la première fois dans le dépistage du cancer du sein ?</p>
            <button type="button" class="bonus-option" data-answer="1953">1953</button>
            <button type="button" class="bonus-option" data-answer="1998">1998</button>
            <button type="button" class="bonus-option" data-answer="2003">2003</button>
            <button type="button" class="bonus-option" data-answer="2023">2023</button>
            <input type="hidden" id="bonus" name="bonus" value="false">
            <p id="message"></p>
        </div>

        <!-- Écran final -->
        <div id="final-screen" class="hidden">
            <h1>Félicitations !</h1>
            <p>Remplissez vos coordonnées pour participer au tirage au sort.</p>
            <input type="text" id="firstName" placeholder="Prénom" maxlength="20">
            <input type="text" id="lastName" placeholder="Nom" maxlength="25">
            <input type="text" id="ufr" placeholder="UFR" maxlength="20">
            <button class="styled-button" onclick="submitCoordonnees()">
                <span class="button-text">Je participe</span>
                <img src="./public/images/icone.png" alt="Icône" class="button-icon">
            </button>
            <p id="final-message"></p>
        </div>
        <div id="end" class="hidden">
            <h1>Merci d'avoir participé !</h1>
            <p>Ta participation a bien été enregistrée ! N'hésite pas à nous suivre sur instagram : @wi_bash.</p>
            <p> A très bientôt !</p>
        </div>
        <img src="./public/images/logo.png" alt="Logo-wibash" class="fixed-bottom-image">
        <div class="background-animation">
            <div class="word">Dépistage</div>
            <div class="word">Femmes</div>
            <div class="word">Solidarité</div>
            <div class="word">Cancer</div>
            <div class="word">Sein</div>
            <div class="word">Dépistage</div>
            <div class="word">Ruban</div>
            <div class="word">Femmes</div>
            <div class="word">Unité</div>
            <div class="word">Cancer</div>
            <div class="word">Sein</div>
            <div class="word">Femmes</div>
            <div class="word">Mammographie</div>
            <div class="word">Solidarité</div>
            <div class="word">Prévention</div>
            <div class="word">Sein</div>
            <div class="word">Femmes</div>
            <div class="word">Mammographie</div>
            <div class="word">Solidarité</div>
            <div class="word">Amour</div>
            <div class="word">Amour</div>
            <div class="word">Fanm</div>
            <div class="word">Prévention</div>
            <div class="word">Partage</div>
            <div class="word">Unité</div>
            <div class="word">Cancer</div>
            <div class="word">Sein</div>
            <div class="word">Femmes</div>
            <div class="word">Mammographie</div>
            <div class="word">Solidarité</div>
            <div class="word">Prévention</div>
            <div class="word">Sein</div>
            <div class="word">Femmes</div>
            <div class="word">Mammographie</div>
            <div class="word">Solidarité</div>
            <div class="word">Amour</div>
            <div class="word">Amour</div>
            <div class="word">Fanm</div>
            <div class="word">Prévention</div>
            <div class="word">Partage</div>
        </div>
        
    </div>

    <script>
        let currentEnigme = 1;

        const frameWidth = 100; // 100% de la largeur
        const frameHeight = 100; // 100% de la hauteur

        document.querySelectorAll('.word').forEach(word => {
            const randomSize = Math.random() * 20 + 20;
            const randomX = Math.random() * (frameWidth - (randomSize / window.innerWidth * 100));
            const randomY = Math.random() * (frameHeight - (randomSize / window.innerHeight * 100));

            word.style.fontSize = `${randomSize}px`;
            word.style.left = `${randomX}vw`;
            word.style.top = `${randomY}vh`;
            word.style.animationDelay = `${Math.random() * 5}s`;
        });

        // Suppression de cette ligne : const correctAnswer = "1998";

        document.querySelectorAll('.bonus-option').forEach(button => {
            button.addEventListener('click', function() {
                // Réinitialiser la couleur des boutons
                document.querySelectorAll('.bonus-option').forEach(btn => {
                    btn.style.backgroundColor = '';
                });

                const userAnswer = this.getAttribute('data-answer');

                // Faire une requête au serveur pour vérifier la réponse
                fetch('check_bonus.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ answer: userAnswer })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.correct) {
                        this.style.backgroundColor = 'green'; // Correct -> vert
                        this.style.color = 'white';
                        document.getElementById('bonus').value = 'true'; // Le bonus est correct
                    } else {
                        this.style.backgroundColor = 'red'; // Incorrect -> rouge
                        this.style.color = 'white';
                        document.querySelector(`button[data-answer="${data.correctAnswer}"]`).style.backgroundColor = 'green'; // Afficher la bonne réponse en vert
                        document.querySelector(`button[data-answer="${data.correctAnswer}"]`).style.color = 'white';
                        document.getElementById('bonus').value = 'false'; // Le bonus est incorrect
                    }

                    // Attendre 5 secondes avant de cacher la question bonus et afficher l'écran final
                    setTimeout(() => {
                        document.getElementById('bonus').classList.add('hidden'); // Cache la question bonus
                        document.getElementById('final-screen').classList.remove('hidden'); // Affiche l'écran final
                    }, 2500);
                });
            });
        });


        function startQuiz() {
            document.getElementById('welcome-screen').classList.add('hidden');
            document.getElementById('quiz-screen').classList.remove('hidden');
            loadEnigme(currentEnigme);
        }

        function loadEnigme(id) {
            fetch(`enigme.php?id=${id}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('enigmeid').innerText = `${data.enigmeid}`;
                    document.getElementById('question').innerText = `${data.question}`;
                    document.getElementById('reponse').value = '';
                    document.getElementById('message').innerText = '';
                });
        }

        function validerReponse() {
            const reponse = document.getElementById('reponse').value;
            fetch(`enigme.php?id=${currentEnigme}`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ reponse })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (currentEnigme === 5) {
                        document.getElementById('quiz-screen').classList.add('hidden');
                        document.getElementById('bonus').classList.remove('hidden');
                    } else {
                        currentEnigme++;
                        loadEnigme(currentEnigme);
                    }
                } else {
                    document.getElementById('message').innerText = 'Réponse incorrecte, essayez encore.';
                }
            });
        }

        function submitCoordonnees() {
            const firstName = document.getElementById('firstName').value;
            const lastName = document.getElementById('lastName').value;
            const ufr = document.getElementById('ufr').value;
            const bonus = document.getElementById('bonus').value === 'true' ? true : false;

            // Réinitialise le message avant chaque nouvelle requête
            document.getElementById('final-message').innerText = '';

            // Vérifie que les champs ne sont pas vides
            if (!firstName || !lastName || !ufr) {
                document.getElementById('final-message').innerText = 'Tous les champs sont requis.';
                return; // Arrête l'exécution de la fonction si des champs sont vides
            }

            const data = new URLSearchParams();
            data.append('firstName', firstName);
            data.append('lastName', lastName);
            data.append('ufr', ufr);
            data.append('bonus', bonus ? 'true' : 'false');
            
            fetch('submit.php', {
                method: 'POST',
                body: data // Pas besoin de définir Content-Type car fetch le fera automatiquement
            })
            .then(response => {
                // Gérer les erreurs 400 et 500
                if (response.status === 400) {
                    return response.json().then(data => {
                        document.getElementById('final-message').innerText = "Vous avez déjà participé !";
                      	throw new Error(data.message || 'Vous avez déjà participé !');
                    });
                } else if (response.status === 500) {
                    throw new Error('Erreur serveur, veuillez réessayer plus tard.');
                }
                return response.json(); // Traite la réponse en cas de succès
            })
            .then(data => {
                // Si la requête est un succès (status 201)
                document.getElementById('final-screen').classList.add('hidden');
                document.getElementById('end').classList.remove('hidden');
            })
            .catch(error => {
                // Gère les erreurs et affiche le message
                document.getElementById('final-message').innerText = error.message;
            });

        }

    </script>
</body>
</html>
