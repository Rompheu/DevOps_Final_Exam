pipeline {
    agent any

    environment {
        EMAIL_RECIPIENT = "rompher2609@gmail.com"
        // You can add more env variables here
    }

    triggers {
        // Keep only last 10 builds to save space
        // buildDiscarder(logRotator(numToKeepStr: '10'))
        // Poll every 5 minutes
        pollSCM('H/5 * * * *')
    }

    stages {
        stage('Checkout') {
            steps {
                // Checkout from GitHub
                checkout scm
            }
        }

        stage('Build & Test') {
            steps {
                // Run your build commands (e.g. composer install, npm build, tests)
                sh '''
                   cd ansible
                   ansible-playbook -i inventory.ini playbook.yml --list-tasks
                   cd ..
                   cd ansible
                   ansible-playbook -i inventory.ini playbook.yml
                   cd ..
                '''
            }
        }

        // stage('Deploy') {
        //     when {
        //         expression { currentBuild.currentResult == 'SUCCESS' }
        //     }
        //     steps {
        //         // Run ansible playbook to deploy
        //         sh 'ansible-playbook -i ansible/inventory.ini ansible/playbook.yml'
        //     }
        // }
    }

    post {
        failure {
            script {
                def culpritEmail = currentBuild.rawBuild.getCause(hudson.model.Culprit).getEmail()
                emailext (
                    subject: "Build failed: ${env.JOB_NAME} #${env.BUILD_NUMBER}",
                    body: """Build failed.

Project: ${env.JOB_NAME}
Build Number: ${env.BUILD_NUMBER}
Check console output at ${env.BUILD_URL}

Culprit: ${culpritEmail ?: 'unknown'}
""",
                    to: "${EMAIL_RECIPIENT}, ${culpritEmail ?: ''}",
                    from: "jenkins@example.com"
                )
            }
        }
    }
}
