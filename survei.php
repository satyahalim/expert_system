<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kuesioner Somatotype</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <section class="sidebar">
      <div class="logo">FUFUFAFA</div>
      
      <div class="sidebar-content">
        <div class="sidebar-top">
          <h2>Temukan Tipe Tubuh Idealmu</h2>
          <p class="tagline">Sistem pakar yang membantu mengidentifikasi tipe tubuh berdasarkan karakteristik genetik dan fisik Anda.</p>
        </div>
        
        <div class="features">
          <div class="feature">
            <div class="feature-icon">✓</div>
            <div class="feature-text">Analisis berbasis data antropometrik</div>
          </div>
          <div class="feature">
            <div class="feature-icon">✓</div>
            <div class="feature-text">Rekomendasi latihan yang dipersonalisasi</div>
          </div>
          <div class="feature">
            <div class="feature-icon">✓</div>
            <div class="feature-text">Panduan nutrisi berdasarkan metabolisme</div>
          </div>
        </div>
      </div>
      
      <div class="dots">
        <div class="dot"></div>
        <div class="dot"></div>
        <div class="dot"></div>
        <div class="dot"></div>
        <div class="dot"></div>
        <div class="dot"></div>
        <div class="dot"></div>
        <div class="dot"></div>
        <div class="dot"></div>
      </div>
    </section>
    
    <section class="main-content">
      <div class="card small">
        <header class="header">
          <div class="eyebrow">Sistem Pakar</div>
          <h1 class="card-title">Kuesioner Penentuan Somatotype</h1>
          <div id="progressTracker">Pertanyaan 1 dari 18</div>
        </header>
        
        <div id="quizContainer">
          <form action="proses.php" method="post" id="quizForm">
            <div class="pertanyaan active" data-index="0">
              <p>1. Apakah tubuh Anda cenderung kurus dan tinggi?</p>
              <div class="opsi">
                <label><input type="radio" name="G001" value="ya" required> Ya</label>
                <label><input type="radio" name="G001" value="tidak"> Tidak</label>
              </div>
            </div>
            <div class="pertanyaan" data-index="1">
              <p>2. Apakah lemak tubuh Anda rendah (tidak mudah menyimpan lemak)?</p>
              <div class="opsi">
                <label><input type="radio" name="G002" value="ya" required> Ya</label>
                <label><input type="radio" name="G002" value="tidak"> Tidak</label>
              </div>
            </div>
            <div class="pertanyaan" data-index="2">
              <p>3. Apakah Anda kesulitan menambah massa otot?</p>
              <div class="opsi">
                <label><input type="radio" name="G003" value="ya" required> Ya</label>
                <label><input type="radio" name="G003" value="tidak"> Tidak</label>
              </div>
            </div>
            <div class="pertanyaan" data-index="3">
              <p>4. Apakah Anda memiliki bahu lebar dan pinggang ramping?</p>
              <div class="opsi">
                <label><input type="radio" name="G004" value="ya" required> Ya</label>
                <label><input type="radio" name="G004" value="tidak"> Tidak</label>
              </div>
            </div>
            <div class="pertanyaan" data-index="4">
              <p>5. Apakah otot Anda mudah berkembang saat berolahraga?</p>
              <div class="opsi">
                <label><input type="radio" name="G005" value="ya" required> Ya</label>
                <label><input type="radio" name="G005" value="tidak"> Tidak</label>
              </div>
            </div>
            <div class="pertanyaan" data-index="5">
              <p>6. Apakah Anda mudah naik dan turun berat badan?</p>
              <div class="opsi">
                <label><input type="radio" name="G006" value="ya" required> Ya</label>
                <label><input type="radio" name="G006" value="tidak"> Tidak</label>
              </div>
            </div>
            <div class="pertanyaan" data-index="6">
              <p>7. Apakah bentuk tubuh Anda bulat dan mudah menyimpan lemak?</p>
              <div class="opsi">
                <label><input type="radio" name="G007" value="ya" required> Ya</label>
                <label><input type="radio" name="G007" value="tidak"> Tidak</label>
              </div>
            </div>
            <div class="pertanyaan" data-index="7">
              <p>8. Apakah metabolisme tubuh Anda lambat?</p>
              <div class="opsi">
                <label><input type="radio" name="G008" value="ya" required> Ya</label>
                <label><input type="radio" name="G008" value="tidak"> Tidak</label>
              </div>
            </div>
            <div class="pertanyaan" data-index="8">
              <p>9. Apakah Anda sulit menurunkan berat badan meskipun sudah berusaha?</p>
              <div class="opsi">
                <label><input type="radio" name="G009" value="ya" required> Ya</label>
                <label><input type="radio" name="G009" value="tidak"> Tidak</label>
              </div>
            </div>
            <div class="pertanyaan" data-index="9">
              <p>10. Apakah tubuh Anda terlihat tinggi dan ramping?</p>
              <div class="opsi">
                <label><input type="radio" name="G010" value="ya" required> Ya</label>
                <label><input type="radio" name="G010" value="tidak"> Tidak</label>
              </div>
            </div>
            <div class="pertanyaan" data-index="10">
              <p>11. Apakah Anda memiliki tulang kecil dan pergelangan tangan kecil?</p>
              <div class="opsi">
                <label><input type="radio" name="G011" value="ya" required> Ya</label>
                <label><input type="radio" name="G011" value="tidak"> Tidak</label>
              </div>
            </div>
            <div class="pertanyaan" data-index="11">
              <p>12. Apakah Anda cepat merasa lapar dan sering makan?</p>
              <div class="opsi">
                <label><input type="radio" name="G012" value="ya" required> Ya</label>
                <label><input type="radio" name="G012" value="tidak"> Tidak</label>
              </div>
            </div>
            <div class="pertanyaan" data-index="12">
              <p>13. Apakah Anda memiliki lemak perut yang sulit hilang?</p>
              <div class="opsi">
                <label><input type="radio" name="G013" value="ya" required> Ya</label>
                <label><input type="radio" name="G013" value="tidak"> Tidak</label>
              </div>
            </div>
            <div class="pertanyaan" data-index="13">
              <p>14. Apakah Anda memiliki massa otot alami tanpa latihan berat?</p>
              <div class="opsi">
                <label><input type="radio" name="G014" value="ya" required> Ya</label>
                <label><input type="radio" name="G014" value="tidak"> Tidak</label>
              </div>
            </div>
            <div class="pertanyaan" data-index="14">
              <p>15. Apakah tubuh Anda tampak proporsional dan seimbang?</p>
              <div class="opsi">
                <label><input type="radio" name="G015" value="ya" required> Ya</label>
                <label><input type="radio" name="G015" value="tidak"> Tidak</label>
              </div>
            </div>
            <div class="pertanyaan" data-index="15">
              <p>16. Apakah berat badan Anda cenderung stabil dalam jangka panjang?</p>
              <div class="opsi">
                <label><input type="radio" name="G016" value="ya" required> Ya</label>
                <label><input type="radio" name="G016" value="tidak"> Tidak</label>
              </div>
            </div>
            <div class="pertanyaan" data-index="16">
              <p>17. Apakah Anda memiliki paha dan pinggul yang besar?</p>
              <div class="opsi">
                <label><input type="radio" name="G017" value="ya" required> Ya</label>
                <label><input type="radio" name="G017" value="tidak"> Tidak</label>
              </div>
            </div>
            <div class="pertanyaan" data-index="17">
              <p>18. Apakah Anda sulit tetap ramping meskipun rutin berolahraga?</p>
              <div class="opsi">
                <label><input type="radio" name="G018" value="ya" required> Ya</label>
                <label><input type="radio" name="G018" value="tidak"> Tidak</label>
              </div>
            </div>
            <div id="controls">
              <button type="button" id="prevBtn" style="display:none;">Sebelumnya</button>
              <button type="button" id="nextBtn" disabled>Selanjutnya</button>
            </div>
            <div class="helper-text">Jawab semua pertanyaan untuk hasil terbaik</div>
          </form>
        </div>
      </div>
    </section>
  </div>
  
  <script>
    const pertanyaans = document.querySelectorAll('.pertanyaan');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const progressTracker = document.getElementById('progressTracker');
    let current = 0;

    // Hide all questions except the first one
    pertanyaans.forEach((q, i) => {
      q.style.display = i === 0 ? 'flex' : 'none';
    });

    function showQuestion(index) {
      // Hide all questions
      pertanyaans.forEach(q => {
        q.style.display = 'none';
      });
      
      // Show only the current question
      pertanyaans[index].style.display = 'flex';
      
      // Update progress tracker
      progressTracker.textContent = `Pertanyaan ${index + 1} dari ${pertanyaans.length}`;
      
      // Update navigation buttons
      prevBtn.style.display = index === 0 ? 'none' : 'inline-block';
      nextBtn.textContent = index === pertanyaans.length - 1 ? 'Kirim Jawaban' : 'Selanjutnya';
      nextBtn.type = index === pertanyaans.length - 1 ? 'submit' : 'button';
      
      // Reset next button state
      nextBtn.disabled = true;
      
      // Check if current question is already answered
      const currentQ = pertanyaans[index];
      const inputs = currentQ.querySelectorAll('input[type="radio"]');
      const answered = Array.from(inputs).some(input => input.checked);
      if (answered) {
        nextBtn.disabled = false;
      }
    }

    // Add event listeners to all radio buttons
    document.querySelectorAll('.opsi input[type="radio"]').forEach(radio => {
      radio.addEventListener('change', function() {
        // Enable the next button when a radio is selected
        nextBtn.disabled = false;
      });
    });

    prevBtn.addEventListener('click', () => {
      if (current > 0) {
        current--;
        showQuestion(current);
      }
    });

    nextBtn.addEventListener('click', () => {
      if (current < pertanyaans.length - 1) {
        current++;
        showQuestion(current);
      }
    });

    // Start with the first question
    showQuestion(current);
  </script>
</body>
</html>