pipeline {
    agent any

    environment {
        EMAIL_RECIPIENT = "rompher2609@gmail.com"
    }

    options {
        // Keep only last 10 builds
        buildDiscarder(logRotator(numToKeepStr: '10'))
    }

    triggers {
        // Poll Git repo every 5 minutes
        pollSCM('H/5 * * * *')
    }

    stages {
        stage('Checkout') {
            steps {
                checkout scm
            }
        }

        stage('Prepare Laravel Environment') {
            steps {
                sh '''
                    cp .env.example .env || true
                    php artisan key:generate || true
                '''
            }
        }

        stage('Build & Test') {
            steps {
                sh '''
                    cd ansible
                    ansible-playbook -i inventory.ini playbook.yml --list-tasks
                    ansible-playbook -i inventory.ini playbook.yml
                    cd ..
                '''
            }
        }

        // Uncomment this block if you separate build/test and deployment
        // stage('Deploy') {
        //     when {
        //         expression { currentBuild.currentResult == 'SUCCESS' }
        //     }
        //     steps {
        //         sh 'ansible-playbook -i ansible/inventory.ini ansible/playbook.yml'
        //     }
        // }
    }

    post {
        failure {
            script {
                def committer = sh(script: "git log -1 --pretty=format:'%ae'", returnStdout: true).trim()
                emailext(
                    subject: "❌ Build failed: ${env.JOB_NAME} #${env.BUILD_NUMBER}",
                    body: """❌ Jenkins build failed.

Project: ${env.JOB_NAME}
Build Number: ${env.BUILD_NUMBER}
Build URL: ${env.BUILD_URL}

Committer: ${committer}
""",
                    to: "${EMAIL_RECIPIENT}, ${committer}",
                    from: "jenkins@example.com"
                )
            }
        }
    }
}
