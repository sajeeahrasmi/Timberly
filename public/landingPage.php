<?php 
    include '../api/getLandingPage.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Timberly</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    <script src="https://kit.fontawesome.com/3c744f908a.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="landingPage.css">
    </head>
<body>
    <header class="header">
        <a href="#" class="logo"><img src="./images/final_logo.png" style="width: 200px; height: 200px;"></a>
        <nav class="nav-links">
            <a href="#home">Home</a>
            <a href="#featured">Collection</a>
            <a href="#values">About</a>
            <a href="#contact">Contact</a>
        </nav>
        <button class="btn" id="loginBtn" onclick="window.location.href=`http://localhost/Timberly/public/login.php`">
            <i class="fa-regular fa-user"></i>
            Login
        </button>
    </header>

    <section class="hero" id="home">
        <div class="hero-content">
            <h1>Crafted with Nature's Finest</h1>
            <p>Discover our collection of handcrafted wooden furniture, where traditional craftsmanship meets contemporary design.</p>
            <a href="products.php" class="cta-button">Explore Collection</a>
        </div>
    </section>

    <section class="featured" id="featured">
        <div class="section-title">
            <h2>Featured Pieces</h2>
            <p>Discover our most popular handcrafted furniture</p>
        </div>
        <div class="featured-grid">
            <?php foreach ($productData as $item): ?>
            <div class="featured-item">
                <div class="placeholder-img">
                    <?php 
                    $originalPath = $item['image'];
                    $cleanedPath = str_replace('../','',$originalPath);?>
                    <img src="<?php echo htmlspecialchars($cleanedPath); ?>" alt="Featured Item" style="width: 100%; height: 100%;">
                </div>
                <div class="featured-overlay">
                    <h3><?php echo htmlspecialchars($item['description'])?></h3>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="values" id="values">
        <div class="section-title">
            <h2>Our Values</h2>
            <p>What makes our furniture special</p>
        </div>
        <div class="values-grid">
            <div class="value-item">
                <div class="value-icon">🌳</div>
                <h3>Sustainable Materials</h3>
                <p>Ethically sourced wood from managed forests, ensuring environmental responsibility in every piece we create.</p>
            </div>
            <div class="value-item">
                <div class="value-icon">🛠️</div>
                <h3>Master Craftsmanship</h3>
                <p>Generations of woodworking expertise combined with modern techniques for superior quality.</p>
            </div>
            <div class="value-item">
                <div class="value-icon">♾️</div>
                <h3>Timeless Design</h3>
                <p>Contemporary aesthetics that transcend trends, creating pieces that last for generations.</p>
            </div>
        </div>
    </section>

    <section class="contact" id="contact">
        <div class="section-title">
            <h2>Get in Touch</h2>
            <p>Have a question? We'd love to hear from you.</p>
        </div>
        <form class="contact-form" action="../api/sendEmail.php" method="POST">
            <div class="form-group">
                <input type="text" name="name" class="form-input" placeholder="Your Name" required>
            </div>
            <div class="form-group">
                <input type="email" name="email" class="form-input" placeholder="Your Email" required>
            </div>
            <div class="form-group">
                <textarea name="message" class="form-input" rows="5" placeholder="Your Message" required></textarea>
            </div>
            <button type="submit" class="cta-button">Send Message</button>
        </form>
    </section>

    <script>
        // Header scroll effect
        window.addEventListener('scroll', () => {
            const header = document.querySelector('.header');
            if (window.scrollY > 100) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });

        // Initialize GSAP ScrollTrigger
        gsap.registerPlugin(ScrollTrigger);

        // Animate sections on scroll
        const sections = document.querySelectorAll('section');
        sections.forEach(section => {
            gsap.from(section.children, {
                y: 50,
                opacity: 0,
                duration: 1,
                stagger: 0.2,
                scrollTrigger: {
                    trigger: section,
                    start: "top 80%",
                    end: "top 20%",
                    toggleActions: "play none none reverse"
                }
            });
        });
 
    document.addEventListener("DOMContentLoaded", () => {
    const userBtn = document.getElementById("loginBtn");

    // Fetch user session data
    fetch("../config/user.php")
        .then(response => {
            if (!response.ok) {
                throw new Error("Session check failed.");
            }
            return response.json();
        })
        .then(data => {
            if (data && data.userId && data.role) {
                // User is logged in
                userBtn.innerHTML = `<i class="fa-regular fa-user"></i> ${data.name}`;
                userBtn.onclick = () => redirectToDashboard(data.role);
            } else {
                // User is not logged in
                setLoginButton();
            }
        })
        .catch(() => {
            // If fetch fails, assume user is not logged in
            setLoginButton();
        });

    function setLoginButton() {
        userBtn.innerHTML = `<i class="fa-regular fa-user"></i> Login`;
        userBtn.onclick = () => {
            window.location.href = "../public/login.php";
        };
    }

    function redirectToDashboard(role) {
        switch (role) {
            case "customer":
                window.location.href = "../../Timberly/public/customer/customerDashboard.php";
                break;
            case "manager":
                window.location.href = "../../Timberly/public/manager/admin.php";
                break;
            case "supplier":
                window.location.href = "../../Timberly/public/supplier/Dashboard/dashboard.html";
                break;
            case "admin":
                window.location.href = "../../Timberly/public/admin/index.php";
                break;
            case "driver":
                window.location.href = "../../Timberly/public/other/driver.php";
                break;
            case "designer":
                window.location.href = "../../Timberly/public/other/designer.php";
                break;
            default:
                alert("Unknown role. Please contact support.");
        }
    }
});


</script>
</body>

</html>