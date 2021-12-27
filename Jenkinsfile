pipeline {
    agent any
    parameters {
        string(name: 'VERSION', defaultValue: '', description: 'version to deploy on prod')
        choice(name: 'VERSION', choices: ['1.1.1', '1.1.2', '1.1.3'], description:'')
        booleanParam(name: 'executeTests', defaultValur: true, description:'')
    }
    
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
            when {
                expression {
                    params.executeTests
                }
            }
            steps {
                echo 'testing the application...'
            }
        }
        
        stage("deploy") {
            steps {
                echo 'deploying the application...'
                echo "build version ${NEW_VERSION}"
                echo "deploying with ${SERVER_CREDENTIALS}"
                sh "${SERVER_CREDENTIALS}"
                echo "deploying version ${params.VERSION}"
            }
        }
    }
}
