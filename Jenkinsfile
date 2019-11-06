pipeline {
    agent {
        dockerfile {
            dir 'docker/jenkins'
        }
    }
    stages {
        stage('Prepare Web Server') {
            steps {
                sh 'rm -rf vendor/'
                sh 'cp -r $PWD/ /srv/'
                sh 'a2enmod rewrite'
                sh 'service apache2 start'
            }
        }
        stage('build') {
            steps {
                withCredentials([string(credentialsId: 'simple_pay_ashish_token', variable: 'TOKEN')]) {
                    sh "curl -XPOST -H 'Authorization: token $TOKEN' https://api.github.com/repos/mohit-in/simplepay/statuses/\$(git rev-parse HEAD) -d '{\"state\":\"pending\",\"target_url\":\"${BUILD_URL}\",\"description\": \"The build is pending\"}'"
                }
                sh 'rm -rf var/cache/* var/log/*'
                sh 'git clean -df && git reset --hard'
                withCredentials([string(credentialsId: 'mysql_test_db_pass', variable: 'DB_PASS')]) {
                    sh 'echo "DATABASE_URL=mysql://root:$DB_PASS@172.17.0.2:3306/simplepay" >> .env.test'
                    sh 'mysql -h 172.17.0.2 -u root -p$DB_PASS -e "create database simplepay;"'
                }
                sh 'echo "TEST_HOST=http://172.17.0.4/v1" >> .env.test'
                sh 'composer install'
                sh 'composer dump-env test'
            }
        }
        stage('test') {
            steps {
                sh 'APP_ENV=test php bin/console cache:clear'
                sh 'php bin/console doctrine:migrations:migrate'
                sh 'APP_ENV=test php -d memory_limit=-1 vendor/bin/phpunit --exclude-group unit --log-junit phpunit.junit.xml'
                sh 'APP_ENV=test php -d memory_limit=-1 vendor/bin/behat --strict --stop-on-failure --format progress --out std --format junit --out behat.junit.xml'
            }
        }
    }
    post {
        always {
            withCredentials([string(credentialsId: 'mysql_test_db_pass', variable: 'DB_PASS')]) {
                sh 'mysql -h 172.17.0.2 -u root -p$DB_PASS -e "drop database simplepay;"'
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
