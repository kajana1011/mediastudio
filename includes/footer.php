<footer class="bg-secondary text-center text-light py-4 mt-4" role="contentinfo">
        <div class="container">
            <p>
                &copy; <?php echo date('Y'); ?> <a href="/" class="text-light text-decoration-none">b25studio</a>. All rights reserved.
            </p>
            <div class="mb-2">
                <!-- Social icons example -->
                <a href="https://instagram.com/rmkajana" target="_blank" class="mx-2 text-light" aria-label="Instagram">
                    <i class="bi bi-instagram"></i>
                </a>
                <a href="https://github.com/kajana1011" target="_blank" class="mx-2 text-light" aria-label="GitHub">
                    <i class="bi bi-github"></i>
                </a>
                <a href="/contact" class="mx-2 text-light" aria-label="Contact">
                    <i class="bi bi-envelope"></i>
                </a>
            </div>
            <div>
                <a href="/privacy-policy" class="text-light text-decoration-underline mx-2">Privacy Policy</a>
                <a href="/terms" class="text-light text-decoration-underline mx-2">Terms</a>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- Canvas animation only if #spiderCanvas and #hero exist -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const canvas = document.getElementById('spiderCanvas');
        const hero = document.getElementById('hero');
        if (canvas && hero) {
            const ctx = canvas.getContext('2d');

            let w, h;
            function resizeCanvas() {
                w = canvas.width = hero.offsetWidth;
                h = canvas.height = hero.offsetHeight;
            }
            window.addEventListener('resize', resizeCanvas);
            resizeCanvas();

            let dots = Array.from({ length: 60 }, () => ({
                x: Math.random() * w,
                y: Math.random() * h,
                vx: Math.random() * 0.8,
                vy: Math.random() * 0.2
            }));

            function draw() {
                ctx.clearRect(0, 0, w, h);
                for (let i = 0; i < dots.length; i++) {
                    let dot = dots[i];
                    dot.x += dot.vx;
                    dot.y += dot.vy;

                    if (dot.x < 0 || dot.x > w) dot.vx *= -1;
                    if (dot.y < 0 || dot.y > h) dot.vy *= -1;

                    ctx.beginPath();
                    ctx.arc(dot.x, dot.y, 2, 0, Math.PI * 2);
                    ctx.fillStyle = '#ffffff';
                    ctx.fill();
                }

                for (let i = 0; i < dots.length; i++) {
                    for (let j = i + 1; j < dots.length; j++) {
                        let dx = dots[i].x - dots[j].x;
                        let dy = dots[i].y - dots[j].y;
                        let dist = Math.sqrt(dx * dx + dy * dy);
                        if (dist < 100) {
                            ctx.beginPath();
                            ctx.moveTo(dots[i].x, dots[i].y);
                            ctx.lineTo(dots[j].x, dots[j].y);
                            ctx.strokeStyle = 'rgba(255,255,255,' + (1 - dist / 100) + ')';
                            ctx.stroke();
                        }
                    }
                }

                requestAnimationFrame(draw);
            }

            draw();
        }
    });
    </script>

</body>
</html>
