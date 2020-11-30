RabbitMQ Sample Project
===================

This is a simple symfony project to show how we can implement a RabbitMQ producer.

The goal of this project is creating an API to add a new student to database. Then after saving it in database, we will publish the information of the new student to our RabbitMQ broker.

First you should run docker-composer up -d
