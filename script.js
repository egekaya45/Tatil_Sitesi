// TatilCenneti — Ana JavaScript Dosyası

document.addEventListener('DOMContentLoaded', function () {

    // =========================================
    // Smooth scroll (hash linkler için)
    // =========================================
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                e.preventDefault();
                window.scrollTo({ top: target.offsetTop - 80, behavior: 'smooth' });
            }
        });
    });

    // =========================================
    // Flash mesajları otomatik kapat (3 sn)
    // =========================================
    setTimeout(() => {
        document.querySelectorAll('.success-message, .error-message').forEach(el => {
            el.style.transition = 'opacity 0.5s ease';
            el.style.opacity = '0';
            setTimeout(() => el.remove(), 500);
        });
    }, 4000);

    // =========================================
    // Tarih inputları — bugünden öncesini kapat
    // =========================================
    const today = new Date().toISOString().split('T')[0];
    document.querySelectorAll('input[type="date"]').forEach(input => {
        if (!input.min) input.min = today;
    });

    // Giriş/çıkış tarihi mantığı
    const checkIn  = document.getElementById('check_in')  || document.getElementById('check-in');
    const checkOut = document.getElementById('check_out') || document.getElementById('check-out');
    if (checkIn && checkOut) {
        checkIn.addEventListener('change', function () {
            if (this.value) {
                const nextDay = new Date(this.value);
                nextDay.setDate(nextDay.getDate() + 1);
                checkOut.min   = nextDay.toISOString().split('T')[0];
                if (checkOut.value && checkOut.value <= this.value) checkOut.value = '';
            }
        });
    }

    // =========================================
    // Sticky header gölgesi
    // =========================================
    const header = document.querySelector('header');
    if (header) {
        window.addEventListener('scroll', () => {
            header.style.boxShadow = window.scrollY > 10
                ? '0 2px 20px rgba(0,0,0,0.10)'
                : '0 1px 0 #e5e7eb';
        });
    }

});

// =========================================
// Sayaç animasyonu (hero stats)
// =========================================
function animateCounter(el) {
    const target   = parseInt(el.dataset.target);
    const duration = 1800;
    const step     = target / (duration / 16);
    let current    = 0;

    const timer = setInterval(() => {
        current += step;
        if (current >= target) {
            el.textContent = target;
            clearInterval(timer);
        } else {
            el.textContent = Math.floor(current);
        }
    }, 16);
}

const counters = document.querySelectorAll('.stat-num[data-target]');
if (counters.length > 0) {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateCounter(entry.target);
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });
    counters.forEach(c => observer.observe(c));
}