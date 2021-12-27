pipeline {
    agent any
    environment {
        NEW_VERSION = '1.2.2'
        SERVER_CREDENTIALS = credentials('server-credentials')
    }
    stages {
        stage("build") {
            steps {
                echo 'building the application...'
                echo "build version ${NEW_VERSION}"
            }
        }
              
        stage("test") {
            steps {
                echo 'testing the application...'
            }
        }
        
        stage("deploy") {
            steps {
                echo 'deploying the application...'
                echo "build version ${NEW_VERSION}"
                echo "deploying with ${SERVER_CREDETIALS}"
                sh "${SERVER_CREDENTIALS}"
            }
        }
    }
}
