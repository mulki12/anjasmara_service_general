pipeline {

  agent any
  environment {
    AWS_ACCOUNT_ID="221047265242"
    AWS_DEFAULT_REGION="ap-southeast-1"
    //REPO_NAME="https://github.com/mulki12/anjasmara_service_general.git"
    REPOSITORY_URI = "${AWS_ACCOUNT_ID}.dkr.ecr.${AWS_DEFAULT_REGION}.amazonaws.com/test-laravel"
  }

  stages {

    stage('Checkout Source') {
      steps {
        //git 'https://github.com/mulki12/anjasmara_service_general.git'
         checkout([$class: 'GitSCM', branches: [[name: '*/master']], doGenerateSubmoduleConfigurations: false, extensions: [], submoduleCfg: [], userRemoteConfigs: [[credentialsId: '', url: 'https://github.com/mulki12/anjasmara_service_general.git']]])     
      }
    }

    stage('Build image') {
      steps{
        script{
          sh 'sudo docker login -u mulki12 -p 12Februari@'
          sh 'docker build . '
          sh 'docker image list'
         }
      }
    }
    // Uploading Docker images into AWS ECR
       stage('Pushing to ECR') {
         steps{  
           script {
             sh 'aws ecr get-login-password --region ap-southeast-1 | docker login --username AWS --password-stdin 221047265242.dkr.ecr.ap-southeast-1.amazonaws.com' 
             sh 'docker tag $JOB_NAME:v1.$BUILD_ID ${REPOSITORY_URI}:v1.$BUILD_ID'
             sh 'docker push ${registry}:v1.$BUILD_ID'
             sh 'docker rmi $JOB_NAME:v1.$BUILD_ID ${registry}:v1.$BUILD_ID' // Delete docker images from server 
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
        withKubeConfig([credentialsId: 'config', serverUrl: '41C5B63274E00776BA12E1EF485D47DA.gr7.ap-southeast-1.eks.amazonaws.com']) {
          sh 'cat deploymentservice.yml | sed "s/{{BUILD_NUMBER}}/$BUILD_NUMBER/g" | kubectl apply -f -'
          sh 'kubectl apply -f deploymentservice.yml'
        }
      }
    }

  }

}


