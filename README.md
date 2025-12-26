# Smart Attendance System — Reverse QR Verification

A modern, secure, and efficient attendance solution built with **Laravel**.  
Instead of lecturers generating a QR code, this system introduces a **reverse QR workflow**:

- **Students generate a unique QR code** from their device.
- **Lecturers scan the QR code** using their own device in class.
- Attendance is verified instantly and securely.

This approach reduces abuse, prevents proxy attendance, and ensures that only the student physically present in class can validate attendance.

---

## Features

- Reverse QR attendance validation  
- Real-time verification workflow  
- Secure token-based QR generation  
- Role-based access (Student / Lecturer)  
- Built on Laravel for scalability and maintainability  

---

## Installation & Setup

Follow the steps below to install and run the project on your local environment.

---

### 1. Open the project folder and launch a terminal

Navigate to the project directory and open a terminal window inside it. Or open a terminal and change its current directory to the project folder directory from the terminal.

---

### 2. Install project dependencies

Run the following commands:

```bash
npm install
composer install
```

### 3. Configure the environment file
```cp .env.example .env
php artisan key:generate
php artisan view:cache
```
### 4. Start the application

Run the following commands in two separate terminal windows (simultaneously):
```
Terminal 1 — Start Vite (frontend)
npm run dev
```

Terminal 2 — Start Laravel server (backend)
```
php artisan serve


Once both processes are running, the application will be accessible in your browser.
```
