# SafdarGPT - Lightweight PHP MVC Framework

SafdarGPT is a clean, custom-built PHP MVC framework developed by **Safdar**, with architectural support and optimization ideas powered by **GPT**. This framework is ideal for rapid web application development, educational purposes, and full control over routing, controllers, views, and helper utilities.

> 🔥 "Built for developers who want full control without the weight of bloated frameworks."

---

## 🌟 Key Features

- 🔁 Simple yet powerful MVC structure
- 🧭 Custom router with clean URL dispatching
- 🎨 Layout and partial-based rendering engine
- 📂 Organized file structure for scalability
- 🧰 Built-in helper functions (e.g., file uploads, sanitization, flash messaging)
- 🔐 Basic role-based layout logic
- ⚙️ Easily extendable and customizable

---

## 📁 Project Structure

```
IET_SafdarGpt/
│
├── App/
│   ├── Controllers/        # Main controllers
│   ├── Models/             # Data logic
│   ├── Views/              # View files and layouts
│   └── Middlewares/        # (Optional) Middleware logic
│
├── Core/
│   ├── Route.php           # Custom routing engine
│   ├── Controller.php      # Base controller class
│   └── View.php            # View rendering system
│
├── Helpers/
│   ├── helpers.php         # Global helper functions
│   └── validation.php      # Form and input validation logic
│
├── Public/
│   └── index.php           # Entry point of the app
│
├── config.php              # App configuration
└── .htaccess               # Rewrite rules
```

---

## 🚀 Getting Started

1. Clone this repository:
```bash
git clone https://github.com/MrEveryThingIr/IET_SafdarGpt.git
```

2. Set up your local server (XAMPP, Laragon, etc.) and point your web root to the `Public/` folder.

3. Customize your routes in `Core/Route.php` and create corresponding controllers and views.

---

## 🔧 Example Usage

### Define a Route
```php
Route::get('/home', 'HomeController@index');
```

### Create a Controller
```php
class HomeController extends Controller {
    public function index() {
        return $this->view('home');
    }
}
```

### Create a View
```php
<!-- Views/home.php -->
<h1>Welcome to SafdarGPT Framework</h1>
```

---

## 🧠 Philosophy
> A framework should never fight your creativity — it should amplify it.

SafdarGPT was designed by **Safdar**, a deep-thinking developer with a passion for physics, algorithmic systems, and clean design — supported by GPT to accelerate architecture, documentation, and roadmap planning.

This framework is part of a broader vision: to create systems that are modular, scalable, and rooted in clarity — not just for the sake of code, but for the evolution of creative logic.

---

## 🤝 Credits
- **Safdar** — Architect & Developer
- **GPT** — Co-architect, Optimization & Documentation Support

---

## 📬 Want to Collaborate or Hire?
I'm open for freelance PHP work, from full systems to fixing bugs or building admin panels.

📧 Email: `safdarfreelance@gmail.com`  
💬 Telegram: `@SafdarDev`

---

## 📜 License
MIT License — use freely, modify boldly, credit respectfully.

---

> Built with mind, meaning, and mission — by Safdar & GPT 🌍

