# SellBuy E-Commerce

## Table of Contents
- [About the Project](#about-the-project)
- [Main Features](#main-features)
- [Built With](#built-with)
- [Entity Relationship Diagram (ERD)](#entity-relationship-diagram)
- [Getting Started](#getting-started)
    - [Prerequisites](#prerequisites)
    - [Installation](#installation)
- [Overview](#overview)

---

## About the Project
<img src="docs/Screenshot_1.png" alt="SELLBUY" >

<b>Sellbuy</b> is an e-commerce platform, developed in PHP, offers the online sale of unisex clothing and accessories. It provides a user-friendly interface, secure purchasing, and efficient product management to deliver a seamless shopping experience.

### Main Features:
- User authentication with email and password.
- Sign Up & Sign In.
- Database implementation with Docker.


## Built With

- **PHP**: Language for robust backend application development.
- **HTML, CSS and JavaScript**: Handles UI/UX and functionality on the Web Client.
- **MySQL**: Relational database.
- **Docker**: Container Management.
- **Mercado Pago**: Payment Gateway.


---


## Entity Relationship Diagram
<img src="docs/sellbuy_php_db.png">

---

## Getting Started

### Prerequisites

Ensure you have the following installed:
- PHP 8 or higher.
- Docker for container management
- MySQL configured and running locally with Docker.


### Installation

1. Clone the repository and install dependencies:
   ```bash
   git clone https://github.com/anthonygrr/sellbuyEcommerce.git
   cd sellbuyEcommerce
   ```

2. Run the docker-compose.yml file, it will run the Database Container with the initial scripts.
    ```bash
   docker compose up -d
   ```

3. Create the `.env` file in the root, place your credentials from Mercado Pago.


4. Start the application:
   ```bash
   php -S localhost:3000
   ```

---


## Overview

### Home Page
<img src="docs/Screenshot_1.png">

<img src="docs/Screenshot_2.png">

### Products 
<img src="docs/Screenshot_3.png">

### Details 
<img src="docs/Screenshot_4.png">

### Cart 
<img src="docs/Screenshot_5.png">

### Payment
<img src="docs/Screenshot_8.png">

### Ticket
<img src="docs/Screenshot_9.png">

### Buy History 
<img src="docs/Screenshot_6.png">

### Profile 
<img src="docs/Screenshot_7.png">

### Sign In
<img src="docs/Screenshot_11.png">

### About Us
<img src="docs/Screenshot_10.png">






