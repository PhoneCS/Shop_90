
        // เพิ่ม PHP ในส่วนที่จำเป็น (รูปแบบความเห็น)
        /*
        <?php
        // โค้ด PHP สำหรับการเชื่อมต่อฐานข้อมูล
        $servername = "localhost";
        $username = "username";
        $password = "password";
        $dbname = "shop90";

        // สร้างการเชื่อมต่อ
        $conn = new mysqli($servername, $username, $password, $dbname);

        // ตรวจสอบการเชื่อมต่อ
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // ดึงข้อมูลสินค้า
        $sql = "SELECT id, name, price, original_price, image FROM products WHERE featured = 1 LIMIT 4";
        $result = $conn->query($sql);

        // แสดงสินค้า
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo '<div class="product-card">';
                echo '<div class="product-img"><img src="' . $row["image"] . '" alt="' . $row["name"] . '"></div>';
                echo '<div class="product-info">';
                echo '<h3 class="product-title">' . $row["name"] . '</h3>';
                echo '<div class="product-price">';
                if ($row["original_price"] > $row["price"]) {
                    echo '<span class="original-price">' . $row["original_price"] . ' บาท</span>';
                }
                echo $row["price"] . ' บาท</div>';
                echo '<div class="product-rating">★★★★☆</div>';
                echo '<a href="#" class="btn btn-add-to-cart" data-product-id="' . $row["id"] . '" data-product-name="' . $row["name"] . '">เพิ่มลงตะกร้า</a>';
                echo '</div></div>';
            }
        }

        $conn->close();
        ?>
        */