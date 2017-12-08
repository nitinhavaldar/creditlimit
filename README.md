# Credit Limit
The Credit Limit for Magento 2.x extension allows you to set a customer credit limit and adds payment method pay on credit, which is used to accept credit orders.

# Features
1) Admin can set Credit Limit to Customers
2) Customer can use Credit Limit to place an order
3) New Payment Method called `Pay On Account` will be activated at the checkout if customer has an enough credit limits to place the order.
4) There is a seperate section called `My Credit Limits` on the Customer dashboard page.
5) Customers can transfer Credit Limits to other registered users of the website.
6) Customers can see the transaction history at the dashboard.

# How to Install
1) Clone the latest from repository
2) Extract files in the Magento root directory in the folder app/code/Evry/Creditlimit & app/code/Evry/Payonaccount
3) php bin/magento setup:upgrade
4) php bin/magento setup:di:compile
5) php bin/magento cache:clean
