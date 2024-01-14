pipeline {
    agent {
           label 'agent-deployment'
    }
    stages{
        stage("checkout"){
            steps{
                checkout scm
            }
        }

        stage("Test"){
            steps{
                sh 'sudo apt-get update && apt-get install -y libmcrypt-dev zip unzip git libonig-dev librabbitmq-dev libssh-dev -y'
                sh 'php artisan queue:work'
            }
        }

        stage("Build"){
            steps{
                sh 'php artisan migrate:fresh'
            }
        }

        stage("Build Image"){
            steps{
                sh 'sudo docker build -t anjasmara_service_general:latest .'
            }
        }
        stage('Docker Push') {
            steps {
                withCredentials([usernamePassword(credentialsId: 'docker_cred', passwordVariable: 'DOCKERHUB_PASSWORD', usernameVariable: 'DOCKERHUB_USERNAME')]) {
                    sh 'sudo docker login -u $DOCKERHUB_USERNAME -p $DOCKERHUB_PASSWORD'
                    sh 'sudo docker tag anjasmara_service_general:latest mulki12/anjasmara_service_general:latest'
                    sh 'sudo docker push mulki12/anjasmara_service_general:latest'
                    sh 'sudo docker logout'
                }
            }
        }

      stage('Docker RUN') {
          steps {
      	     sh 'sudo docker run -d -p 3000 --name anjasmara_service_general  mulki12/anjasmara_service_general:latest:latest'
      }
    }
}    
}
    