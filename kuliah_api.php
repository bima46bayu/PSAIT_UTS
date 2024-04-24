<?php
include 'koneksi.php';

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'),true);

switch ($method) {
  case 'GET':
    $nim = isset($_GET['nim']) ? $_GET['nim'] : null;
    if ($nim){
      $sql = "SELECT * FROM view_nilai_mahasiswa WHERE nim = '$nim'";
    } else {
      $sql = "SELECT * FROM view_nilai_mahasiswa";
    }
    break;
  // case 'POST':
  //   $nim = $input['nim'];
  //   $kode_mk = $input['kode_mk'];
  //   $nilai = $input['nilai'];
  //   $sql = "UPDATE perkuliahan SET nilai = '$nilai' WHERE nim = '$nim' AND kode_mk = '$kode_mk'";
  //   break;
  case 'POST':
    $nim = $input['nim'];
    $kode_mk = $input['kode_mk'];
    $nilai = $input['nilai'];
    if ($nim) {
        $sql = "INSERT INTO perkuliahan (nim, kode_mk, nilai) VALUES ('$nim', '$kode_mk', '$nilai')";
    } else {
        echo json_encode(['error' => 'NIM tidak ditemukan']);
        exit;
    }
    break;
  case 'PUT':
    $nim = isset($_GET['nim']) ? $_GET['nim'] : null;
    $kode_mk = isset($_GET['kode_mk']) ? $_GET['kode_mk'] : null;
    $nilai = $input['nilai'];
    if ($nim && $kode_mk) {
        $sql = "UPDATE perkuliahan SET nilai = '$nilai' WHERE nim = '$nim' AND kode_mk = '$kode_mk'";
    } else {
        echo json_encode(['error' => 'NIM atau kode_mk tidak ditemukan']);
        exit;
    }
    break;
case 'DELETE':
    $nim = isset($_GET['nim']) ? $_GET['nim'] : null;
    $kode_mk = isset($_GET['kode_mk']) ? $_GET['kode_mk'] : null;
    if ($nim && $kode_mk) {
        $sql = "DELETE FROM perkuliahan WHERE nim = '$nim' AND kode_mk = '$kode_mk'";
    } else {
        echo json_encode(['error' => 'NIM atau kode_mk tidak ditemukan']);
        exit;
    }
    break;
}

$result = $koneksi->query($sql);

if ($method == 'GET') {
  if (!$nim) echo '[';
  for ($i=0 ; $i<mysqli_num_rows($result) ; $i++) {
    echo ($i>0?',':'').json_encode(mysqli_fetch_object($result));
  }
  if (!$nim) echo ']';
} elseif ($method == 'POST') {
  echo json_encode($result);
} else {
  // Kode untuk metode lainnya
}
?>