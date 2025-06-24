pipeline {
    agent any

    environment {
        EMAIL_RECIPIENTS = 'srengty@gmail.com'
    }

    triggers {
        // Poll Git every 5 minutes
        pollSCM('H/5 * * * *')
    }

    stages {
        stage('Checkout Code') {
            steps {
                checkout scm
            }
        }

        stage('Install Composer Dependencies') {
            steps {
                sh 'composer install --no-interaction --prefer-dist'
            }
        }

        stage('Install Node Modules') {
            steps {
                sh 'npm install'
            }
        }

        stage('Run Laravel Tests') {
            steps {
                sh './vendor/bin/phpunit'
            }
        }

        stage('Deploy with Ansible') {
            steps {
                // Runs Ansible playbook if all previous steps succeeded
                sh 'ansible-playbook ansible/playbook.yml'
            }
        }
    }

    post {
        failure {
            script {
                def committer = sh(
                    script: "git log -1 --pretty=format:'%ae'",
                    returnStdout: true
                ).trim()

                emailext(
                    subject: "❌ Build Failed: ${env.JOB_NAME} #${env.BUILD_NUMBER}",
                    body: """
                        The build for ${env.JOB_NAME} #${env.BUILD_NUMBER} has failed.

                        Check the logs: ${env.BUILD_URL}

                        Please fix it ASAP!
                    """,
                    to: "${committer}, ${env.EMAIL_RECIPIENTS}"
                )
            }
        }
    }
}
