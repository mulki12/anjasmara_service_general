def AWS_ACCOUNT_ID="221047265242"
def AWS_DEFAULT_REGION="ap-southeast-1"
def APP_NAME="anjasmara_service_general"
def NAMESPACE="health-check"
def NAME_APP="test-laravel"
def IMAGE_TAG=""
def CODE_REPO="https://github.com/mulki12/anjasmara_service_general.git"
def CREDENTIAL_CODE_REPO="github-mulki"
def CONFIG_REPO="https://github.com/mulki12/anjasmara_service_general_config.git"
def CREDENTIAL_CONFIG_REPO="github-mulki"
def KUBECONFIG="config"
def REPOSITORY_URI = "${AWS_ACCOUNT_ID}.dkr.ecr.${AWS_DEFAULT_REGION}.amazonaws.com/test-laravel"

pipeline {

  agent any

  stages {

        stage('clone') {
            steps {
                container('jnlp') {
                    checkout([
                    $class: 'GitSCM',
                    branches: [[name: params.BRANCH]],
                    extensions: [[
                        $class: 'RelativeTargetDirectory',
                        relativeTargetDir: 'code']],
                    userRemoteConfigs: [[
                        url: "${CODE_REPO}",
                        credentialsId: "${CREDENTIALS_CODE_REPO}",
                    ]]
                ])

                    checkout([
                    $class: 'GitSCM',
                    branches: [[name: 'refs/heads/master']],
                    extensions: [[
                        $class: 'RelativeTargetDirectory',
                        relativeTargetDir: 'config']],
                    userRemoteConfigs: [[
                        url: "${CONFIG_REPO}",
                        credentialsId: "${CREDENTIALS_CONFIG_REPO}",
                    ]]
                ])
                }
            }
        }

    stage("build image") {
      environment {
        REPOSITORY_URI = "${AWS_ACCOUNT_ID}.dkr.ecr.${AWS_DEFAULT_REGION}.amazonaws.com/test-laravel"
      }
      steps {
        container("jnlp") {
            dir('code') {
               script {

                    sh 'git rev-parse --short HEAD > .git/commit-id'

                    def commit_id = readFile('.git/commit-id').trim()
                    IMAGE_TAG = commit_id.substring(0,7)


                    sh "ls -lah"
                    sh "pwd"

                    sh "ssh docker build -t ${NAME_APP}:${IMAGE_TAG} ."

                    sh "ssh docker push ${REPOSITORY_URI}:${IMAGE_TAG}"
                    sh "ls -lah"
               }
            }
        }
      }
    }

    stage('deploy helm') {
        steps{
          container('helm'){
            script {
              withKubeConfig([credentialsId: 'config', serverUrl: '']) {
                dir ('config') {
                  echo "Deploy to cluster ${KUBECONFIG}"
                  sh 'sudo mkdir -p /usr/local/bin/'
                  writeFile: '/usr/local/bin/kubectl', text:readFile(KUBECONFIG)
                  sh """
            helm upgrade ${REPO_CODE_NAME} ./helm/${REPO_CODE_NAME} \
            --set-string image.repository=${REPOSITORY_URI},image.tag=${BUILD_ID} \
            -f ./helm/values.dev.yml --debug --install --namespace ${NAMESPACE}
            """
                }
            }

          }
          
          
        }
    }
    }
    // stage('Deploying App to Kubernetes') {
    //   steps {
    //     withKubeConfig([credentialsId: 'config', serverUrl: '']) {
    //       //sh 'cat deploymentservice.yml | sed "s/{{BUILD_NUMBER}}/$BUILD_NUMBER/g" | kubectl apply -f -'
    //       sh 'sudo chmod u+x /usr/local/bin/kubectl'
    //       sh 'kubectl apply -f deploymentservice.yml'
    //     }
    //   }
    // }
    // Uploading Docker images into AWS ECR
    stage('Pushing to ECR') {
        steps{  
          script {
            sh 'aws ecr get-login-password --region ap-southeast-1 | docker login --username AWS --password-stdin 221047265242.dkr.ecr.ap-southeast-1.amazonaws.com' 
            sh 'docker tag $JOB_NAME:$BUILD_ID ${REPOSITORY_URI}:$BUILD_ID'
            sh 'docker push ${REPOSITORY_URI}:$BUILD_ID'
            sh 'docker rmi $JOB_NAME:$BUILD_ID ${REPOSITORY_URI}:$BUILD_ID' // Delete docker images from server 
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




  }

}


