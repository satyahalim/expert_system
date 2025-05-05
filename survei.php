<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kuesioner Somatotype</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap');
    
    :root {
      --primary: #6C63FF;
      --secondary: #FF6584;
      --accent: #43CBFF;
      --dark: #2A2A3C;
      --light: #F8FAFC;
      --success: #01E08F;
    }
    
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    
    html, body {
      height: 100%;
      margin: 0;
    }
    
    body {
      font-family: 'Outfit', sans-serif;
      background-color: var(--light);
      color: var(--dark);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      overflow-x: hidden;
      padding: 0;
    }
    
    .container {
      display: flex;
      min-height: 100vh;
      width: 100%;
    }
    
    .sidebar {
      width: 30%;
      background-color: var(--primary);
      display: flex;
      flex-direction: column;
      padding: 40px;
      position: relative;
      overflow: hidden;
      color: white;
    }
    
    .sidebar::before {
      content: "";
      position: absolute;
      width: 200%;
      height: 200%;
      background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='rgba(255,255,255,0.05)' fill-rule='evenodd'/%3E%3C/svg%3E");
      top: -50%;
      left: -50%;
      opacity: 0.4;
      z-index: 0;
    }
    
    .logo {
      font-size: 28px;
      font-weight: 800;
      margin-bottom: 60px;
      position: relative;
      z-index: 1;
      display: flex;
      align-items: center;
    }
    
    .logo::before {
      content: "";
      display: inline-block;
      width: 18px;
      height: 18px;
      background-color: var(--secondary);
      margin-right: 10px;
      border-radius: 4px;
      transform: rotate(45deg);
    }
    
    .sidebar-content {
      position: relative;
      z-index: 1;
      flex-grow: 1;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }
    
    .sidebar-top {
      margin-bottom: auto;
    }
    
    .sidebar h2 {
      font-size: 42px;
      font-weight: 700;
      line-height: 1.2;
      margin-bottom: 20px;
    }
    
    .tagline {
      font-size: 16px;
      font-weight: 400;
      opacity: 0.8;
      line-height: 1.6;
      margin-bottom: 40px;
    }
    
    .features {
      margin-top: 40px;
    }
    
    .feature {
      display: flex;
      align-items: center;
      margin-bottom: 20px;
    }
    
    .feature-icon {
      min-width: 40px;
      height: 40px;
      background-color: rgba(255, 255, 255, 0.1);
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-right: 15px;
    }
    
    .feature-text {
      font-size: 14px;
      font-weight: 500;
    }
    
    .main-content {
      width: 70%;
      padding: 40px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
    }
    
    .card {
      background: white;
      border-radius: 24px;
      box-shadow: 0 20px 50px rgba(42, 42, 60, 0.08);
      padding: 40px;
      width: 100%;
      max-width: 600px;
      position: relative;
      overflow: hidden;
    }
    
    .card::before {
      content: "";
      position: absolute;
      width: 300px;
      height: 300px;
      background: linear-gradient(to right, var(--accent), var(--primary));
      border-radius: 50%;
      top: -150px;
      right: -150px;
      opacity: 0.1;
    }
    
    .card::after {
      content: "";
      position: absolute;
      width: 200px;
      height: 200px;
      background: linear-gradient(to right, var(--secondary), var(--accent));
      border-radius: 50%;
      bottom: -100px;
      left: -100px;
      opacity: 0.1;
    }
    
    .header {
      margin-bottom: 30px;
      text-align: center;
    }
    
    .eyebrow {
      text-transform: uppercase;
      font-size: 12px;
      font-weight: 600;
      letter-spacing: 1px;
      color: var(--primary);
      margin-bottom: 10px;
    }
    
    .card-title {
      font-size: 28px;
      font-weight: 700;
      margin-bottom: 15px;
    }
    
    #progressTracker {
      width: 100%;
      text-align: center;
      color: var(--primary);
      font-weight: 600;
      font-size: 14px;
      margin-bottom: 20px;
    }
    
    #quizContainer {
      width: 100%;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      flex-grow: 1;
    }
    
    #quizForm {
      width: 100%;
      display: flex;
      flex-direction: column;
      align-items: center;
    }
    
    .pertanyaan {
      background: var(--light);
      border-radius: 16px;
      padding: 30px;
      margin: 0 auto 20px auto;
      min-height: 180px;
      box-shadow: 0 5px 15px rgba(42, 42, 60, 0.05);
      display: none;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      width: 100%;
      position: relative;
    }
    
    .pertanyaan.active {
      display: flex;
    }
    
    .pertanyaan p {
      font-size: 18px;
      font-weight: 600;
      margin-bottom: 20px;
      text-align: center;
      color: var(--dark);
    }
    
    .opsi {
      margin-top: 20px;
      display: flex;
      justify-content: center;
      gap: 40px;
    }
    
    .opsi label {
      display: inline-flex;
      align-items: center;
      padding: 10px 20px;
      background-color: #F1F5F9;
      border-radius: 12px;
      font-weight: 500;
      cursor: pointer;
      transition: all 0.3s ease;
    }
    
    .opsi label:hover {
      background-color: rgba(108, 99, 255, 0.1);
    }
    
    .opsi input {
      margin-right: 8px;
    }
    
    #controls {
      display: flex;
      justify-content: center;
      gap: 15px;
      margin-top: 30px;
      width: 100%;
    }
    
    button, input[type="submit"] {
      padding: 15px 30px;
      border: none;
      border-radius: 14px;
      cursor: pointer;
      font-size: 16px;
      font-weight: 600;
      background-color: var(--primary);
      color: white;
      transition: all 0.3s ease;
      min-width: 140px;
      text-align: center;
    }
    
    button:hover, input[type="submit"]:hover {
      background-color: #5A52E0;
      transform: translateY(-2px);
    }
    
    button:disabled {
      background-color: #CBD5E1;
      cursor: not-allowed;
      transform: none;
    }
    
    .helper-text {
      text-align: center;
      font-size: 13px;
      color: #94A3B8;
      margin-top: 15px;
    }
    
    .dots {
      position: absolute;
      bottom: 30px;
      right: 30px;
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 5px;
      opacity: 0.5;
    }
    
    .dot {
      width: 6px;
      height: 6px;
      border-radius: 50%;
      background-color: white;
    }
    
    @media (max-width: 1024px) {
      .container {
        flex-direction: column;
      }
      
      .sidebar {
        width: 100%;
        padding: 30px;
        min-height: 300px;
      }
      
      .main-content {
        width: 100%;
        padding: 30px;
      }
      
      .sidebar h2 {
        font-size: 32px;
      }
      
      .features {
        display: none;
      }
    }
    
    @media (max-width: 640px) {
      .sidebar {
        min-height: 250px;
      }
      
      .logo {
        margin-bottom: 30px;
      }
      
      .card {
        padding: 30px 20px;
      }
      
      .card-title {
        font-size: 24px;
      }
      
      .opsi {
        flex-direction: column;
        gap: 15px;
      }
      
      .opsi label {
        width: 100%;
      }
    }
  </style>
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
      <div class="card">
        <header class="header">
          <div class="eyebrow">Sistem Pakar</div>
          <h1 class="card-title">Kuesioner Penentuan Somatotype</h1>
          <div id="progressTracker">Pertanyaan 1 dari 18</div>
        </header>
        
        <div id="quizContainer">
          <form action="proses.php" method="post" id="quizForm">
            <div class="pertanyaan" data-index="0">
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
              <p>18. Apakah Anda sulit tetap ramping meskipun rutin ber olahraga?</p>
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