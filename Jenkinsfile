pipeline {
    environment {
        BUILD_SCRIPT_GIT="http://github.com/mulki12/anjasmara_service_general.git"
        BUILD_SCRIPTS='mypipeline'
        BUILD_HOME='/var/jenkins_home'
    }
 agent any
 stages {
        stage('Checkout: Code') {
            steps {
                sh "mkdir -p $WORKSPACE/repo;\
                git config --global user.email 'miftahul.mulki95@gmail.com';\
                git config --global user.name 'mulki12';\
                git config --global push.default simple;\
                git clone $BUILD_SCRIPTS_GIT repo/$BUILD_SCRIPTS"
                sh "chmod -R +x $WORKSPACE/repo/$BUILD_SCRIPTS"
                }
            }
 stages {
        stage("Build") {
            steps {
                sh 'php --version'
                sh 'composer install'
                sh 'composer --version'
                sh 'cp .env.example .env'
                sh 'php artisan key:generate'
            }
        }
  post {
        always {
            cleanWs()
          }
  }
}
