<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Kuesioner Somatotype</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 20px;
    }
    h2 {
      margin-bottom: 10px;
    }
    .pertanyaan {
      margin-bottom: 15px;
    }
    input[type="submit"] {
      margin-top: 20px;
      padding: 10px 20px;
    }
  </style>
</head>
<body>

  <h2>Kuesioner Penentuan Tipe Tubuh (Somatotype)</h2>

  <form action="proses.php" method="post">
    <div class="pertanyaan">
      <label><input type="checkbox" name="gejala[]" value="1"> Apakah tubuh Anda cenderung kurus dan tinggi?</label>
    </div>
    <div class="pertanyaan">
      <label><input type="checkbox" name="gejala[]" value="2"> Apakah lemak tubuh Anda rendah?</label>
    </div>
    <div class="pertanyaan">
      <label><input type="checkbox" name="gejala[]" value="3"> Apakah Anda kesulitan menambah massa otot?</label>
    </div>
    <div class="pertanyaan">
      <label><input type="checkbox" name="gejala[]" value="4"> Apakah Anda memiliki bahu lebar dan pinggang ramping?</label>
    </div>
    <div class="pertanyaan">
      <label><input type="checkbox" name="gejala[]" value="5"> Apakah otot Anda mudah berkembang saat berolahraga?</label>
    </div>
    <div class="pertanyaan">
      <label><input type="checkbox" name="gejala[]" value="6"> Apakah Anda mudah naik dan turun berat badan?</label>
    </div>
    <div class="pertanyaan">
      <label><input type="checkbox" name="gejala[]" value="7"> Apakah bentuk tubuh Anda bulat dan mudah menyimpan lemak?</label>
    </div>
    <div class="pertanyaan">
      <label><input type="checkbox" name="gejala[]" value="8"> Apakah metabolisme tubuh Anda lambat?</label>
    </div>
    <div class="pertanyaan">
      <label><input type="checkbox" name="gejala[]" value="9"> Apakah Anda sulit menurunkan berat badan meskipun sudah berusaha?</label>
    </div>
    <div class="pertanyaan">
      <label><input type="checkbox" name="gejala[]" value="10"> Apakah tubuh Anda terlihat tinggi dan ramping?</label>
    </div>
    <div class="pertanyaan">
      <label><input type="checkbox" name="gejala[]" value="11"> Apakah Anda memiliki tulang kecil dan pergelangan tangan kecil?</label>
    </div>
    <div class="pertanyaan">
      <label><input type="checkbox" name="gejala[]" value="12"> Apakah Anda cepat merasa lapar dan sering makan?</label>
    </div>
    <div class="pertanyaan">
      <label><input type="checkbox" name="gejala[]" value="13"> Apakah Anda memiliki lemak perut yang sulit hilang?</label>
    </div>
    <div class="pertanyaan">
      <label><input type="checkbox" name="gejala[]" value="14"> Apakah Anda memiliki massa otot alami tanpa latihan berat?</label>
    </div>
    <div class="pertanyaan">
      <label><input type="checkbox" name="gejala[]" value="15"> Apakah tubuh Anda tampak proporsional dan seimbang?</label>
    </div>
    <div class="pertanyaan">
      <label><input type="checkbox" name="gejala[]" value="16"> Apakah berat badan Anda cenderung stabil dalam jangka panjang?</label>
    </div>
    <div class="pertanyaan">
      <label><input type="checkbox" name="gejala[]" value="17"> Apakah Anda memiliki paha dan pinggul yang besar?</label>
    </div>
    <div class="pertanyaan">
      <label><input type="checkbox" name="gejala[]" value="18"> Apakah Anda sulit tetap ramping meskipun rutin berolahraga?</label>
    </div>

    <input type="submit" value="Kirim Jawaban">
  </form>

</body>
</html>
