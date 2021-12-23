pipeline {
    agent any

    stages {
        stage("Build") {
            environment {
                DB_HOST = credentials("mariadb")
                DB_DATABASE = credentials("anjasmara_service_general")
                DB_USERNAME = credentials("root")
                DB_PASSWORD = credentials("anjas123")
            steps {
                sh 'php --version'
                sh 'composer install'
                sh 'composer --version'
                sh 'cp .env.example .env'
                sh 'echo DB_USERNAME=${DB_USERNAME} >> .env'
                sh 'echo DB_DATABASE=${DB_DATABASE} >> .env'
                sh 'echo DB_PASSWORD=${DB_PASSWORD} >> .env'
                sh 'php artisan key:generate'
                sh 'cp .env .env.testing'
                sh 'php artisan migrate:fresh'
            }
        }
        stage("Unit Test") {
            steps {
                sh 'php artisan test'
            }
        }
        stage("Docker build") {
            steps {
                sh "docker build -t anjasmara_service_generals ."
            }
        }
        stage("Docker push") {
            environment {
                DOCKER_USERNAME = credentials("mulki12")
                DOCKER_PASSWORD = credentials("7dfb3be7-2f9a-488b-8ad2-784c1bc9da18")
            }
            steps {
                sh "docker login --username ${DOCKER_USERNAME} --password ${DOCKER_PASSWORD}"
                sh "docker push anjasmara_service_generals:latest"
            }
        }
        stage("Deploy to staging") {
            steps {
                sh "docker run -d --rm -p 3001:3001 --name generals anjasmara_service_generals"
            }
        }
    }
}
}
