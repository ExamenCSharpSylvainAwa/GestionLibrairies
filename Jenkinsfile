pipeline {
    agent any

    environment {
        // Définir le nom de l'image Docker
        DOCKER_IMAGE = "laravel-app:${env.BUILD_NUMBER}"
        // Identifiants pour Docker Hub (à configurer dans Jenkins)
        DOCKER_CREDENTIALS_ID = 'dockerhub-credentials'
    }

    stages {
        // Étape 1 : Récupérer le code depuis GitHub
        stage('Checkout') {
            steps {
                git branch: 'main', url: 'https://github.com/ExamenCSharpSylvainAwa/GestionLibrairies.git'
            }
        }

        // Étape 2 : Construire l'image Docker
        stage('Build Docker Image') {
            steps {
                script {
                    // Construire l'image Docker
                    dockerImage = docker.build(DOCKER_IMAGE)
                }
            }
        }

        // Étape 3 (optionnelle) : Pousser l'image vers Docker Hub
        stage('Push Docker Image') {
            steps {
                script {
                    // Se connecter à Docker Hub et pousser l'image
                    docker.withRegistry('https://index.docker.io/v1/', DOCKER_CREDENTIALS_ID) {
                        dockerImage.push()
                    }
                }
            }
        }
    }

    post {
        always {
            // Nettoyer les images Docker locales pour éviter l'encombrement
            sh "docker rmi ${DOCKER_IMAGE} || true"
        }
        success {
            echo 'Pipeline terminée avec succès !'
        }
        failure {
            echo 'La pipeline a échoué.'
        }
    }
}
