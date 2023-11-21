pipeline {

  options {
    ansiColor('xterm')
  }

  agent {
    kubernetes {
      yamlFile 'builder.yaml'
    }
  }

  stages {

    stage('anjasmara_service_general Build & Push Image') {
      steps {
        container('anjasmara_service_general') {
          script {
            sh '''
            /anjasmara_service_general/executor --dockerfile `pwd`/Dockerfile \
                             --context `pwd` \
                             --destination=mulki12/anjasmara_service_general:${BUILD_NUMBER}
            '''
          }
        }
      }
    }

    stage('Deploy App to Kubernetes') {     
      steps {
        container('kubectl') {
          withCredentials([file(credentialsId: 'mykubeconfig', variable: 'KUBECONFIG')]) {
            sh 'sed -i "s/<TAG>/${BUILD_NUMBER}/" myweb.yaml'
            sh 'kubectl apply -f myweb.yaml'
          }
        }
      }
    }
  
  }
}
