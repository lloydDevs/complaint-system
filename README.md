# 🛡️ Anonymous Support & Complaint System

An industrial-grade, privacy-first portal designed for secure communication between citizens and government agencies. Built specifically for high-stakes reporting where **sender anonymity** is the top priority.

![Theme](https://img.shields.io/badge/Theme-Emerald_Green-emerald)
![Laravel](https://img.shields.io/badge/Laravel-12.x-red)
![PHP](https://img.shields.io/badge/PHP-8.4-blue)

## 🌟 Key Features

### 1. The Identity Shield (Core)
The system's backbone. It ensures that when a complaint is filed, the user's personal profile and name are **completely decoupled** from the report. Admins receive the complaint via a unique **Case Reference Number** (e.g., `#CN-882X`), keeping your identity 100% invisible.

### 2. Intelligence & Analytics
*   **Visual Data Analytics:** Interactive charts and graphs that visualize complaint trends and agency performance.
*   **Global Discovery:** A powerful search engine to find records by keywords or reference codes.
*   **Dynamic Filtering:** Sift through data by Status (Pending/Resolved), Date, or Department.

### 3. Industrial Design
*   **Adaptive Emerald Theme:** A minimalist "Green" aesthetic optimized for both high-glare office environments and late-night field use (Dark/Light mode support).
*   **Smart Agency Routing:** Specifically configured for Philippine Government Agencies, including regional offices (e.g., MIMAROPA branches).
*   **Mobile-First:** Fully responsive layout for filing reports via smartphone or tablet.

---

## 🚀 Technical Stack

*   **Backend:** Laravel 13 & PHP 8.4.10
*   **Frontend:** Tailwind CSS (Emerald Palette) & Alpine.js
*   **Database:** MySQL / MariaDB
*   **Tooling:** Vite for lightning-fast asset bundling

---

## 🛠️ Installation & Setup

1.  **Clone the repository**
    ```bash
    git clone https://github.com/lloydDevs/complaint-system.git
    cd complaint-system
    ```

2.  **Install Dependencies**
    ```bash
    composer install
    npm install
    ```

3.  **Environment Configuration**
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```
    *Configure your database settings in the `.env` file.*

4.  **Run Migrations**
    ```bash
    php artisan migrate
    ```

5.  **Compile Assets & Start Server**
    ```bash
    npm run dev
    # In a new terminal
    php artisan serve
    ```

---

## 📂 Project Structure

*   `app/Models/Complaint.php`: Handles the logic for anonymous ticket storage.
*   `resources/views/layouts/`: Contains the **Emerald-themed** minimalist layouts.
*   `resources/views/dashboard.blade.php`: The dual-pane "Activity & Create" interface.
*   `tailwind.config.js`: Custom configuration for the green-brand system.

---

## 📄 License
This system is developed for the **Department of Agriculture** and related agencies. Licensed under the MIT License.

---