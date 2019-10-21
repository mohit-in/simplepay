pipeline {
    agent {
        dockerfile {
            dir 'docker/jenkins'
        }
    }
    stages {
        stage('build') {
            steps {
                withCredentials([string(credentialsId: 'simple_pay_ashish_token', variable: 'TOKEN')]) {
                    sh "curl -XPOST -H 'Authorization: token $TOKEN' https://api.github.com/repos/mohit-in/simplepay/statuses/\$(git rev-parse HEAD) -d '{\"state\":\"pending\",\"target_url\":\"${BUILD_URL}\",\"description\": \"The build is pending\"}'"
                }
                sh 'rm -rf var/cache/* var/log/*'
                sh 'git clean -df && git reset --hard'
                sh 'rm -f .env.test'
                sh 'echo "APP_ENV=test" >> .env.test'
                sh 'chmod 744 .env.test'
                withCredentials([string(credentialsId: 'mysql_test_db_pass', variable: 'DB_PASS')]) {
                    sh 'echo "DATABASE_URL=mysql://root:$DB_PASS@172.17.0.3:3306/simplepay" >> .env.test'
                    sh 'mysql -h 172.17.0.3 -u root -p$DB_PASS -e "create database simplepay;"'
                }
                sh './.env.test'
                sh 'composer install'
            }
        }
        stage('test') {
            steps {
                sh 'bin/console cache:warmup --env=test'
                sh 'bin/console doctrine:migrations:diff'
                sh 'php -d memory_limit=-1 bin/phpunit --exclude-group unit --log-junit phpunit.junit.xml'
            }
        }
    }
    post {
        always {
            withCredentials([string(credentialsId: 'mysql_test_db_pass', variable: 'DB_PASS')]) {
                sh 'mysql -h 172.17.0.3 -u root -p$DB_PASS -e "drop database simplepay;"'
            }
        }
        success {
            withCredentials([string(credentialsId: 'simple_pay_ashish_token', variable: 'TOKEN')]) {
                sh "curl -XPOST -H 'Authorization: token $TOKEN' https://api.github.com/repos/mohit-in/simplepay/statuses/\$(git rev-parse HEAD) -d '{\"state\":\"success\",\"target_url\":\"${BUILD_URL}\",\"description\": \"The build succeeded\"}'"
            }
        }
        failure {
            withCredentials([string(credentialsId: 'simple_pay_ashish_token', variable: 'TOKEN')]) {
                sh "curl -XPOST -H 'Authorization: token $TOKEN' https://api.github.com/repos/mohit-in/simplepay/statuses/\$(git rev-parse HEAD) -d '{\"state\":\"failure\",\"target_url\":\"${BUILD_URL}\",\"description\": \"The build failed\"}'"
            }
        }
    }
}
