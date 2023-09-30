
# Budget Tracker Web App

Welcome to the Budget Tracker web application! This web app helps you manage your finances, track your income and expenses, and visualize your financial data using interactive charts. 📊💰

## Table of Contents
- [Features](#features)
- [Getting Started](#getting-started)
- [Usage](#usage)
- [Charts](#charts)
- [Contributing](#contributing)
- [License](#license)

## Features
- **User Authentication**: Securely log in and protect your financial data with user authentication. 🔒
- **Transaction Management**: Add, edit, or delete transactions to keep your financial records up-to-date. 🔄
- **Profile Customization**: Personalize your profile by updating your username and other details. 🧑‍💼
- **Currency Conversion**: Automatically convert your budget to euros based on the latest exchange rate from the European Central Bank (ECB). 💶
- **Expense Tracking**: Monitor your expenses and check if you are in debt or not. 💸
- **Interactive Charts**: Visualize your income, expenses, and the overall financial situation with interactive pie charts. 📈
- **Responsive Design**: The web app is designed to work seamlessly on both desktop and mobile devices. 📱💻

## Getting Started
0. You can use this site (http://penniwisesorintproject.rf.gd/) that work without any settings, this is the best solutions for the beginners but you can't modify the code so if you want make this project more yours go to the technical way...
1. Clone the repository to your local machine.
   ```
   git clone https://github.com/Notkruxx/Sorint
   ```
2. Set up a web server (e.g., Apache) and a PHP environment. 🖥️
3. Create a MySQL database and import the provided SQL schema to set up the necessary tables. 🗃️
4. <img src="https://i.imgur.com/e4j4Xrt.png"   
style="float: left; margin-right: 10px;" />
5. Configure the database connection in the `php/config.php` file.
   ```php
   $con = mysqli_connect("localhost", "username", "password", "database_name");
   ```
6. Start your web server and open the web app in your web browser. 🌐

## Usage
1. **Log In**: Log in with your username and password. If you don't have an account, you can register on the login page. 🚪
2. **Dashboard**: The dashboard displays your username and some basic information about your budget. 📊
3. **Navigation**: Use the navigation links to access different features:
   - **Edit or Delete Transactions**: Edit or delete your financial transactions. ✏️❌
   - **Change Profile**: Customize your profile settings. 🔄
   - **Save a Transaction**: Add a new financial transaction to your records. 💵
   - **Log Out**: Log out of your account. 🚶‍♂️
4. **Transaction History**: View a table of your transaction history, including transaction IDs and amounts. 📜
5. **Charts**: Explore interactive pie charts that visualize your income vs. expense and detailed income and expense categories. 📈🍰

## Charts
- **Income vs. Expense**: This pie chart shows the overall balance between your income and expenses. 🥧💰
- **Income**: This pie chart breaks down your income by individual earnings. 💵
- **Expense**: This pie chart breaks down your expenses by individual expenses. 💸

## Contributing
We welcome contributions from the open-source community! If you'd like to contribute to this project, please follow these steps:
1. Fork the repository. 🍴
2. Create a new branch for your feature or bug fix. 🌿
3. Make your changes and commit them with descriptive commit messages. 📝
4. Push your changes to your fork. 🚀
5. Create a pull request to the main repository's `main` branch. 🔄

## License
This project is licensed under the [MIT License](LICENSE). Feel free to use, modify, and distribute it as you see fit. 📜🆓
