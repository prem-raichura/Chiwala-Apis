# ☕ Chaiwala App – Core PHP REST APIs

This repository contains the backend **REST APIs built using Core PHP** for the **Chaiwala mobile application**.  
The APIs manage users, customers, products, sales, daily requirements, and profile data using a **MySQL database**.

---

## 🚀 Features

- User authentication & management  
- Customer management  
- Product management  
- Sales and order handling  
- Daily requirement tracking  
- Profile fetch & update APIs  
- RESTful API architecture  
- JSON-based request & response  
- Lightweight Core PHP backend  

---

## 🛠️ Tech Stack

- **Backend:** Core PHP  
- **Database:** MySQL  
- **API Type:** REST  
- **Server:** Apache (XAMPP / WAMP / LAMP)  

---

## 📂 Project Structure

```
chiwala_apis/
│
├── user.zip
├── customer.zip
├── product.zip
├── sales.zip
├── daily_req.zip
├── get_profile.zip
│
├── id19705969_chiwala.sql
└── README.md
```

---

## ⚙️ Installation & Setup

### 1️⃣ Clone Repository
```bash
git clone https://github.com/prem-raichura/chiwala-apis.git
```

### 2️⃣ Extract API Files
Extract all ZIP files into:
```
htdocs/chiwala/
```

### 3️⃣ Database Setup
1. Open **phpMyAdmin**
2. Create a database (e.g. `chiwala`)
3. Import:
```
id19705969_chiwala.sql
```

---

## 🔐 Database Configuration

Update database credentials inside API files:

```php
$host = "localhost";
$user = "root";
$password = "";
$database = "chiwala";
```

---

## 🔗 API Usage

- Request & response format: **JSON**
- Method: **POST / GET**

### Example Response
```json
{
  "status": true,
  "message": "Success",
  "data": {}
}
```

---

## 📦 API Modules

- **User APIs:** Login, registration, authentication  
- **Customer APIs:** Add, update, fetch customers  
- **Product APIs:** Product CRUD  
- **Sales APIs:** Sales entry & history  
- **Daily Requirement APIs:** Inventory tracking  
- **Profile APIs:** Get & update profile  

---

## 🔒 Security Notes

- Basic input validation
- Can be enhanced with:
  - JWT authentication
  - Prepared statements
  - HTTPS

---

## 🎯 Future Enhancements

- JWT-based authentication
- Role-based access
- Admin dashboard
- Swagger API documentation

---

## 🧑‍💻 Developed By

[**Prem Raichura**](https://portfolio-prem-raichura.vercel.app/)
* **GitHub:** [prem-raichura](https://github.com/prem-raichura)
* **LinkedIn:** [prem-raichura](https://www.linkedin.com/in/prem-raichura/)
