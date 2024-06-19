<?php
session_start();

$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = 'MyN3wP4ssw0rd';
$dbname = 'LAB13Ex01';
$registered = null;
$user = null;
$notif = null;
$rowCount = null;

try {
    $pdo = new PDO("mysql:host=$dbhost", $dbuser, $dbpass);

    $pdo->exec("CREATE DATABASE IF NOT EXISTS $dbname");
    $pdo->exec("USE $dbname");

    $cartTable = "CREATE TABLE IF NOT EXISTS Cart ( 
    TableInput_id INT NOT NULL AUTO_INCREMENT,
    Product_id INT,
    Quantity INT,
    User_id INT, 

    PRIMARY KEY (TableInput_id),
    FOREIGN KEY (User_id) REFERENCES Registered (User_id)                  
    )";
    $pdo->exec($cartTable);



if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
$productId = $_POST['product_id'];
$quantity = 1;
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }
    if (isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId] += $quantity;
    } else {
        $_SESSION['cart'][$productId] = $quantity;
    }

    $isInTable = $pdo->query("SELECT * FROM Cart WHERE User_id = '{$_SESSION['user_id']}' AND Product_id = '$productId'")->fetchAll(PDO::FETCH_ASSOC);
    if($isInTable) {
        $sql = "UPDATE Cart SET Quantity = '{$_SESSION['cart'][$productId]}' WHERE User_id = '{$_SESSION['user_id']}' AND Product_id = '$productId'";
        $pdo->exec($sql);
    } else {
        $sql = "INSERT INTO Cart (Product_id, Quantity, User_id) VALUES ('$productId', '{$_SESSION['cart'][$productId]}', '{$_SESSION['user_id']}')";
        $pdo->query($sql);
    }
}

} catch (PDOException $e) {
    echo $e->getMessage();
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Main Page - Simple shop site</title>
    <link href="LAB13_Ex04.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="page">
    <div class="top-nav-header">
        <div class="top-nav-container">
            <div class="top-left-menu">
                <form action="LAB13_Ex04-3.php">
                    <button type="submit">Cart</button>
                </form>
            </div>
            <div class="top-right-menu">
                <div class="menu-item 1">
                    <form action="LAB13_Ex04-2.php">
                        <button type="submit">Register & Login</button>
                    </form>
                </div>
                <div class="menu-item 2 bank">
                    <form action="LAB13_Ex04-4.php">
                        <button type="submit">Bank</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="image-text-container">
        <header class="middle-text">
            <h1>
                <strong>Simple Shop</strong>
                Dolorem ex vel similique ut consectetur quidem tempore?
            </h1>
        </header>
        <div class="header-background"><img src="https://i.imgur.com/08SHq9K.png" alt="header-background"></div>
    </div>
    <div class="boxes">
        <div class="box box1">
            <div class="box-top">
                <div class="box-text">22.01.2021</div>
            </div>
            <header class="box-bottom">
                <h2>
                    <strong>Quaerat architecto voluptatem beatae.</strong>
                    Eos enim fugiat aspernatur unde! Quiz laborum dolorem alias aliquam quibusdam eligendi rerum aut
                    earum, illo est nihil mollitia evenit fugit pariatur nemo, expedita adipisci sint. Rescusandae
                    tempora deleniti impedit.
                </h2>
                <form action="" method="post">
                    <button type="submit" name="add_to_cart">Add to Cart</button>
                    <input type="hidden" name="product_id" value="1">
                </form>
            </header>
        </div>
        <div class="box box2">
            <div class="box-top">
                <div class="box-text">25.01.2021</div>
            </div>
            <header class="box-bottom">
                <h2>
                    <strong>Inventore quidem soluta praesentium?</strong>
                    Reprehenderit, ipsam vitae. Illo minus earum obcaecati quaerat laborum non maiores
                    exercitationem voluptatem, mollitia nihil sed rerum. Quae, doloribus? Dolorem magni modi, quod
                    veritatis nesciunt quas ut nobis officia doloremque.
                </h2>
                <form action="" method="post">
                    <button type="submit" name="add_to_cart">Add to Cart</button>
                    <input type="hidden" name="product_id" value="2">
                </form>
            </header>
        </div>
        <div class="box box3">
            <div class="box-top">
                <div class="box-text">30.01.2021</div>
            </div>
            <header class="box-bottom">
                <h2>
                    <strong>Eligendi accusamus iure molestias?</strong>
                    Quaerat quo, architecto a maiores neque commodi. Doloremque, eligendi. Quae fuga nam repellat
                    nemo ipsam molestias sed delectus nulla omnis iusto ratione facere odio, placeat dicta sunt
                    eligendi voluptas culpa.
                </h2>
                <form action="" method="post">
                    <button type="submit" name="add_to_cart">Add to Cart</button>
                    <input type="hidden" name="product_id" value="3">
                </form>
            </header>
        </div>
        <div class="box box4">
            <div class="box-top">
                <div class="box-text">12.02.2021</div>
            </div>
            <header class="box-bottom">
                <h2>
                    <strong>Id culpa obcaecati beatae.</strong>
                    Amet labore nulla possimus dolore ipsa nobis impedit sit repellat obcaecati officiis commodi, ullam
                    aperiam fuga cum veritatis, repudiandae natus quod neque sunt omnis quo. Error, quas! Sequi,
                    repudiandae consequuntur!
                </h2>
                <form action="" method="post">
                    <button type="submit" name="add_to_cart">Add to Cart</button>
                    <input type="hidden" name="product_id" value="4">
                </form>
            </header>
        </div>
        <div class="box box5">
            <div class="box-top">
                <div class="box-text">19.02.2021</div>
            </div>
            <header class="box-bottom">
                <h2>
                    <strong>Sequi debitis laboriosam illo?</strong>
                    Ipsam qui amet eligendi nam delectus molestiae dolores itaque quod aliquid aperiam, esse repellat
                    pariatur quasi natus possimus hic minus? Optio, mollitia qui cupiditate ut quibusdam aliquam
                    delectus assumenda in.
                </h2>
                <form action="" method="post">
                    <button type="submit" name="add_to_cart">Add to Cart</button>
                    <input type="hidden" name="product_id" value="5">
                </form>
            </header>
        </div>
        <div class="box box6">
            <div class="box-top">
                <div class="box-text">21.02.2021</div>
            </div>
            <header class="box-bottom">
                <h2>
                    <strong>Debitis eligendi beatae ut.</strong>
                    Dolor facilis tempore quidem iste blanditiis vitae, reiciendis nisi labore fugit enim a quia quaerat
                    aliquid maxime possimus aut. Corrupti officiis labore voluptatibus dolorem eveniet vero culpa iusto
                    beatae quo!
                </h2>
                <form action="" method="post">
                    <button type="submit" name="add_to_cart">Add to Cart</button>
                    <input type="hidden" name="product_id" value="6">
                </form>
            </header>
        </div>
        <div class="box box7">
            <div class="box-top">
                <div class="box-text">02.03.2021</div>
            </div>
            <header class="box-bottom">
                <h2>
                    <strong>Porro quas fugiat dolorem.</strong>
                    Sequi eaque iste commodi quidem eveniet ex vel voluptatum animi sed cum, blanditiis culpa velit
                    libero minus earum accusamus illo voluptates non. Nihil sit neque ratione at quis, iusto dicta!
                </h2>
                <form action="" method="post">
                    <button type="submit" name="add_to_cart">Add to Cart</button>
                    <input type="hidden" name="product_id" value="7">
                </form>
            </header>
        </div>
        <div class="box box8">
            <div class="box-top">
                <div class="box-text">11.03.2021</div>
            </div>
            <header class="box-bottom">
                <h2>
                    <strong>Adipisci, soluta. At, labore.</strong>
                    Ducimus odio alias qui officiis consectetur delectus magni ipsum mollitia nulla aspernatur unde
                    aperiam, laboriosam modi sapiente autem fugiat ratione corporis temporibus facere magnam possimus
                    ullam accusamus dignissimos eveniet! Magnam!
                </h2>
                <form action="" method="post">
                    <button type="submit" name="add_to_cart">Add to Cart</button>
                    <input type="hidden" name="product_id" value="8">
                </form>
            </header>
        </div>
        <div class="box box9">
            <div class="box-top">
                <div class="box-text">14.03.2021</div>
            </div>
            <header class="box-bottom">
                <h2>
                    <strong>Eos perspiciatis exercitationem laudantium.</strong>
                    Dicta a perferendis laborum odio animi, quas in fuga ipsa impedit, repudiandae sed. Eveniet qui
                    vitae eum laborum dolorem quis architecto ea nam ipsa, maiores officia omnis aliquid explicabo
                    possimus!
                </h2>
                <form action="" method="post">
                    <button type="submit" name="add_to_cart">Add to Cart</button>
                    <input type="hidden" name="product_id" value="9">
                </form>
            </header>
        </div>
        <div class="box-big box10">
            <div class="box-top">
                <div class="box-text">11.03.2021</div>
            </div>
            <header class="box-bottom">
                <h2>
                    <strong>Adipisci, soluta. At, labore.</strong>
                    Ducimus odio alias qui officiis consectetur delectus magni ipsum mollitia nulla aspernatur unde
                    aperiam, laboriosam modi sapiente autem fugiat ratione corporis temporibus facere magnam possimus
                    ullam accusamus dignissimos eveniet! Magnam!
                </h2>
                <form action="" method="post">
                    <button type="submit" name="add_to_cart">Add to Cart</button>
                    <input type="hidden" name="product_id" value="10">
                </form>
            </header>
        </div>
        <div class="box-big box11">
            <div class="box-top">
                <div class="box-text">14.03.2021</div>
            </div>
            <header class="box-bottom">
                <h2>
                    <strong>Eos perspiciatis exercitationem laudantium.</strong>
                    Dicta a perferendis laborum odio animi, quas in fuga ipsa impedit, repudiandae sed. Eveniet qui
                    vitae eum laborum dolorem quis architecto ea nam ipsa, maiores officia omnis aliquid explicabo
                    possimus!
                </h2>
                <form action="" method="post">
                    <button type="submit" name="add_to_cart">Add to Cart</button>
                    <input type="hidden" name="product_id" value="11">
                </form>
            </header>
        </div>
    </div>
</div>
</body>
</html>