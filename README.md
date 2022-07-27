# sneakerseeker

Project 2 for ATDP Web Development Course.
This is a project for people to buy shoes online.
We have a 3 brands Nike. Adidas and Puma.
So go ahead and emabark your journey in sneaking seakers with SneakerSeeker.

store.php - A store page which displays the shoes
  store.php?id=”{shoe_id}” - specific shoe listing, price etc, can add to cart
cart.php - Displays cart items of current logged in user, can clear or checkout
  checkout.php - in the name
  clearcart.php - in the name
  deleteShoe.php - delete individual shoe from cart
index.php - default signin page
signup/index.php - signup page to create new accounts
credits.php - credits page

logout.php - clears current session to log you out
checkout.php - can purchase items in your cart
admin.php - admin panel, can admin other users and modify, add, delete entries in shoes. we are clearly ethical programmers so we do not give cart info to the intern who is using this panel.
  drop.php - drops all db tables
  install.php - installs default db tables, creates default admin account
  adminedit.php - used for post requests and modifying the database securely so the intern doesn’t mess it up.

![web flow](./img/Web%20flow.png)
![db diagram](./img/Web%20Dev%20proj.png)
