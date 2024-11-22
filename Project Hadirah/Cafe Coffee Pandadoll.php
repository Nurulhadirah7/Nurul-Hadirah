<?php
  // Any PHP logic can go here
  // For example, you can include dynamic content or make database queries
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Coffee Shop</title>
  <style>
    /* Reset */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: Arial, sans-serif;
      color: #000000;
      background-color: #f9f9f9;
    }

    /* Header Section */
    header {
      background-color: #fff;
      padding: 5px;
      text-align: center;
    }

    .logo img {
      width: 300px;
      height: 300px;
    }
    
    .header-content h1 {
      font-size: 2.5em;
      margin-bottom: 10px;
    }

    .header-content p {
      font-size: 1.2em;
      margin-bottom: 20px;
    }

    .header-content button {
      padding: 10px 20px;
      background-color: #d2691e;
      color: #fff;
      border: none;
      cursor: pointer;
    }

    /* Offer Section */
    .offer-section {
      padding: 40px;
      text-align: center;
    }

    .offer-section h2 {
      font-size: 2em;
      margin-bottom: 20px;
    }

    .offer-items {
      display: flex;
      justify-content: space-around;
      flex-wrap: wrap;
    }

    .offer-item {
      width: 200px;
      margin: 20px;
      padding: 20px;
      background-color: #fff;
      border-radius: 5px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .offer-item h3 {
      font-size: 1.2em;
      margin-bottom: 10px;
    }

    /* Menu Section */
    .menu-section {
      background-color: #f4f0e6;
      padding: 40px;
      border-radius: 8px;
      text-align: center;
      font-family: 'Georgia', serif;
      color: #4a3f35;
    }

    .menu-section h2 {
      font-size: 36px;
      font-weight: bold;
      color: #3c2f2f;
      margin-bottom: 20px;
      border-bottom: 2px solid #d1b98a;
      display: inline-block;
      padding-bottom: 8px;
    }

    .menu-list {
      list-style: none;
      padding: 0;
      margin: 0;
      display: flex;
      flex-wrap: wrap;
      gap: 30px;
      justify-content: center;
    }

    .menu-list li {
      background-color: #fff8e1;
      border: 1px solid #d1b98a;
      border-radius: 10px;
      padding: 15px;
      width: 220px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      transition: transform 0.2s ease;
    }

    .menu-list li:hover {
      transform: scale(1.05);
    }

    .menu-list h3 {
      font-size: 22px;
      font-weight: bold;
      margin: 10px 0;
      color: #4a3f35;
    }

    .menu-list img {
      width: 50%;
      height: auto;
      border-radius: 8px;
      border: 1px solid #d1b98a;
      margin-top: 10px;
    }

    .menu-list li:hover {
      background-color: #fff0c1;
      border-color: #b8965a;
    }
  </style>
</head>
<body>

   <!-- Header Section -->
   <header>
    <div class="logo">
        <img src="Logo Coffee.png" alt="Coffee Shop Logo">     
    </div>
    <div class="header-content">
        <h1>A Coffee For You Can Make You Happy</h1>
        <p>The coffee is brewed by hand to ensure the perfect flavor.</p>
        <a href="Coffee Shop Now.php">
            <button>Shop Now</button>
        </a>
    </div>
   </header>

  <!-- Offer Section -->
  <section class="offer-section">
    <h2>MENU</h2>
    <div class="offer-items">
      <div class="offer-item">
        <h3>HOT</h3>
      </div>
      <div class="offer-item">
        <h3>FRAPPE</h3>
      </div>
      <div class="offer-item">
        <h3>COLD WITH ICED</h3>
      </div>
      <div class="offer-item">
        <h3>COLD WITHOUT ICED</h3>
      </div>  
    </div>
  </section>

 <!-- Menu Section -->
 <section class="menu-section">
   <h2>Bans Popular Menu</h2>
   <ul class="menu-list">
    <li>
      <h3>Americano Coffee</h3>
      <img src="Iced Americano.jpeg" alt="Americano Coffee">
    </li>
    <li>
      <h3>Ice Vietnamese Coffee</h3>
      <img src="Vietnamese Iced Coffee Recipe.jpeg" alt="Ice Vietnamese Coffee">
    </li>
    <li>
      <h3>Black Coffee</h3>
      <img src="Black Coffee 2.jpeg" alt="Black Coffee">
    </li>
    <li>
      <h3>Brazilian Roasted Coffee</h3>
      <img src="Brazilian Coffee Bliss Cocktail 2.jpeg" alt="Brazilian Roasted Coffee">
    </li>
    <li>
      <h3>Italian Roasted Coffee</h3>
      <img src="Italian Roast Coffee 2.jpeg" alt="Italian Roasted Coffee">
    </li>
    <li>
      <h3>Ice Caramel Macchiato</h3>
      <img src="Iced Caramel Macchiato 2.jpeg" alt="Ice Caramel Macchiato">
    </li>
    <li>
      <h3>Caramel Macchiato Cappuccino</h3>
      <img src="Caramel Macchiato Cappuccino.jpeg" alt="Caramel Macchiato Cappuccino">
    </li>
    <li>
      <h3>Coffee Latte</h3>
      <img src="Coffee Latte.jpg" alt="Coffee Latte">
    </li>
    <li>
      <h3>Cold Brew Coffee</h3>
      <img src="Cold Brew Coffee.jpg" alt="Cold Brew Coffee">
    </li>
    <li>
      <h3>Espresso</h3>
      <img src="Espresso.jpg" alt="Espresso">
    </li>
  </ul>
</section>

</body>
</html>
