# 🏃‍♂️ FUFUFAFA - Sistem Pakar Somatotype

![Version](https://img.shields.io/badge/version-2.0.0-blue.svg)
![PHP](https://img.shields.io/badge/PHP-7.4%2B-777BB4.svg)
![MySQL](https://img.shields.io/badge/MySQL-5.7%2B-4479A1.svg)
![License](https://img.shields.io/badge/license-Educational-green.svg)

**Complete Expert System for Body Type Analysis with Professional Styling**

A comprehensive web-based expert system that determines somatotype (body type) using certainty factor methodology. Features modern design, complete admin panel, and enhanced image display.

![Demo Screenshot](https://via.placeholder.com/800x400/6C63FF/FFFFFF?text=FUFUFAFA+Somatotype+Expert+System)

## ✨ **Key Features**

| Feature | Description |
|---------|-------------|
| 🎯 **Expert System** | Certainty Factor-based diagnosis with 18 diagnostic questions |
| 🎨 **Modern Design** | Professional external CSS styling with responsive layout |
| 🖼️ **Visual Results** | Enhanced image display for each somatotype with fallback placeholders |
| 🔧 **Admin Panel** | Complete database management system with CRUD operations |
| 📱 **Responsive** | Works perfectly on desktop, tablet, and mobile devices |
| 🍽️ **Diet Recommendations** | Personalized nutrition advice for each body type |
| 📊 **Progress Tracking** | Visual confidence percentages and animated progress bars |
| 🛡️ **Security** | Input sanitization, SQL injection protection, session management |

## 🏗️ **Complete File Structure**

```
📦 expertsys/
├── 📄 style.css                   # External CSS (Professional styling)
├── 🏠 index.php                   # Homepage with side-by-side layout
├── 📋 survei.php                  # Interactive 18-question survey
├── ⚙️ proses.php                  # CF calculation & processing logic
├── 📊 hasil.php                   # Enhanced results with image display
├── 🔗 koneksi.php                 # Secure database connection
├── 🔐 admin_login.php             # Admin authentication
├── 📈 admin_dashboard.php         # Admin overview & statistics
├── 🔍 admin_gejala.php            # Symptoms management (CRUD)
├── 🎯 admin_kondisi.php           # Conditions management (CRUD)
├── 🧠 admin_knowledge.php         # Knowledge base & CF management
├── 💾 expertsys.sql               # Database schema & sample data
├── 🖼️ create_sample_images.html   # Image generator tool
├── 📁 uploads/                    # Image storage directory
│   ├── 🏃‍♂️ ectomorph.jpg
│   ├── 💪 mesomorph.jpg
│   └── 🤗 endomorph.jpg
└── 📖 README.md                   # This documentation
```

## 🚀 **Quick Setup (5 Minutes)**

### **Step 1: Database Setup**
```bash
# Create database
mysql -u root -p
CREATE DATABASE expertsys;
exit

# Import schema and data
mysql -u root -p expertsys < expertsys.sql
```

### **Step 2: Configure Database**
Edit `koneksi.php`:
```php
$host     = "localhost";
$user     = "root";           # Your MySQL username
$password = "";               # Your MySQL password
$database = "expertsys";
```

### **Step 3: Upload Files**
- Copy all PHP and CSS files to your web directory
- Create `uploads/` folder: `mkdir uploads && chmod 755 uploads`

### **Step 4: Setup Images**
**Option A: Quick Sample Images**
1. Open `create_sample_images.html` in browser
2. Download generated images
3. Save as `uploads/ectomorph.jpg`, `uploads/mesomorph.jpg`, `uploads/endomorph.jpg`

**Option B: Professional Images**
- Use stock photos from [Unsplash](https://unsplash.com/s/photos/body-types)
- Resize to 400x400px for optimal performance
- Save in `uploads/` folder with exact filenames

### **Step 5: Access System**
- 🌐 **User Interface**: `http://your-domain/index.php`
- 🔧 **Admin Panel**: `http://your-domain/admin_login.php`
  - 👤 Username: `admin`
  - 🔐 Password: `admin123`

## 🎨 **Design Highlights**

### **Professional Styling System**
```css
/* Modern CSS Variables */
:root {
  --primary: #6C63FF;    /* Purple - Ectomorph */
  --secondary: #FF6584;  /* Pink - Mesomorph */
  --accent: #43CBFF;     /* Cyan - Endomorph */
  --dark: #2A2A3C;       /* Text */
  --light: #F8FAFC;      /* Background */
}
```

### **Layout Features**
- ✅ **Side-by-side Layout**: Purple sidebar + white content area
- ✅ **External CSS**: No inline styles, maintainable code
- ✅ **Responsive Grid**: Works on all screen sizes
- ✅ **Modern Typography**: Google Fonts (Outfit family)
- ✅ **Smooth Animations**: Hover effects and transitions

### **Visual Somatotype System**
| Type | Color | Icon | Characteristics |
|------|-------|------|----------------|
| 🏃‍♂️ **Ectomorph** | Purple `#6C63FF` | Runner | Thin, fast metabolism |
| 💪 **Mesomorph** | Pink `#FF6584` | Strong | Athletic, muscular |
| 🤗 **Endomorph** | Cyan `#43CBFF` | Rounded | Fuller, slower metabolism |

## 🧠 **Expert System Logic**

### **Certainty Factor Methodology**
```
CF(combination) = CF1 + CF2 × (1 - CF1)
```

**Example Calculation:**
```
Symptom 1: CF = 0.8 (80% confidence)
Symptom 2: CF = 0.7 (70% confidence)
Combined: 0.8 + 0.7 × (1 - 0.8) = 0.94 (94% confidence)
```

### **Confidence Interpretation**
| Range | Level | Color | Meaning |
|-------|-------|-------|---------|
| 0.8 - 1.0 | High | 🟢 Green | Strong diagnosis |
| 0.4 - 0.7 | Medium | 🟡 Yellow | Moderate indication |
| 0.1 - 0.3 | Low | 🔴 Red | Weak correlation |

### **Diagnostic Questions (18 Total)**
```
G001: Apakah tubuh Anda cenderung kurus dan tinggi?
G002: Apakah lemak tubuh Anda rendah?
G003: Apakah Anda kesulitan menambah massa otot?
... (15 more questions)
```

## 🔧 **Admin Panel Features**

### **Complete Database Management**
```
📊 Dashboard
├── Real-time statistics (symptoms, conditions, rules)
├── System overview and health monitoring
└── Quick navigation to all modules

🔍 Kelola Gejala (Symptoms Management)
├── Add new diagnostic questions
├── Edit existing symptoms
├── Delete unused symptoms (with safety checks)
└── Bulk operations support

🎯 Kelola Kondisi (Conditions Management)  
├── Manage somatotype definitions
├── Edit detailed descriptions
├── Configure visual representations
└── Import/export capabilities

🧠 Knowledge Base Management
├── Rules Tab: Configure CF values and relationships
├── Matrix Tab: Visual overview of all rules
├── Validation: Prevent conflicting rules
└── Analytics: Rule effectiveness tracking
```

### **Security & Safety**
- 🛡️ **Input Sanitization**: All user inputs cleaned
- 🔒 **SQL Injection Protection**: Parameterized queries
- ⚠️ **Referential Integrity**: Prevents orphaned records
- 🔐 **Session Management**: Secure admin authentication
- ❓ **Confirmation Dialogs**: Prevent accidental deletions

## 🍽️ **Personalized Diet System**

### **Ectomorph Recommendations**
```
🎯 Goal: Weight & Muscle Gain
📊 Macros: 50% Carbs, 25% Protein, 25% Fat
🍽️ Strategy: 5-6 meals/day, high calorie density
📈 Calorie Surplus: +10-20% above TDEE

Sample Day:
├── Breakfast: Oatmeal + milk + banana + peanut butter
├── Lunch: Rice + beef + vegetables  
├── Dinner: Pasta + meat sauce + cheese
└── Snacks: Protein smoothies + granola bars
```

### **Mesomorph Recommendations**
```
🎯 Goal: Muscle Maintenance & Definition
📊 Macros: 40% Carbs, 30% Protein, 30% Fat
🍽️ Strategy: 3 meals + 2 snacks, balanced approach
📈 Calorie Balance: Maintenance level

Sample Day:
├── Breakfast: Scrambled eggs + whole grain toast + fruit
├── Lunch: Grilled chicken + quinoa + steamed vegetables
├── Dinner: Lean steak + sweet potato + broccoli  
└── Snacks: Greek yogurt + nuts
```

### **Endomorph Recommendations**
```
🎯 Goal: Fat Loss & Weight Management
📊 Macros: 25% Carbs, 40% Protein, 35% Fat
🍽️ Strategy: Lower carb, higher fiber, portion control
📈 Calorie Deficit: -10-20% below TDEE

Sample Day:
├── Breakfast: Egg whites + whole grain toast + green tea
├── Lunch: Grilled fish + vegetables + small portion brown rice
├── Dinner: Vegetable soup + tofu/tempeh
└── Snacks: Nuts + seeds
```

## 📱 **Responsive Design System**

### **Breakpoint Strategy**
```css
/* Desktop First Approach */
@media (max-width: 1024px) { /* Tablet */ }
@media (max-width: 640px)  { /* Mobile */ }
```

### **Device Optimizations**
| Device | Layout | Optimizations |
|--------|--------|---------------|
| 🖥️ **Desktop** | Side-by-side | Full feature set, hover effects |
| 📱 **Tablet** | Stacked | Touch-friendly, simplified nav |
| 📱 **Mobile** | Single column | Thumb navigation, readable text |

## 🛠️ **Customization Guide**

### **Adding New Somatotypes**
1. **Database**: Add new condition in admin panel
2. **Images**: Add corresponding image to `uploads/` folder  
3. **CSS**: Add new color scheme in `style.css`
4. **Logic**: Update processing in `proses.php`

### **Modifying Questions**
```php
// Example: Adding question G019
INSERT INTO gejala (kode_gejala, nama_gejala) 
VALUES ('G019', 'Your new diagnostic question?');

// Add corresponding CF rules in knowledge base
INSERT INTO know_base (id_gejala, id_kondisi, value_cf)
VALUES (19, 1, 0.7); // Link to Ectomorph with 70% confidence
```

### **Changing Appearance**
```css
/* Custom color scheme */
:root {
  --primary: #YOUR_COLOR;     /* Primary somatotype */
  --secondary: #YOUR_COLOR;   /* Secondary somatotype */
  --accent: #YOUR_COLOR;      /* Accent somatotype */
}
```

## 🚨 **Troubleshooting Guide**

### **Database Issues**
```bash
# Check MySQL service
sudo systemctl status mysql

# Verify database exists
mysql -u root -p -e "SHOW DATABASES;"

# Test connection
mysql -u root -p expertsys -e "SHOW TABLES;"
```

### **Image Loading Problems**
```bash
# Check folder permissions
ls -la uploads/
# Should show: drwxr-xr-x (755)

# Check file permissions  
ls -la uploads/*.jpg
# Should show: -rw-r--r-- (644)

# Fix permissions if needed
chmod 755 uploads/
chmod 644 uploads/*.jpg
```

### **Admin Access Issues**
```
❌ "Username atau password salah"
✅ Use exactly: admin / admin123

❌ "Page not found" 
✅ Check admin_login.php exists in web directory

❌ Session problems
✅ Verify PHP session.save_path is writable
```

## 📊 **System Requirements**

### **Minimum Requirements**
| Component | Minimum | Recommended |
|-----------|---------|-------------|
| **PHP** | 7.4 | 8.0+ |
| **MySQL** | 5.7 | 8.0+ |
| **Memory** | 128MB | 256MB+ |
| **Storage** | 50MB | 100MB+ |
| **Web Server** | Apache 2.4 | Apache/Nginx |

### **Browser Support**
- ✅ Chrome 90+
- ✅ Firefox 88+  
- ✅ Safari 14+
- ✅ Edge 90+
- ❌ Internet Explorer (not supported)

## 🔄 **Advanced Features**

### **API Endpoints (Future)**
```php
// Potential REST API structure
GET  /api/questions      # Get all diagnostic questions
POST /api/diagnose       # Submit answers, get results  
GET  /api/somatotypes    # Get all body types
POST /api/admin/login    # Admin authentication
```

### **Analytics Integration**
```javascript
// Google Analytics example
gtag('event', 'diagnosis_completed', {
  'somatotype': result,
  'confidence': percentage,
  'questions_answered': count
});
```

## 📞 **Support & Documentation**

### **Quick Help**
| Issue | Solution |
|-------|----------|
| 🔧 Setup Problems | Follow step-by-step setup guide |
| 🖼️ Image Issues | Use create_sample_images.html |
| 🔐 Admin Access | Default: admin/admin123 |
| 💾 Database Errors | Check koneksi.php configuration |
| 🎨 Style Issues | Verify style.css is loaded |

### **Development Resources**
- 📚 **Certainty Factor Theory**: [Academic Papers](https://scholar.google.com/scholar?q=certainty+factor+expert+systems)
- 🏃‍♂️ **Somatotype Research**: [Body Type Classification](https://en.wikipedia.org/wiki/Somatotype_and_constitutional_psychology)
- 🎨 **Design Inspiration**: [Modern Web Design](https://dribbble.com/tags/medical_app)

## 🎯 **Performance Optimization**

### **Database Optimization**
```sql
-- Add indexes for better performance
CREATE INDEX idx_gejala_kode ON gejala(kode_gejala);
CREATE INDEX idx_know_base_lookup ON know_base(id_gejala, id_kondisi);
```

### **Image Optimization**
```bash
# Compress images for web
convert input.jpg -quality 85 -resize 400x400^ output.jpg
```

### **Caching Strategy**
```php
// Example: Cache CF calculations
$cache_key = 'cf_' . md5(serialize($selected_symptoms));
if (!($result = cache_get($cache_key))) {
    $result = calculate_certainty_factors($symptoms);
    cache_set($cache_key, $result, 3600); // 1 hour
}
```

## 📄 **License & Legal**

### **Educational Use License**
```
This software is created for educational and research purposes.
Not intended for commercial medical diagnosis.
Always consult healthcare professionals for medical advice.
```

### **Data Privacy**
- ✅ No personal data stored
- ✅ Session-based results only
- ✅ Admin data encrypted
- ✅ GDPR considerations included

### **Medical Disclaimer**
```
⚠️  IMPORTANT MEDICAL DISCLAIMER
This system is for educational purposes only and should not replace 
professional medical advice. Always consult qualified healthcare 
providers for medical decisions.
```

---

## 🎉 **Getting Started**

### **For Users**
1. 🏠 Visit homepage (`index.php`)
2. 📋 Complete 18-question survey
3. 🖼️ View results with visual representation
4. 🍽️ Get personalized diet recommendations

### **For Administrators**  
1. 🔐 Login to admin panel (`admin_login.php`)
2. 📊 View system statistics
3. 🔧 Manage questions, conditions, and rules
4. 📈 Monitor system performance

### **For Developers**
1. 📚 Review this documentation
2. 🔍 Examine code structure
3. 🛠️ Customize for your needs
4. 🚀 Deploy to production

---

**🚀 Ready to discover your somatotype? Start exploring your body type today!**

---

**Created with ❤️ by FUFUFAFA Development Team**  
*Version 2.0.0 - Complete Professional Redesign*  
*Last Updated: 2025*