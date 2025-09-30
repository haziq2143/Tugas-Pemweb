<!doctype html>
<html>
<?php
$temp = [];
$json = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nama    = $_POST['nama'];
  $nim     = $_POST['nim'];
  $prodi   = $_POST['prodi'];
  $kelamin = $_POST['kelamin'];
  $alamat  = $_POST['alamat'];
  $hobi    = isset($_POST['hobi']) ? $_POST['hobi'] : [];

  $temp = [
    'nama'  => $nama,
    'nim'           => $nim,
    'prodi' => $prodi,
    'kelamin' => $kelamin,
    'alamat' => $alamat,
    'hobi'   => $hobi
  ];

  $file = "biodata.json";
  $existing = [];

  if (file_exists($file)) {
    $jsonData = file_get_contents($file);
    $existing = json_decode($jsonData, true) ?? [];
  }

  $existing[] = $temp;

  file_put_contents($file, json_encode($existing, JSON_PRETTY_PRINT));
  header("Location: " . $_SERVER['PHP_SELF']);
  exit;
}
?>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <style>
    .bg {
      background-image: url('bg.jpg');
      background-position: top top;
      background-repeat: no-repeat;
      background-size: cover;
    }
  </style>
</head>

<body class="bg">

  <div class="min-h-screen w-full flex justify-center items-center ">
    <div class="w-full xl:w-1/2 bg-white/20 p-8 m-6 backdrop-blur-md rounded-2xl shadow-xl border border-white/30">
      <h1 class="font-extrabold text-white text-4xl text-center mb-10 drop-shadow-lg">Input Data Diri</h1>
      <form action="" method="POST" class="space-y-6">
        <div>
          <label for="nama_lengkap" class="block font-semibold text-white mb-1">Nama Lengkap:</label>
          <input type="text" id="nama_lengkap" name="nama" placeholder="Masukkan Nama" required
            class="focus:ring-0 focus:ring-offset-0 focus:outline-none border-b border-purple-500 bg-transparent p-2 text-white text-lg w-full placeholder-gray-300">
        </div>
        <div>
          <label for="nim" class="block font-semibold text-white mb-1">NIM:</label>
          <input type="text" id="nim" name="nim" placeholder="Masukkan NIM" required
            class="focus:ring-0 focus:ring-offset-0 focus:outline-none border-b border-purple-500 bg-transparent p-2 text-white text-lg w-full placeholder-gray-300">
        </div>
        <div>
          <label for="prodi" class="block font-semibold text-white mb-1">Program Studi:</label>
          <select id="prodi" name="prodi"
            class="focus:ring-0 focus:ring-offset-0 focus:outline-none border-b border-purple-500 bg-transparent p-2 text-white text-lg w-full">
            <option value="Informatika" class="text-slate-800">Informatika</option>
            <option value="Sistem Informasi" class="text-slate-800">Sistem Informasi</option>
            <option value="Teknik Elektro" class="text-slate-800">Teknik Elektro</option>
          </select>
        </div>
        <div>
          <label class="block font-semibold text-white mb-2">Jenis Kelamin:</label>
          <div class="flex items-center space-x-8">
            <label for="laki" class="flex items-center space-x-2 cursor-pointer">
              <input type="radio" id="laki" name="kelamin" value="Laki-laki" class="w-5 h-5 accent-purple-500 focus:outline-none" required>
              <span class="text-white">Laki-laki</span>
            </label>
            <label for="perempuan" class="flex items-center space-x-2 cursor-pointer">
              <input type="radio" id="perempuan" name="kelamin" value="Perempuan" class="w-5 h-5 accent-purple-500 focus:outline-none" required>
              <span class="text-white">Perempuan</span>
            </label>
          </div>
        </div>
        <div>
          <label class="block font-semibold text-white mb-2">Hobi (pilih minimal satu):</label>
          <div class="grid grid-cols-2 gap-3">
            <label class="flex items-center space-x-2 cursor-pointer">
              <input type="checkbox" name="hobi[]" value="Membaca" class="w-5 h-5 accent-purple-500 focus:outline-none">
              <span class="text-white">Membaca</span>
            </label>
            <label class="flex items-center space-x-2 cursor-pointer">
              <input type="checkbox" name="hobi[]" value="Olahraga" class="w-5 h-5 accent-purple-500 focus:outline-none">
              <span class="text-white">Olahraga</span>
            </label>
            <label class="flex items-center space-x-2 cursor-pointer">
              <input type="checkbox" name="hobi[]" value="Menulis" class="w-5 h-5 accent-purple-500 focus:outline-none">
              <span class="text-white">Menulis</span>
            </label>
            <label class="flex items-center space-x-2 cursor-pointer">
              <input type="checkbox" name="hobi[]" value="Menggambar" class="w-5 h-5 accent-purple-500 focus:outline-none">
              <span class="text-white">Menggambar</span>
            </label>
          </div>
        </div>
        <div>
          <label for="alamat" class="block font-semibold text-white mb-1">Alamat:</label>
          <textarea id="alamat" name="alamat" placeholder="Masukkan Alamat Anda" rows="4" required
            class="focus:ring-0 focus:ring-offset-0 focus:outline-none border-b border-purple-500 bg-transparent p-2 text-white text-lg w-full placeholder-gray-300"></textarea>
        </div>
        <div class="text-end">
          <button type="submit"
            class="px-6 py-3 bg-purple-600 hover:bg-purple-700 transition rounded-xl font-bold text-white shadow-md">
            Submit
          </button>
        </div>
      </form>
    </div>
  </div>

  <?php
  $file = 'biodata.json';

  $jsonData = file_get_contents($file);
  $data = json_decode($jsonData, true) ?? [];
  if (isset($_GET['search']) && !empty(trim($_GET['search']))) {
    $keyword = strtolower(trim($_GET['search']));
    $filtered = [];

    foreach ($data as $mhs) {
      if (
        strpos(strtolower($mhs['nama']), $keyword) !== false ||
        strpos(strtolower($mhs['nim']), $keyword) !== false ||
        strpos(strtolower($mhs['prodi']), $keyword) !== false ||
        strpos(strtolower($mhs['kelamin']), $keyword) !== false ||
        strpos(strtolower($mhs['alamat']), $keyword) !== false
      ) {
        $filtered[] = $mhs;
        continue;
      }
      foreach ($mhs['hobi'] as $ho) {
        if (strpos(strtolower($ho), $keyword) !== false) {
          $filtered[] = $mhs;
          break;
        }
      }
    }
    $data = $filtered;
  }

  ?>


  <h1 class="text-white text-center text-3xl  mb-10 font-bold">Data Mahasiswa</h1>
  <div class="relative overflow-x-auto p-5 flex justify-center">
    <div class="">

      <form method="GET" action="" class="flex justify-center mb-5">
        <input type="text" name="search" placeholder="Cari Mahasiswa..."
          value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>"
          class="p-2 w-full text-white rounded border border-purple-500 text-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
        <button type="submit"
          class="ml-2 px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg">Cari</button>
      </form>

      <table class="w-1/2 text-sm text-left rtl:text-right  text-white ">
        <thead class="text-xs text-center text-gray-700 uppercase text-white border border-purple-500">
          <tr>
            <th scope="col" class="px-6 py-3">
              Nama
            </th>
            <th scope="col" class="px-6 py-3">
              NIM
            </th>
            <th scope="col" class="px-6 py-3">
              Prodi
            </th>
            <th scope="col" class="px-6 py-3">
              Jenis Kelamin
            </th>
            <th scope="col" class="px-6 py-3">
              Hobi
            </th>
            <th scope="col" class="px-6 py-3">
              Alamat
            </th>
          </tr>
        </thead>
        <tbody class="p-5 text-center">
          <?php
          foreach ($data as $mhs) {
            echo  "<tr class='border border-purple-500 '>";
            echo "<td>{$mhs['nama']}</td>";
            echo "<td>{$mhs['nim']}</td>";
            echo "<td>{$mhs['prodi']}</td>";
            echo "<td>{$mhs['kelamin']}</td>";
            echo "<td>";
            foreach ($mhs['hobi'] as $ho) {
              echo "$ho<br>";
            }
            echo "</td>";
            echo "<td>{$mhs['alamat']}</td>";

            echo  "</tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>




</body>

</html>