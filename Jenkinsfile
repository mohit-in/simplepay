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
                sh 'rm -rf app/cache/* app/logs/*'
                sh 'git clean -df && git reset --hard'
                sh 'rm -f app/config/parameters.yml'
                sh 'echo "APP_ENV=test" >> .env.test'
                sh 'chmod 744 .env.test'
                withCredentials([string(credentialsId: 'mysql_test_db_pass', variable: 'DB_PASS')]) {
                    sh 'echo "DATABASE_URL=mysql://root:$DB_PASS@172.31.24.83:3306/simplepay" >> .env.test'
                }
                sh './.env.test'
                sh 'composer install'
            }
        }
        stage('test') {
            steps {
                sh 'app/console cache:warmup --env=test'
                sh 'php -d memory_limit=-1 bin/phpunit --exclude-group unit --log-junit phpunit.junit.xml'
            }
        }
    }
}
