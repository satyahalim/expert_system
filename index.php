<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Selamat Datang di Sistem Pakar Somatotype</title>
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
    
    body {
      font-family: 'Outfit', sans-serif;
      background-color: var(--light);
      color: var(--dark);
      min-height: 100vh;
      display: flex;
      overflow-x: hidden;
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
      margin-bottom: 40px;
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
    
    .description {
      color: #64748B;
      font-size: 16px;
      line-height: 1.7;
      margin-bottom: 30px;
    }
    
    .somatotype-container {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 15px;
      margin-bottom: 40px;
    }
    
    .soma-type {
      background-color: #F1F5F9;
      border-radius: 16px;
      padding: 20px 15px;
      text-align: center;
      position: relative;
      overflow: hidden;
      transition: all 0.3s ease;
    }
    
    .soma-type:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 25px rgba(42, 42, 60, 0.1);
    }
    
    .soma-type.ecto:hover {
      background-color: rgba(108, 99, 255, 0.05);
    }
    
    .soma-type.meso:hover {
      background-color: rgba(255, 101, 132, 0.05);
    }
    
    .soma-type.endo:hover {
      background-color: rgba(67, 203, 255, 0.05);
    }
    
    .soma-icon {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      margin: 0 auto 15px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 700;
      font-size: 24px;
      position: relative;
    }
    
    .soma-icon::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      border-radius: 50%;
      opacity: 0.2;
      z-index: 0;
    }
    
    .ecto .soma-icon {
      color: var(--primary);
    }
    
    .ecto .soma-icon::before {
      background-color: var(--primary);
    }
    
    .meso .soma-icon {
      color: var(--secondary);
    }
    
    .meso .soma-icon::before {
      background-color: var(--secondary);
    }
    
    .endo .soma-icon {
      color: var(--accent);
    }
    
    .endo .soma-icon::before {
      background-color: var(--accent);
    }
    
    .soma-name {
      font-weight: 600;
      font-size: 16px;
      margin-bottom: 5px;
    }
    
    .soma-desc {
      font-size: 12px;
      color: #64748B;
    }
    
    .cta-button {
      display: block;
      width: 100%;
      padding: 18px;
      background-color: var(--primary);
      color: white;
      border: none;
      border-radius: 14px;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      text-align: center;
      text-decoration: none;
      transition: all 0.3s ease;
      position: relative;
      overflow: hidden;
    }
    
    .cta-button:hover {
      background-color: #5A52E0;
      transform: translateY(-2px);
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
      body {
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
      .somatotype-container {
        grid-template-columns: 1fr;
        gap: 10px;
      }
      
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
    }
  </style>
</head>
<body>
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
        <h1 class="card-title">Kenali Somatotype Anda</h1>
        <p class="description">Pahami keunikan tipe tubuh Anda dan temukan pendekatan fitness dan nutrisi yang paling efektif untuk mencapai tujuan kesehatan Anda.</p>
      </header>
      
      <div class="somatotype-container">
        <div class="soma-type ecto">
          <div class="soma-icon">E</div>
          <div class="soma-name">Ectomorph</div>
          <div class="soma-desc">Tubuh langsing, metabolisme cepat</div>
        </div>
        <div class="soma-type meso">
          <div class="soma-icon">M</div>
          <div class="soma-name">Mesomorph</div>
          <div class="soma-desc">Tubuh atletis, berotot natural</div>
        </div>
        <div class="soma-type endo">
          <div class="soma-icon">E</div>
          <div class="soma-name">Endomorph</div>
          <div class="soma-desc">Tubuh bulat, metabolisme lambat</div>
        </div>
      </div>
      
      <a href="survei.php" class="cta-button">Mulai Diagnosa Sekarang</a>
      <div class="helper-text">Hanya membutuhkan waktu 2-3 menit</div>
    </div>
  </section>
</body>
</html>