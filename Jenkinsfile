pipeline {
    agent any

    environment {
        APP_NAME = "laravel-app"
        SONAR_HOST_URL = "http://13.49.207.120:9000"
    }

    stages {

        stage('Checkout') {
            steps {
                git branch: 'main', url: 'https://github.com/haiider820/devops-demo-app.git'
            }
        }

        stage('Install Dependencies') {
            steps {
                sh 'composer install --no-interaction --prefer-dist'
            }
        }

        stage('Setup Laravel') {
            steps {
                sh '''
                cp -n .env.example .env || true
                php artisan key:generate || true
                php artisan migrate --force || true
                '''
            }
        }

        stage('Clear Cache') {
            steps {
                sh '''
                php artisan config:clear
                php artisan cache:clear
                '''
            }
        }

        stage('SonarQube Analysis') {
            steps {
                withCredentials([string(credentialsId: 'sonar-token', variable: 'SONAR_TOKEN')]) {
                    sh '''
                    docker run --rm \
                      -v $(pwd):/usr/src \
                      sonarsource/sonar-scanner-cli \
                      -Dsonar.projectKey=laravel-app \
                      -Dsonar.sources=/usr/src \
                      -Dsonar.host.url=$SONAR_HOST_URL \
                      -Dsonar.login=$SONAR_TOKEN
                    '''
                }
            }
        }

        stage('Deploy') {
            steps {
                sh '''
                echo "Deploying via Docker..."

                docker compose down || true
                docker compose up -d --build
                '''
            }
        }
    }

    post {
        success {
            echo "✅ Deployment Successful!"
        }

        failure {
            echo "❌ Deployment Failed!"
        }
    }
}
