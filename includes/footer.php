<!-- Main content ends here -->

<!-- Floating WhatsApp Button -->
<a href="<?php echo htmlspecialchars($settings['whatsapp_link'] ?? 'https://wa.me/'.$settings['whatsapp']); ?>" class="whatsapp-float bg-success text-white rounded-circle shadow d-flex align-items-center justify-content-center" target="_blank" rel="noopener noreferrer">
    <i class="fab fa-whatsapp fs-2"></i>
</a>



<!-- Booking Global Modal -->
<div class="modal fade" id="bookingModal" tabindex="-1" aria-labelledby="bookingModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg">
      <div class="modal-header bg-primary text-white border-0">
        <h5 class="modal-title" id="bookingModalLabel"><i class="fas fa-calendar-check me-2"></i>Book Your Adventure</h5>
                <button type="button" class="btn-close-custom bg-white bg-opacity-25 text-white border-0 rounded-circle d-flex align-items-center justify-content-center p-0 ms-auto shadow-sm" 
                data-bs-dismiss="modal" aria-label="Close" style="width: 28px; height: 28px; transition: all 0.3s ease;">
            <i class="fas fa-times fs-6"></i>
        </button>

      </div>
      <div class="modal-body p-4">
        <form id="globalBookingForm">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="name" class="form-control bg-light" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Country</label>
                    <input type="text" name="country" class="form-control bg-light" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control bg-light" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">WhatsApp Number</label>
                    <input type="tel" name="whatsapp" class="form-control bg-light" required>
                </div>
                <div class="col-12">
                    <label class="form-label">Select Tour Package</label>
                    <select name="tour" class="form-select bg-light" id="modalTourSelect" required>
                        <option value="" selected disabled>Choose a tour...</option>
                        <option value="Cultural Tours">Cultural Tours</option>
                        <option value="Wildlife Safari">Wildlife Safari</option>
                        <option value="Beach Getaways">Beach Getaways</option>
                        <option value="Custom Private Tour">Custom Private Tour</option>
                        <option value="Taxi Service">Taxi Service Only</option>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label">Message / Special Requests</label>
                    <textarea name="message" class="form-control bg-light" rows="3"></textarea>
                </div>
                <div class="col-12 mt-4">
                    <button type="submit" class="btn btn-primary w-100 py-2 fw-bold text-uppercase" id="submitBookingBtn">Confirm Booking <i class="fas fa-paper-plane ms-2"></i></button>
                </div>
                <div class="col-12 text-center mt-2 d-none" id="bookingStatus"></div>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Taxi Booking Modal -->
<div class="modal fade" id="taxiModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg">
      <div class="modal-header bg-primary text-white border-0">
        <h5 class="modal-title"><i class="fas fa-taxi me-2"></i>Book a Taxi</h5>
                <button type="button" class="btn-close-custom bg-white bg-opacity-25 text-white border-0 rounded-circle d-flex align-items-center justify-content-center p-0 ms-auto shadow-sm" 
                data-bs-dismiss="modal" aria-label="Close" style="width: 28px; height: 28px; transition: all 0.3s ease;">
            <i class="fas fa-times fs-6"></i>
        </button>

      </div>
      <div class="modal-body p-4">
        <form id="taxiForm">
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control bg-light" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Phone / WhatsApp</label>
                <input type="tel" name="phone" class="form-control bg-light" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Vehicle Type</label>
                <select name="vehicle_type" class="form-select bg-light" required>
                    <option value="Car">Car (1-3 pax)</option>
                    <option value="Van">Van (4-8 pax)</option>
                    <option value="Luxury SUV">Luxury SUV (1-4 pax)</option>
                    <option value="Star Bus">Star Bus (Max 25 pax)</option>
                    <option value="Full AC Bus">Full AC Bus (Max 50 pax)</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Date of Journey</label>
                <input type="date" name="date" class="form-control bg-light" required>
            </div>
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary w-100 py-2 fw-bold" id="submitTaxiBtn">Request Booking <i class="fas fa-paper-plane ms-2"></i></button>
            </div>
            <div id="taxiStatus" class="mt-3 text-center d-none"></div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Footer -->
<footer class="bg-dark text-white pt-5 pb-3 mt-5">
    <div class="container">
        <div class="row gy-4">
            <div class="col-lg-4 col-md-6">
                <div class="mb-3">
                    <img src="assets/logo.jpg" alt="Dimu Tour Travels" style="max-height: 80px; object-fit: contain;" class="bg-white rounded p-1 shadow-sm">
                </div>
                <p class="text-white-50">Your trusted partner for unforgettable experiences. From cultural highlights to thrilling wildlife safaris.</p>
                <div class="d-flex gap-3 mt-3">
                    <?php if(!empty($settings['facebook'])): ?>
                        <a href="<?php echo htmlspecialchars($settings['facebook']); ?>" target="_blank" class="text-white-50 text-hover-primary fs-5"><i class="fab fa-facebook"></i></a>
                    <?php endif; ?>
                    <?php if(!empty($settings['instagram'])): ?>
                        <a href="<?php echo htmlspecialchars($settings['instagram']); ?>" target="_blank" class="text-white-50 text-hover-primary fs-5"><i class="fab fa-instagram"></i></a>
                    <?php endif; ?>
                    <?php if(!empty($settings['tiktok'])): ?>
                        <a href="<?php echo htmlspecialchars($settings['tiktok']); ?>" target="_blank" class="text-white-50 text-hover-primary fs-5"><i class="fab fa-tiktok"></i></a>
                    <?php endif; ?>
                    <a href="https://wa.me/<?php echo str_replace(['+',' '], '', $settings['whatsapp']); ?>" target="_blank" class="text-white-50 text-hover-primary fs-5"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>
            <div class="col-lg-2 col-md-6">
                <h5 class="mb-3 text-white">Quick Links</h5>
                <ul class="list-unstyled footer-links">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="#tours">Tours</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-6">
                <h5 class="mb-3 text-white">Contact Info</h5>
                <ul class="list-unstyled text-white-50">
                    <li class="mb-2"><i class="fas fa-map-marker-alt me-2 text-primary"></i> Palalla Road, Weligama, Sri Lanka</li>
                    <li class="mb-2"><i class="fas fa-phone me-2 text-primary"></i> <a href="tel:<?php echo htmlspecialchars($settings['phone1']); ?>" class="text-white-50 text-decoration-none"><?php echo htmlspecialchars($settings['phone1']); ?></a></li>
                    <li class="mb-2"><i class="fas fa-envelope me-2 text-primary"></i> <a href="mailto:<?php echo htmlspecialchars($settings['email']); ?>" class="text-white-50 text-decoration-none"><?php echo htmlspecialchars($settings['email']); ?></a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-6">
                <h5 class="mb-3 text-white">Newsletter</h5>
                <p class="text-white-50 mb-3">Subscribe to get special offers and travel tips.</p>
                <div class="input-group">
                    <input type="email" class="form-control" placeholder="Email Address">
                    <button class="btn btn-primary" type="button"><i class="fas fa-paper-plane"></i></button>
                </div>
            </div>
        </div>
        <hr class="border-secondary mt-5 mb-3">
        <div class="row align-items-center">
            <div class="col-md-8 text-center text-md-start">
                <small class="text-white-50">&copy; <?php echo date('Y'); ?> Dimu Tour & Traveling. All Rights Reserved.</small>
                <span class="d-none d-md-inline text-white-50 mx-2">|</span>
                <br class="d-md-none">
                <small class="text-white-50 mt-2 mt-md-0 d-inline-block">
                    Developed By <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#developerModal" class="text-success text-decoration-none fw-bold">Malitha Tishamal</a> @2026
                </small>
            </div>
            <div class="col-md-4 text-center text-md-end mt-3 mt-md-0">
                <a href="admin/login.php" class="text-white-50 text-decoration-none"><small>Admin Login</small></a>
            </div>
        </div>
    </div>
</footer>

<!-- Developer Info Modal -->
<div class="modal fade" id="developerModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
      <div class="modal-body p-0">
        <div class="row g-0">
          <div class="col-md-5 d-none d-md-block">
            <img src="assets/developer.jpg" class="h-100 w-100 object-fit-cover" alt="Developer">
          </div>
          <div class="col-md-7 p-4 p-md-5">
            <button type="button" class="btn-close float-end" data-bs-dismiss="modal" aria-label="Close"></button>
            <h4 class="fw-bold mb-1">Malitha Tishamal</h4>
            <p class="text-primary fw-semibold mb-3">Full Stack Developer & UI/UX Designer</p>
            
            <p class="text-muted small mb-4">I specialize in creating modern, high-performance web applications and digital solutions. Contact me for professional web development services.</p>
            
            <div class="mb-4">
              <h6 class="fw-bold mb-2">Connect with me:</h6>
              <div class="d-flex gap-2 mb-3">
                <a href="http://malithatishamal.42web.io" target="_blank" class="btn btn-outline-secondary btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;"><i class="bi bi-globe"></i></a>
                <a href="https://x.com/MalithaTishamal" target="_blank" class="btn btn-outline-secondary btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;"><i class="bi bi-twitter-x"></i></a>
                <a href="https://www.linkedin.com/in/malitha-tishamal" target="_blank" class="btn btn-outline-secondary btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;"><i class="bi bi-linkedin"></i></a>
                <a href="https://github.com/malitha-tishamal" target="_blank" class="btn btn-outline-secondary btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;"><i class="bi bi-github"></i></a>
                <a href="https://www.instagram.com/malithatishamal" target="_blank" class="btn btn-outline-secondary btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;"><i class="bi bi-instagram"></i></a>
                <a href="https://www.facebook.com/malitha.tishamal" target="_blank" class="btn btn-outline-secondary btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;"><i class="bi bi-facebook"></i></a>
              </div>
            </div>
            
            <div class="bg-light p-3 rounded-3 border border-success border-opacity-25 text-center">
              <p class="mb-1 small text-muted">Direct Contact:</p>
              <a href="https://wa.me/94785530992" target="_blank" class="btn btn-success w-100 fw-bold rounded-pill">
                <i class="fab fa-whatsapp me-2"></i> 078 553 0992
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Global JS Scripts -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    // Booking Form AJAX Submit
    const bookingForm = document.getElementById('globalBookingForm');
    if(bookingForm) {
        bookingForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const btn = document.getElementById('submitBookingBtn');
            const statusDiv = document.getElementById('bookingStatus');
            const formData = new FormData(this);

            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...';
            
            fetch('booking.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if(data.status === 'success') {
                    statusDiv.innerHTML = '<div class="alert alert-success py-2">Booking confirmed! Redirecting to WhatsApp...</div>';
                    statusDiv.classList.remove('d-none');
                    bookingForm.reset();
                    
                    // Redirect to WhatsApp
                    setTimeout(() => {
                        window.open(data.whatsapp_url, '_blank');
                        const modal = bootstrap.Modal.getInstance(document.getElementById('bookingModal'));
                        modal.hide();
                    }, 2000);
                } else {
                    statusDiv.innerHTML = `<div class="alert alert-danger py-2">${data.message}</div>`;
                    statusDiv.classList.remove('d-none');
                }
            })
            .catch(err => {
                statusDiv.innerHTML = '<div class="alert alert-danger py-2">An error occurred. Please try again.</div>';
                statusDiv.classList.remove('d-none');
            })
            .finally(() => {
                btn.disabled = false;
                btn.innerHTML = 'Confirm Booking <i class="fas fa-paper-plane ms-2"></i>';
            });
        });
    }

    // Modal Tour Pre-selection handler
    const bookingModal = document.getElementById('bookingModal');
    if (bookingModal) {
        bookingModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const tourName = button.getAttribute('data-tour');
            if(tourName) {
                const select = document.getElementById('modalTourSelect');
                // Set the value if option exists
                for(let i = 0; i < select.options.length; i++) {
                    if(select.options[i].value === tourName) {
                        select.selectedIndex = i;
                        break;
                    }
                }
            }
        });
    }
    // Taxi Form AJAX Submit
    const taxiForm = document.getElementById('taxiForm');
    if(taxiForm) {
        taxiForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const btn = document.getElementById('submitTaxiBtn');
            const statusDiv = document.getElementById('taxiStatus');
            const formData = new FormData(this);

            btn.disabled = true;
            btn.innerHTML = 'Requesting...';
            
            fetch('taxi.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if(data.status === 'success') {
                    statusDiv.innerHTML = `<div class="alert alert-success py-2">${data.message}</div>`;
                    statusDiv.classList.remove('d-none');
                    taxiForm.reset();
                    setTimeout(() => {
                        const modal = bootstrap.Modal.getInstance(document.getElementById('taxiModal'));
                        modal.hide();
                        statusDiv.classList.add('d-none');
                    }, 3000);
                } else {
                    statusDiv.innerHTML = `<div class="alert alert-danger py-2">${data.message}</div>`;
                    statusDiv.classList.remove('d-none');
                }
            })
            .catch(err => {
                statusDiv.innerHTML = '<div class="alert alert-danger py-2">An error occurred.</div>';
                statusDiv.classList.remove('d-none');
            })
            .finally(() => {
                btn.disabled = false;
                btn.innerHTML = 'Request Booking <i class="fas fa-paper-plane ms-2"></i>';
            });
        });
    }

    // Global Modal Backdrop Close Logic
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('modal') && !e.target.classList.contains('modal-static')) {
            const modalInstance = bootstrap.Modal.getInstance(e.target);
            if (modalInstance) {
                modalInstance.hide();
            }
        }
    });
});
</script>
</body>
</html>
