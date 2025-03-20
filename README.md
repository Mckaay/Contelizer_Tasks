## 1_TEXT PROCESSING

## 📋 Prerequisites

- PHP 8.1 or higher
- Composer

## 📋 To Run
- cd 1_Text_Processing
- composer install
- php bin/processor


## 2_PESEL VALIDATOR

## 📋 Prerequisites

- PHP 8.1 or higher
- Composer

## 📋 To Run
- cd 2_Pesel_Validator
- composer install
- php bin/validator

## Tests
- php .\vendor\bin\phpunit tests

## 3: API

## 📋 Prerequisites

- PHP 8.1 or higher
- Composer
- Symfony CLI

## 📋 To Run
- cd 3_GoRestApi
- composer install
- npm install
- cp env.example .env
- fill app secret_key and gorest api token in .env file
- symfony server:start
- npm run build
- localhost:8000 - demo