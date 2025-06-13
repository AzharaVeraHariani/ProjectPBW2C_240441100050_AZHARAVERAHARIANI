<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['Login'])) {
  header("Location: Login.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Eatzy</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <style>
    body {
      background: #f0f8ff;
      font-family: 'Segoe UI', sans-serif;
    }

    .card {
      border-radius: 20px;
      box-shadow: 0 6px 12px rgba(0,0,0,0.1);
      transition: transform 0.3s ease;
    }

    .card:hover {
      transform: translateY(-5px);
    }

    .card-img-top {
      height: 180px;
      object-fit: cover;
      border-top-left-radius: 20px;
      border-top-right-radius: 20px;
    }

    #searchInput {
      border-radius: 30px;
      padding: 12px 20px;
      box-shadow: 0 0 5px rgba(0,0,0,0.1);
    }

    .star-rating {
      color: #ff9800;
    }

    .section-title {
      color: rgb(32, 22, 95);
      font-weight: bold;
    }

    .btn-filter.active {
      background-color: #00bcd4 !important;
      color: #fff;
    }
  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #002b5c;">
  <div class="container">
    <a class="navbar-brand fw-bold" href="#">Eatzy</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarContent">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link active" href="#">Beranda</a></li>
        <li class="nav-item"><a class="nav-link" href="#menuContainer">Menu</a></li>
        <li class="nav-item"><a class="nav-link" href="ulasan.php">Ulasan</a></li>
        <li class="nav-item"><a class="nav-link" href="#rekomendasiMakanan">Rekomendasi</a></li>
        <li class="nav-item"><a class="nav-link" href="#promoVoucher">Promo</a></li>
      </ul>
    </div>
  </div>
</nav>

<section class="hero-section text-white py-5 position-relative" 
  style="background: url('img/hero2.jpg') center/cover no-repeat; height: 90vh; display: flex; align-items: center;">
  <div class="container text-center position-relative z-2">
    <div class="p-5 rounded-4 shadow-lg" style="backdrop-filter: blur(4px); background-color: rgba(0, 0, 0, 0.4);">
      <h1 class="display-3 fw-bold mb-3">Eatzy Rasa Juara</h1>
      <p class="lead mb-4">Nikmati hidangan lezat, promo seru, dan pengalaman kuliner terbaik di ujung jari Anda!</p>
      <a href="#menuContainer" class="btn btn-warning btn-lg px-4 rounded-pill fw-semibold shadow">Lihat Menu</a>
    </div>
  </div>
</section>

<!-- Fitur Cari -->
<div class="container mt-5">
  <input type="text" id="searchInput" class="form-control" placeholder="Cari menu...">
</div>

<!-- kategori -->
<div class="container mt-3 text-center">
  <div class="btn-group">
    <button class="btn btn-outline-secondary btn-filter active" data-filter="all">Semua</button>
    <button class="btn btn-outline-secondary btn-filter" data-filter="Makanan Berat">Makanan Berat</button>
    <button class="btn btn-outline-secondary btn-filter" data-filter="Minuman">Minuman</button>
    <button class="btn btn-outline-secondary btn-filter" data-filter="Camilan">Camilan</button>
  </div>
</div>


<?php
$menu = [
  ["id"=>1, "name"=>"Nasi Pecel", "desc"=>"Nasi dengan bumbu kacang", "price"=>20000, "img"=>"pecel.jpg", "rating"=>4, "category"=>"Makanan Berat", "best_seller"=>true],
  ["id"=>2, "name"=>"Nasi Goreng", "desc"=>"Makanan berat favorit semua orang", "price"=>15000, "img"=>"nasigoreng.jpg", "rating"=>5, "category"=>"Makanan Berat", "best_seller"=>true],
  ["id"=>3, "name"=>"Soto Ayam", "desc"=>"Soto ayam khas lamongan", "price"=>20000, "img"=>"soto.jpg", "rating"=>4, "category"=>"Makanan Berat", "best_seller"=>true],
  ["id"=>4, "name"=>"Chicken Katsu", "desc"=>"Chicken Katsu, kerenyahan yang bikin ketagihan!", "price"=>25000, "img"=>"chicken_katsu.jpg", "rating"=>3, "category"=>"Makanan Berat", "best_seller"=>false],
  ["id"=>5, "name"=>"Seblak Pedas", "desc"=>"Seblak pedas, sensasi gurih yang bikin nagih", "price"=>22000, "img"=>"seblak.jpg", "rating"=>5, "category"=>"Makanan Berat", "best_seller"=>false],
  ["id"=>6, "name"=>"Mie Goreng", "desc"=>"Mie goreng spesial ala cafe", "price"=>25000, "img"=>"miegoreng.jpg", "rating"=>4, "category"=>"Makanan Berat", "best_seller"=>false],
  ["id"=>7, "name"=>"Sate Ayam", "desc"=>"Tusuk sate kecil, rasa besar di setiap gigitan", "price"=>20000, "img"=>"sate.jpg", "rating"=>4, "category"=>"Makanan Berat", "best_seller"=>false],
  ["id"=>8, "name"=>"Bakso", "desc"=>"Gigit bakso kenyal, nikmatnya nendang di lidah", "price"=>16000, "img"=>"bakso.jpg", "rating"=>4, "category"=>"Makanan Berat", "best_seller"=>false],
  ["id"=>9, "name"=>"Kentang Goreng", "desc"=>"Satu nggak cukup! Kentang goreng bikin susah berhenti", "price"=>10000, "img"=>"kentang.jpg", "rating"=>4, "category"=>"Camilan", "best_seller"=>false],
  ["id"=>10, "name"=>"Roti Bakar", "desc"=>"Roti yang dipanggang dengan taburan toping", "price"=>10000, "img"=>"roti_bakar.jpg", "rating"=>4, "category"=>"Camilan", "best_seller"=>false],
  ["id"=>11, "name"=>"Tahu Gejrot", "desc"=>"Pedas, manis, asam, gurih,tahu gejrot penuh kejutan rasa!", "price"=>10000, "img"=>"tahu.jpg", "rating"=>4, "category"=>"Camilan", "best_seller"=>false],
  ["id"=>12, "name"=>"Pisang Lumer", "desc"=>"Manisnya pas, lumernya puas! Pisang lumer siap manjain lidah", "price"=>12000, "img"=>"pisang.jpg", "rating"=>4, "category"=>"Camilan", "best_seller"=>false],
  ["id"=>13, "name"=>"Sosis Solo", "desc"=>"Sosis Solo, camilan tradisional dengan rasa yang elegan", "price"=>12000, "img"=>"sosis.jpg", "rating"=>5, "category"=>"Camilan", "best_seller"=>false],
  ["id"=>14, "name"=>"Kebab", "desc"=>"Daging gurih berpadu sayur segar dan saus nikmat, semua dalam satu gulungan!", "price"=>15000, "img"=>"kebab.jpg", "rating"=>4, "category"=>"Camilan", "best_seller"=>false],
  ["id"=>15, "name"=>"Churos", "desc"=>"Kriuk manis yang pas banget buat nemenin waktu santaimu", "price"=>10000, "img"=>"churos.jpg", "rating"=>5, "category"=>"Camilan", "best_seller"=>false],
  ["id"=>16, "name"=>"Jasuke", "desc"=>"Jagung dengan susu kental manis dan taburan keju", "price"=>10000, "img"=>"jasuke.jpg", "rating"=>4, "category"=>"Camilan", "best_seller"=>false],
  ["id"=>17, "name"=>"Air Mineral", "desc"=>"Segarnya alami, bantu segarkan harimu", "price"=>8000, "img"=>"air.jpg", "rating"=>4, "category"=>"Minuman", "best_seller"=>false],
  ["id"=>18, "name"=>"Es Teh", "desc"=>"Rasa teh yang khas, dinginnya bikin lega", "price"=>8000, "img"=>"teh.jpg", "rating"=>5, "category"=>"Minuman", "best_seller"=>false],
  ["id"=>19, "name"=>"Es Jeruk", "desc"=>"Segarnya perasan jeruk yang manis", "price"=>10000, "img"=>"jeruk.jpg", "rating"=>4, "category"=>"Minuman", "best_seller"=>false],
  ["id"=>20, "name"=>"Es Leci Tea", "desc"=>"Perpaduan teh dan leci yang bikin mood langsung naik", "price"=>15000, "img"=>"leci.jpg", "rating"=>4, "category"=>"Minuman", "best_seller"=>false],
  ["id"=>21, "name"=>"Red velvet", "desc"=>"Warna merah menggoda, rasanya bikin jatuh cinta", "price"=>15000, "img"=>"velvet.jpg", "rating"=>4, "category"=>"Minuman", "best_seller"=>false],
  ["id"=>22, "name"=>"Es Thai Tea", "desc"=>"Sensasi teh Thailand yang lezat dan menyegarkan", "price"=>13000, "img"=>"thai.jpg", "rating"=>5, "category"=>"Minuman", "best_seller"=>false],
  ["id"=>23, "name"=>"Matcha Latte", "desc"=>"Matcha Latte, perpaduan sempurna antara rasa pahit dan manis", "price"=>15000, "img"=>"matcha.jpg", "rating"=>4, "category"=>"Minuman", "best_seller"=>false],
  ["id"=>24, "name"=>"Hot Coffe", "desc"=>"Secangkir kopi panas, teman setia saat santa", "price"=>12000, "img"=>"coffe.jpg", "rating"=>4, "category"=>"Minuman", "best_seller"=>false],
];


function renderMenuCards($menuList) {
  foreach ($menuList as $item) {
    echo '
    <div class="col menu-item" data-category="'.$item['category'].'">
      <div class="card h-100 text-center">
        <img src="'.$item['img'].'" class="card-img-top" alt="'.$item['name'].'">
        <div class="card-body">
          <h5 class="card-title">'.$item['name'].'</h5>
          <p class="card-text">'.$item['desc'].'</p>
          <span class="badge bg-success mb-2">Rp '.number_format($item['price'], 0, ',', '.').'</span>
          <div class="star-rating">'.str_repeat("⭐", $item['rating']).str_repeat("☆", 5 - $item['rating']).'</div>
          <form method="POST" action="cart.php">
            <input type="hidden" name="id" value="'.$item['id'].'">
            <input type="hidden" name="name" value="'.$item['name'].'">
            <input type="hidden" name="price" value="'.$item['price'].'">
            <button class="btn btn-outline-primary btn-sm mt-2">Tambah ke Keranjang</button>
          </form>
        </div>
      </div>
    </div>';
  }
}
?>

<div class="container mt-5 mb-5">
  <h2 class="section-title">Menu Kami</h2>
  <div class="row row-cols-1 row-cols-md-4 g-4" id="menuContainer">
    <?php renderMenuCards($menu); ?>
  </div>
</div>

<!-- Rekomendasi Makanan -->
<div class="container my-5" id="rekomendasiMakanan">
  <h2 class="section-title mb-4">Rekomendasi Makanan</h2>
  <div class="row row-cols-1 row-cols-md-3 g-4">
    <div class="col">
      <div class="card h-100 text-center">
        <img src="nasigoreng.jpg" class="card-img-top" alt="Nasi Goreng">
        <div class="card-body">
          <h5 class="card-title">Nasi Goreng</h5>
          <p class="card-text">Makanan berat favorit semua orang, penuh rasa!</p>
          <span class="badge bg-success">Rp 15.000</span>
        </div>
      </div>
    </div>
      <div class="col">
      <div class="card h-100 text-center">
        <img src="seblak.jpg" class="card-img-top" alt="Seblak Pedas">
        <div class="card-body">
          <h5 class="card-title">Seblak Pedas</h5>
          <p class="card-text">Seblak pedas, sensasi gurih yang bikin nagih.</p>
          <span class="badge bg-success">Rp 22.000</span>
        </div>
      </div>
    </div>
    <div class="col">
      <div class="card h-100 text-center">
        <img src="sosis.jpg" class="card-img-top" alt="Sosis Solo">
        <div class="card-body">
          <h5 class="card-title">Sosis Solo</h5>
          <p class="card-text">Sosis Solo, camilan tradisional dengan rasa yang elegan.</p>
          <span class="badge bg-success">Rp 12.000</span>
        </div>
      </div>
    </div>
    <div class="col">
      <div class="card h-100 text-center">
        <img src="churos.jpg" class="card-img-top" alt="Churos">
        <div class="card-body">
          <h5 class="card-title">Churos</h5>
          <p class="card-text">Kriuk manis yang pas banget buat nemenin waktu santaimu.</p>
          <span class="badge bg-success">Rp 10.000</span>
        </div>
      </div>
    </div>
    <div class="col">
      <div class="card h-100 text-center">
        <img src="Teh.jpg" class="card-img-top" alt="Es Teh">
        <div class="card-body">
          <h5 class="card-title">Es Teh</h5>
          <p class="card-text">Rasa teh yang khas, dinginnya bikin lega.</p>
          <span class="badge bg-success">Rp 8.000</span>
        </div>
      </div>
    </div>
    <div class="col">
      <div class="card h-100 text-center">
        <img src="Thai.jpg" class="card-img-top" alt="Es Thai Tea">
        <div class="card-body">
          <h5 class="card-title">Es Thai Tea</h5>
          <p class="card-text">Sensasi teh Thailand yang lezat dan menyegarkan.</p>
          <span class="badge bg-success">Rp 13.000</span>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Promo Diskon / Voucher -->
<div class="container my-5" id="promoVoucher">
  <h2 class="section-title mb-4">Promo Diskon & Voucher</h2>
  <div class="row row-cols-1 row-cols-md-2 g-4">
    <div class="col">
      <div class="alert alert-danger text-center h-100" role="alert">
        <h4 class="alert-heading">Diskon 20% untuk Pembelian Nasi Goreng!</h4>
        <p>Gunakan kode <strong>NASI20</strong> saat checkout.</p>
        <hr>
        <p class="mb-0">Berlaku sampai 30 Juni 2025.</p>
      </div>
    </div>
    <div class="col">
      <div class="alert alert-success text-center h-100" role="alert">
        <h4 class="alert-heading">Voucher Minuman Gratis!</h4>
        <p>Dapatkan voucher untuk minuman gratis pada pembelian min. Rp 50.000.</p>
        <hr>
        <p class="mb-0">Gunakan kode <strong>GRATISMINUM</strong></p>
      </div>
    </div>
    <div class="col">
      <div class="alert alert-warning text-center h-100" role="alert">
        <h4 class="alert-heading">Cashback 10% untuk Pesanan Online!</h4>
        <p>Gunakan kode <strong>CASHBACK10</strong> via website.</p>
        <hr>
        <p class="mb-0">Berlaku s.d. 15 Juli 2025.</p>
      </div>
    </div>
    <div class="col">
      <div class="alert alert-primary text-center h-100" role="alert">
        <h4 class="alert-heading">Gratis Ongkir!</h4>
        <p>Minimal belanja Rp 100.000, gunakan kode <strong>ONGKIR0</strong>.</p>
        <hr>
        <p class="mb-0">S&K Berlaku</p>
      </div>
    </div>
  </div>
</div>

<!-- Tambahkan script pencarian dan filter di akhir -->
<script>
  const searchInput = document.getElementById("searchInput");
  const filterButtons = document.querySelectorAll(".btn-filter");
  const menuItems = document.querySelectorAll(".menu-item");

  searchInput.addEventListener("input", function () {
    const keyword = this.value.toLowerCase();
    menuItems.forEach(item => {
      const name = item.querySelector(".card-title").textContent.toLowerCase();
      item.style.display = name.includes(keyword) ? "block" : "none";
    });
  });

  filterButtons.forEach(btn => {
    btn.addEventListener("click", () => {
      document.querySelector(".btn-filter.active").classList.remove("active");
      btn.classList.add("active");
      const filter = btn.getAttribute("data-filter");
      menuItems.forEach(item => {
        const category = item.getAttribute("data-category");
        item.style.display = filter === "all" || category === filter ? "block" : "none";
      });
    });
  });
</script>

</body>
</html>
