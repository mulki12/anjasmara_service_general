pipeline {

  agent any

  stages {

    stage('Checkout Source') {
      steps {
        git 'https://github.com/mulki12/anjasmara_service_general.git'
      }
    }

    stage('Build image') {
      steps{
        script{
          sh 'docker build . '
          sh 'docker image list'
         }
      }
    }

//    stage('Deploy our image') {
//      steps{
//        script {
//          docker.withRegistry( '', registryCredential ) {
//            dockerImage.push("latest")
//          }
//        }
//      }
//    }

    stage('Deploying App to Kubernetes') {
      steps {
        withKubeConfig([credentialsId: 'config', serverUrl: 'https://41C5B63274E00776BA12E1EF485D47DA.gr7.ap-southeast-1.eks.amazonaws.com']) {
          sh 'cat deploymentservice.yml | sed "s/{{BUILD_NUMBER}}/$BUILD_NUMBER/g" | kubectl apply -f -'
          sh 'kubectl apply -f deploymentservice.yml'
        }
      }
    }

  }

}


