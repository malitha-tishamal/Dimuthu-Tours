<?php
require_once 'includes/db.php';

// Fetch Settings
$stmt = $pdo->query("SELECT * FROM site_settings");
$settings_raw = $stmt->fetchAll(PDO::FETCH_ASSOC);
$settings = [];
foreach($settings_raw as $s) {
    $settings[$s['key_name']] = $s['value'];
}

// Fetch Vehicles
$v_stmt = $pdo->query("SELECT * FROM vehicles WHERE status = 'active'");
$vehicles = $v_stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($vehicles as &$v) {
    $img_stmt = $pdo->prepare("SELECT * FROM vehicle_images WHERE vehicle_id = ?");
    $img_stmt->execute([$v['id']]);
    $v['images'] = $img_stmt->fetchAll(PDO::FETCH_ASSOC);
}
unset($v); // Unset reference to avoid issues

// Fetch Tours
$stmt = $pdo->query("SELECT * FROM tours WHERE status='active' ORDER BY id DESC");
$tours = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch Approved Reviews
$stmt = $pdo->query("SELECT * FROM reviews WHERE status='approved' ORDER BY id DESC LIMIT 5");
$reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch Travel Memories
$stmt = $pdo->query("SELECT * FROM travel_memories WHERE status = 'active' ORDER BY event_date DESC LIMIT 6");
$memories = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach($memories as &$memory) {
    $stmt = $pdo->prepare("SELECT image_path FROM memory_images WHERE memory_id = ?");
    $stmt->execute([$memory['id']]);
    $memory['images'] = $stmt->fetchAll(PDO::FETCH_COLUMN);
}
unset($memory);

// Fetch Hero Slides
$stmt = $pdo->query("SELECT * FROM hero_slides ORDER BY id ASC");
$hero_slides = $stmt->fetchAll(PDO::FETCH_ASSOC);

include 'includes/header.php';
?>

<!-- Hero Section -->
<section class="hero-section position-relative overflow-hidden" id="home">
    <div id="heroCarousel" class="carousel slide carousel-fade h-100 w-100 position-absolute" data-bs-ride="carousel" data-bs-interval="10000">
        <div class="carousel-inner h-100">
            <?php foreach($hero_slides as $index => $slide): ?>
            <div class="carousel-item h-100 <?php echo $index == 0 ? 'active' : ''; ?>">
                <div class="hero-slide-img h-100 w-100" style="background-image: url('<?php echo htmlspecialchars($slide['image_path']); ?>'); background-size: cover; background-position: center;"></div>
            </div>
            <?php endforeach; ?>
        </div>
        <!-- Hero Slider Controls -->
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev" style="z-index: 5; width: 5%;">
            <span class="carousel-control-prev-icon p-3 rounded-circle bg-dark bg-opacity-25" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next" style="z-index: 5; width: 5%;">
            <span class="carousel-control-next-icon p-3 rounded-circle bg-dark bg-opacity-25" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    
    <div class="hero-overlay"></div>
    <div class="container hero-content text-center text-md-start position-relative" style="z-index: 2;">
        <div class="row">
            <div class="col-lg-8">
                <h1 class="display-3 fw-bold mb-3 animate__animated animate__fadeInDown"><?php echo htmlspecialchars($settings['hero_title']); ?></h1>
                <p class="lead fs-3 mb-5 fw-light animate__animated animate__fadeInUp animate__delay-1s"><?php echo htmlspecialchars($settings['hero_subtitle']); ?></p>
                <div class="d-flex flex-wrap gap-3 justify-content-center justify-content-md-start animate__animated animate__fadeInUp animate__delay-2s">
                    <button class="btn btn-primary btn-lg rounded-pill px-5 shadow-sm" data-bs-toggle="modal" data-bs-target="#bookingModal">Book Now</button>
                    <a href="<?php echo htmlspecialchars($settings['whatsapp_link'] ?? 'https://wa.me/'.str_replace(['+',' '], '', $settings['whatsapp'])); ?>" class="btn btn-success btn-lg rounded-pill px-5 shadow-sm" target="_blank" rel="noopener noreferrer"><i class="fab fa-whatsapp me-2"></i> WhatsApp Us</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Tours Section -->
<section class="section-padding bg-light" id="tours">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title fw-bold text-dark">Popular Tours in Sri Lanka</h2>
            <p class="text-muted">Discover the perfect package for your next adventure</p>
        </div>
        
        <div class="row g-4">
            <?php foreach($tours as $tour): ?>
            <div class="col-lg-4 col-md-6">
                <div class="card tour-card h-100 shadow-sm border-0">
                    <div class="position-relative">
                        <img src="<?php echo htmlspecialchars($tour['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($tour['title']); ?>">
                        <div class="card-badge bg-success shadow-sm">
                            <i class="far fa-clock me-1"></i> <?php echo htmlspecialchars($tour['duration']); ?>
                        </div>
                    </div>
                    <div class="card-body p-4 text-center">
                        <h4 class="card-title fw-bold text-dark mb-3"><?php echo htmlspecialchars($tour['title']); ?></h4>
                        <p class="card-text text-muted small mb-4 line-clamp-2"><?php echo htmlspecialchars(substr($tour['description'], 0, 100)); ?>...</p>
                        <button class="view-tour-details rounded-pill w-100 mb-2" 
                                data-bs-toggle="modal" 
                                data-bs-target="#tourDetailsModal"
                                data-title="<?php echo htmlspecialchars($tour['title']); ?>"
                                data-desc="<?php echo htmlspecialchars($tour['description']); ?>"
                                data-dur="<?php echo htmlspecialchars($tour['duration']); ?>"
                                data-img="<?php echo htmlspecialchars($tour['image']); ?>">
                            View Details <i class="fas fa-arrow-right ms-2"></i>
                        </button>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            
            <?php if(empty($tours)): ?>
                <div class="col-12 text-center text-muted">No tours available at the moment.</div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Travel Memories Section -->
<section class="section-padding bg-white" id="memories">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title fw-bold text-dark">Our Travel Memories</h2>
            <p class="text-muted">Capturing moments and stories from our journeys</p>
        </div>
        
        <div class="row g-4 justify-content-center">
            <?php foreach($memories as $memory): ?>
            <div class="col-lg-4 col-md-6">
                <div class="card memory-card h-100 shadow-sm border-0 rounded-4 overflow-hidden">
                    <!-- Image Slider -->
                    <div id="carouselMemory<?php echo $memory['id']; ?>" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <?php foreach($memory['images'] as $index => $img): ?>
                            <div class="carousel-item <?php echo $index == 0 ? 'active' : ''; ?>">
                                <img src="<?php echo htmlspecialchars($img); ?>" class="d-block w-100" style="height: 250px; object-fit: cover;" alt="Memory Photo">
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <?php if(count($memory['images']) > 1): ?>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselMemory<?php echo $memory['id']; ?>" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselMemory<?php echo $memory['id']; ?>" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                        <?php endif; ?>
                    </div>
                    
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="badge bg-light text-primary rounded-pill px-3 py-2 fw-semibold shadow-sm"><i class="fas fa-map-marker-alt me-1"></i> <?php echo htmlspecialchars($memory['location']); ?></span>
                            <small class="text-muted fw-medium"><?php echo date('M Y', strtotime($memory['event_date'])); ?></small>
                        </div>
                        <h4 class="card-title fw-bold text-dark mt-2 mb-3"><?php echo htmlspecialchars($memory['title']); ?></h4>
                        <p class="card-text text-muted line-clamp-3 small mb-0"><?php echo htmlspecialchars($memory['description']); ?></p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            
            <?php if(empty($memories)): ?>
                <div class="col-12 text-center text-muted">No memories shared yet.</div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Safari Destinations -->
<?php
$safaris = [
    [
        'title' => 'Yala National Park',
        'desc' => 'Yala is the most famous national park in Sri Lanka, known for having one of the highest densities of leopards in the world. Visitors can also see elephants, crocodiles, sloth bears, and a wide variety of birds. Perfect for an exciting and adventurous safari experience.',
        'image' => 'assets/yala.png'
    ],
    [
        'title' => 'Udawalawe National Park',
        'desc' => 'Udawalawe is the best place to see large herds of elephants in their natural habitat. The park offers open landscapes, making wildlife easy to spot. A great destination for families and nature lovers.',
        'image' => 'assets/udawalawe.png'
    ],
    [
        'title' => 'Wilpattu National Park',
        'desc' => 'Wilpattu is Sri Lanka’s largest national park, famous for its natural lakes (villus) and peaceful environment. It is home to leopards, deer, elephants, and many bird species. Ideal for those who prefer a quiet and less crowded safari.',
        'image' => 'assets/wilpattu.png'
    ],
    [
        'title' => 'Minneriya National Park',
        'desc' => 'Minneriya is world-famous for “The Gathering,” where hundreds of elephants come together around the reservoir during the dry season. This is one of the greatest wildlife spectacles in Asia.',
        'image' => 'assets/minneriya.png'
    ],
    [
        'title' => 'Kaudulla National Park',
        'desc' => 'Kaudulla is another excellent place to see elephants and diverse birdlife. It is often combined with Minneriya for a complete safari experience.',
        'image' => 'assets/kaudulla.png'
    ],
    [
        'title' => 'Horton Plains National Park',
        'desc' => 'Horton Plains offers a unique experience with cool climate, misty grasslands, and stunning viewpoints like World’s End. Visitors can spot deer, birds, and enjoy scenic nature walks.',
        'image' => 'assets/horton.png'
    ]
];
?>
<section class="section-padding bg-white" id="safari">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title fw-bold text-dark">Top Wildlife Safari Destinations in Sri Lanka</h2>
            <p class="text-muted">Experience the wild beauty of Sri Lanka</p>
        </div>
        
        <div class="row g-4">
            <?php foreach($safaris as $safari): ?>
            <div class="col-lg-4 col-md-6">
                <div class="safari-card position-relative shadow-sm rounded overflow-hidden" 
                     data-bs-toggle="modal" 
                     data-bs-target="#safariDetailsModal"
                     data-title="<?php echo htmlspecialchars($safari['title']); ?>"
                     data-desc="<?php echo htmlspecialchars($safari['desc']); ?>"
                     data-img="<?php echo htmlspecialchars($safari['image']); ?>"
                     style="cursor: pointer; transition: transform 0.3s ease;"
                     onmouseover="this.style.transform='translateY(-5px)'"
                     onmouseout="this.style.transform='translateY(0)'">
                    <img src="<?php echo $safari['image']; ?>" class="w-100 object-fit-cover" style="height:280px;" alt="<?php echo $safari['title']; ?>">
                    <div class="position-absolute bottom-0 start-0 w-100 p-3 bg-dark bg-opacity-75 text-white transition-hover">
                        <h5 class="mb-0 fw-bold"><?php echo $safari['title']; ?> <i class="fas fa-search-plus float-end mt-1 fs-6 text-white-50"></i></h5>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <div class="mt-5 text-center p-4 p-md-5 bg-light rounded-4 shadow-sm border border-success border-opacity-25">
            <h3 class="fw-bold mb-3 text-success">🐆 Why Choose Sri Lanka for Safari?</h3>
            <p class="text-muted lead mb-0">Sri Lanka offers one of the best wildlife experiences in Asia. From majestic elephants to rare leopards, every safari is a unique adventure. With diverse national parks located across the island, travelers can enjoy unforgettable nature, photography, and close encounters with wildlife.</p>
        </div>
    </div>
</section>

<!-- Taxi Service Section -->
<section class="section-padding bg-white border-top" id="taxi">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <img src="https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?w=600" class="img-fluid rounded-4 shadow-lg" alt="Taxi Service">
            </div>
            <div class="col-lg-6 ps-lg-5">
                <h2 class="fw-bold mb-4 text-dark">Reliable Taxi & Transfer Services</h2>
                <p class="text-muted mb-4">Need a comfortable ride? We offer reliable airport transfers and point-to-point taxi services across Sri Lanka with professional drivers.</p>
                <div class="row g-3 mb-4">
                    <?php if(!empty($vehicles)): ?>
                        <?php foreach($vehicles as $v): ?>
                            <div class="col-sm-4">
                                <div class="p-3 border rounded text-center shadow-sm h-100 taxi-card position-relative overflow-hidden" 
                                     style="cursor: pointer;" 
                                     data-bs-toggle="modal" 
                                     data-bs-target="#vehicleDetailsModal<?php echo $v['id']; ?>">
                                    <div class="taxi-card-overlay">
                                        <span class="small fw-bold text-white"><i class="fas fa-search-plus me-1"></i> View Vehicle</span>
                                    </div>
                                    <i class="<?php echo $v['icon_class']; ?> fs-2 text-primary mb-2"></i>
                                    <h6 class="fw-bold mb-0"><?php echo htmlspecialchars($v['name']); ?></h6>
                                    <small class="text-muted d-block mb-1"><?php echo htmlspecialchars($v['pax_count']); ?></small>
                                    <span class="text-primary x-small fw-bold text-uppercase d-block" style="font-size: 0.65rem;">Click to view vehicle</span>
                                </div>
                            </div>

                            <!-- Vehicle Details Modal -->
                            <div class="modal fade" id="vehicleDetailsModal<?php echo $v['id']; ?>" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                                        <div class="modal-header border-0 pb-0 bg-light">
                                            <h5 class="modal-title fw-bold text-dark"><?php echo htmlspecialchars($v['name']); ?> Gallery</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body p-4">
                                            <?php if(!empty($v['images'])): ?>
                                                <div class="row g-3">
                                                    <?php foreach($v['images'] as $img): ?>
                                                        <div class="col-md-6">
                                                            <div class="rounded-3 overflow-hidden shadow-sm border" style="height: 250px;">
                                                                <img src="<?php echo htmlspecialchars($img['image_path']); ?>" class="w-100 h-100 object-fit-cover" alt="Vehicle Image">
                                                            </div>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            <?php else: ?>
                                                <div class="text-center py-5 text-muted">
                                                    <i class="fas fa-images fs-1 mb-3 opacity-25"></i>
                                                    <p>No images available for this vehicle yet.</p>
                                                </div>
                                            <?php endif; ?>
                                            
                                            <div class="mt-4 p-3 bg-light rounded-3 d-flex align-items-center justify-content-between">
                                                <div>
                                                    <h6 class="fw-bold mb-1"><?php echo htmlspecialchars($v['name']); ?></h6>
                                                    <p class="mb-0 text-muted small"><i class="fas fa-users me-2"></i>Capacity: <?php echo htmlspecialchars($v['pax_count']); ?></p>
                                                </div>
                                                <button class="btn btn-success rounded-pill px-4 fw-bold" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#taxiModal">
                                                    Book This Ride
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12 text-center py-4 bg-light rounded shadow-sm border">
                            <i class="fas fa-info-circle text-muted mb-2"></i>
                            <p class="mb-0 text-muted small">No vehicles available at the moment.</p>
                        </div>
                    <?php endif; ?>
                </div>
                <button class="btn btn-primary btn-lg rounded-pill px-5 shadow-sm" data-bs-toggle="modal" data-bs-target="#taxiModal">Book a Ride <i class="fas fa-arrow-right ms-2"></i></button>
            </div>
        </div>
    </div>
</section>

<!-- Reviews Section -->
<section class="section-padding bg-light" id="reviews">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title fw-bold text-dark">Guest Reviews</h2>
            <p class="text-muted">What Our Travelers Say</p>
        </div>
        
        <div class="row g-4 justify-content-center">
            <?php foreach($reviews as $review): ?>
            <div class="col-lg-6">
                <div class="card review-card bg-white shadow-sm p-4 h-100">
                    <div class="d-flex align-items-center mb-3">
                        <img src="<?php echo !empty($review['image']) ? $review['image'] : 'https://ui-avatars.com/api/?name='.urlencode($review['name']).'&background=random'; ?>" alt="<?php echo htmlspecialchars($review['name']); ?>" class="review-img shadow-sm me-3">
                        <div>
                            <h5 class="fw-bold mb-0"><?php echo htmlspecialchars($review['name']); ?></h5>
                            <small class="text-muted"><?php echo htmlspecialchars($review['country']); ?></small>
                        </div>
                        <div class="ms-auto star-rating text-warning fs-5">
                            <?php for($i=1; $i<=5; $i++): ?>
                                <i class="fas fa-star <?php echo ($i <= $review['rating']) ? '' : 'text-muted opacity-25'; ?>"></i>
                            <?php endfor; ?>
                        </div>
                    </div>
                    <p class="fst-italic text-muted mb-0">"<?php echo nl2br(htmlspecialchars($review['message'])); ?>"</p>
                </div>
            </div>
            <?php endforeach; ?>
            
            <?php if(empty($reviews)): ?>
                <div class="col-12 text-center text-muted">No reviews yet. Be the first to review us!</div>
            <?php endif; ?>
        </div>

        <div class="text-center mt-5">
            <button class="btn btn-outline-primary px-4 rounded-pill" data-bs-toggle="modal" data-bs-target="#addReviewModal">Add Your Review</button>
        </div>
    </div>
</section>

<!-- Contact & CTA Section -->
<section class="section-padding border-top" id="contact" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-5 mb-4 mb-lg-0">
                <h2 class="display-5 fw-bold text-dark mb-4">Plan Your Trip <span class="text-primary">with Us!</span></h2>
                <p class="lead text-muted mb-4"><?php echo htmlspecialchars($settings['about_text']); ?></p>
                
                <div class="d-flex flex-column gap-3 mb-4">
                    <a href="tel:<?php echo htmlspecialchars($settings['phone1']); ?>" class="d-flex align-items-center text-dark text-decoration-none fs-5 hover-primary">
                        <div class="bg-primary text-white rounded-circle p-3 me-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <div>
                            <span class="d-block fw-bold">Call Us</span>
                            <small class="text-muted"><?php echo htmlspecialchars($settings['phone1']); ?></small>
                        </div>
                    </a>
                    <a href="mailto:<?php echo htmlspecialchars($settings['email']); ?>" class="d-flex align-items-center text-dark text-decoration-none fs-5 hover-primary mt-2">
                        <div class="bg-warning text-white rounded-circle p-3 me-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div>
                            <span class="d-block fw-bold">Email Us</span>
                            <small class="text-muted"><?php echo htmlspecialchars($settings['email']); ?></small>
                        </div>
                    </a>
                </div>

                <div class="d-flex gap-3 mb-4">
                    <?php if(!empty($settings['facebook'])): ?>
                        <a href="<?php echo htmlspecialchars($settings['facebook']); ?>" target="_blank" class="btn btn-outline-primary rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 45px; height: 45px;"><i class="fab fa-facebook-f"></i></a>
                    <?php endif; ?>
                    <?php if(!empty($settings['instagram'])): ?>
                        <a href="<?php echo htmlspecialchars($settings['instagram']); ?>" target="_blank" class="btn btn-outline-danger rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 45px; height: 45px;"><i class="fab fa-instagram"></i></a>
                    <?php endif; ?>
                    <?php if(!empty($settings['tiktok'])): ?>
                        <a href="<?php echo htmlspecialchars($settings['tiktok']); ?>" target="_blank" class="btn btn-outline-dark rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 45px; height: 45px;"><i class="fab fa-tiktok"></i></a>
                    <?php endif; ?>
                    <a href="<?php echo htmlspecialchars($settings['whatsapp_link'] ?? 'https://wa.me/'.str_replace(['+',' '], '', $settings['whatsapp'])); ?>" target="_blank" class="btn btn-outline-success rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 45px; height: 45px;"><i class="fab fa-whatsapp"></i></a>
                </div>
                
                <button class="btn btn-success btn-lg rounded-pill px-5 shadow" data-bs-toggle="modal" data-bs-target="#bookingModal">Contact Us</button>
            </div>
            <div class="col-lg-7">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                    <iframe src="https://maps.google.com/maps?q=Palalla%20Road,%20Weligama,%20Sri%20Lanka&t=&z=14&ie=UTF8&iwloc=&output=embed" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Tour Details Modal -->
<div class="modal fade" id="tourDetailsModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg">
      <div class="modal-header border-0 pb-0 position-absolute w-100 z-3">
        <button type="button" class="btn-close btn-close-white bg-dark p-2 rounded-circle ms-auto me-3 mt-3 shadow" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-0">
        <img id="td-img" src="" class="img-fluid w-100 object-fit-cover" style="height: 300px;" alt="Tour Image">
        <div class="p-4 p-md-5">
            <div class="d-flex align-items-center mb-3">
                <span class="badge bg-success px-3 py-2 fs-6 rounded-pill" id="td-dur"></span>
            </div>
            <h2 class="fw-bold mb-3" id="td-title"></h2>
            <p class="text-muted lh-lg" id="td-desc"></p>
            
            <hr class="my-4">
            <div class="text-center">
                <button type="button" class="btn btn-primary btn-lg px-5 rounded-pill shadow-sm" id="bookThisTourBtn">
                    Book This Tour Now <i class="fas fa-arrow-right ms-2"></i>
                </button>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Safari Details Modal -->
<div class="modal fade" id="safariDetailsModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg">
      <div class="modal-header border-0 pb-0 position-absolute w-100 z-3">
        <button type="button" class="btn-close btn-close-white bg-dark p-2 rounded-circle ms-auto me-3 mt-3 shadow" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-0">
        <img id="sd-img" src="" class="img-fluid w-100 object-fit-cover" style="height: 350px;" alt="Safari Image">
        <div class="p-4 p-md-5">
            <div class="d-flex align-items-center mb-3">
                <span class="badge bg-success px-3 py-2 fs-6 rounded-pill"><i class="fas fa-leaf me-2"></i>Wildlife Safari</span>
            </div>
            <h2 class="fw-bold mb-3" id="sd-title"></h2>
            <p class="text-muted lh-lg fs-5" id="sd-desc"></p>
            
            <hr class="my-4">
            <div class="text-center">
                <button type="button" class="btn btn-success btn-lg px-5 rounded-pill shadow-sm" data-bs-dismiss="modal" onclick="setTimeout(() => new bootstrap.Modal(document.getElementById('bookingModal')).show(), 400);">
                    Book a Safari Experience
                </button>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Floating Tour Map Ad -->
<div class="tour-map-ad d-none" id="tourMapAd">
    <div class="close-ad" id="closeMapAd"><i class="fas fa-times"></i></div>
    <img src="assets/tour-map.jpg" alt="SL Tour Map">
    <span class="ad-label"><i class="fas fa-map-marked-alt me-1"></i> View Tour Map</span>
</div>

<!-- Full Screen Map Modal -->
<div class="modal fade modal-fullscreen" id="mapModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0 w-100 d-flex justify-content-between align-items-center px-4" style="position: absolute; top:0; z-index: 10;">
                <h4 class="text-white fw-bold mb-0">Sri Lanka Tour Map</h4>
                <button type="button" class="btn-close btn-close-white fs-4" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img src="assets/tour-map.jpg" class="map-full-img" alt="Sri Lanka Tour Map Full">
            </div>
            <div class="modal-footer border-0 justify-content-center pb-4">
                <button type="button" class="btn btn-primary px-5 rounded-pill fw-bold" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#taxiModal">Plan Your Route Now</button>
            </div>
        </div>
    </div>
</div>
<!-- Add Review Modal -->
<div class="modal fade" id="addReviewModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg">
      <div class="modal-header bg-success text-white border-0">
        <h5 class="modal-title"><i class="fas fa-star me-2"></i>Share Your Experience</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-4">
        <form id="addReviewForm">
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Country</label>
                <input type="text" name="country" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Rating</label>
                <div class="dropdown w-100">
                    <button class="btn btn-outline-secondary w-100 text-start d-flex justify-content-between align-items-center py-2" type="button" id="ratingDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="border-radius: 8px;">
                        <span id="selectedRating"><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i> 5 - Excellent</span>
                        <i class="fas fa-chevron-down small"></i>
                    </button>
                    <ul class="dropdown-menu w-100 shadow-sm border-0 mt-1 rounded-3" aria-labelledby="ratingDropdown">
                        <li><a class="dropdown-item py-2 rating-opt" href="#" data-value="5"><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i> 5 - Excellent</a></li>
                        <li><a class="dropdown-item py-2 rating-opt" href="#" data-value="4"><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="far fa-star text-warning"></i> 4 - Very Good</a></li>
                        <li><a class="dropdown-item py-2 rating-opt" href="#" data-value="3"><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="far fa-star text-warning"></i><i class="far fa-star text-warning"></i> 3 - Average</a></li>
                        <li><a class="dropdown-item py-2 rating-opt" href="#" data-value="2"><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="far fa-star text-warning"></i><i class="far fa-star text-warning"></i><i class="far fa-star text-warning"></i> 2 - Poor</a></li>
                        <li><a class="dropdown-item py-2 rating-opt" href="#" data-value="1"><i class="fas fa-star text-warning"></i><i class="far fa-star text-warning"></i><i class="far fa-star text-warning"></i><i class="far fa-star text-warning"></i><i class="far fa-star text-warning"></i> 1 - Terrible</a></li>
                    </ul>
                </div>
                <input type="hidden" name="rating" id="finalRating" value="5" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Review Message</label>
                <textarea name="message" class="form-control" rows="3" required></textarea>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-success px-4" id="submitReviewBtn">Submit Review</button>
            </div>
            <div id="reviewStatus" class="mt-3 text-center d-none"></div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Tour Details Modal Population
    const tourDetailsModal = document.getElementById('tourDetailsModal');
    if (tourDetailsModal) {
        tourDetailsModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const title = button.getAttribute('data-title');
            const desc = button.getAttribute('data-desc');
            const dur = button.getAttribute('data-dur');
            const img = button.getAttribute('data-img');
            
            document.getElementById('td-title').textContent = title;
            document.getElementById('td-desc').textContent = desc;
            document.getElementById('td-dur').textContent = dur;
            document.getElementById('td-img').src = img;
            
            // Set the "Book This Tour" button to open the global booking modal and pre-select this tour
            const bookBtn = document.getElementById('bookThisTourBtn');
            bookBtn.onclick = function() {
                const bModal = bootstrap.Modal.getInstance(tourDetailsModal);
                bModal.hide();
                setTimeout(() => {
                    const bookingModalInst = new bootstrap.Modal(document.getElementById('bookingModal'));
                    // Preselect the option
                    const select = document.getElementById('modalTourSelect');
                    let found = false;
                    for(let i=0; i<select.options.length; i++) {
                        if(select.options[i].value === title) {
                            select.selectedIndex = i;
                            found = true; break;
                        }
                    }
                    if(!found) {
                        // dynamically add option if it doesn't exist
                        const opt = new Option(title, title);
                        select.add(opt);
                        select.value = title;
                    }
                    bookingModalInst.show();
                }, 400); // Wait for fade out
            };
        });
    }

    // Safari Details Modal Population
    const safariDetailsModal = document.getElementById('safariDetailsModal');
    if (safariDetailsModal) {
        safariDetailsModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const title = button.getAttribute('data-title');
            const desc = button.getAttribute('data-desc');
            const img = button.getAttribute('data-img');
            
            document.getElementById('sd-title').textContent = title;
            document.getElementById('sd-desc').textContent = desc;
            document.getElementById('sd-img').src = img;
        });
    }

    // Add Review Form Submission
    const addReviewForm = document.getElementById('addReviewForm');
    if(addReviewForm) {
        addReviewForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const btn = document.getElementById('submitReviewBtn');
            const statusDiv = document.getElementById('reviewStatus');
            const formData = new FormData(this);

            btn.disabled = true;
            btn.innerHTML = 'Submitting...';
            
            fetch('review.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if(data.status === 'success') {
                    statusDiv.innerHTML = '<div class="alert alert-success py-2">Review submitted! It will appear after admin approval.</div>';
                    statusDiv.classList.remove('d-none');
                    addReviewForm.reset();
                    setTimeout(() => {
                        const modal = bootstrap.Modal.getInstance(document.getElementById('addReviewModal'));
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
                btn.innerHTML = 'Submit Review';
            });
        });
    }

    // Custom Rating Dropdown Logic
    const ratingOpts = document.querySelectorAll('.rating-opt');
    const finalRatingInput = document.getElementById('finalRating');
    const selectedRatingSpan = document.getElementById('selectedRating');

    ratingOpts.forEach(opt => {
        opt.addEventListener('click', function(e) {
            e.preventDefault();
            const val = this.getAttribute('data-value');
            finalRatingInput.value = val;
            selectedRatingSpan.innerHTML = this.innerHTML;
        });
    });

    // Tour Map Ad Logic
    const ad = document.getElementById('tourMapAd');
    const closeBtn = document.getElementById('closeMapAd');
    const mapModal = new bootstrap.Modal(document.getElementById('mapModal'));

    if(ad) {
        // Show ad after 3 seconds
        setTimeout(() => {
            ad.classList.remove('d-none');
        }, 3000);

        ad.addEventListener('click', (e) => {
            if(e.target.closest('#closeMapAd')) return;
            mapModal.show();
        });

        closeBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            ad.classList.add('d-none');
        });
    }
});
</script>

<!-- Developer Highlight Section (Body) -->
<section class="py-5 bg-white border-top">
    <div class="container text-center">
        <div class="d-inline-block p-4 rounded-4 shadow-sm border border-light animate__animated animate__fadeInUp">
            <p class="text-muted mb-2 small text-uppercase tracking-widest fw-bold">Professional Web Solutions</p>
            <h3 class="fw-bold mb-3">Designed & Developed By</h3>
            <div class="d-flex align-items-center justify-content-center gap-3 mb-3" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#developerModal">
                <img src="assets/developer.jpg" class="rounded-circle shadow-sm border border-success border-2" style="width: 80px; height: 80px; object-fit: cover;" alt="Malitha Tishamal">
                <div class="text-start">
                    <h4 class="mb-0 fw-bold text-dark">Malitha Tishamal</h4>
                    <p class="text-success mb-0 fw-medium">Full Stack Developer</p>
                </div>
            </div>
            <div class="d-flex justify-content-center gap-2 mb-3">
                <a href="http://malithatishamal.42web.io" target="_blank" class="btn btn-outline-secondary btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;"><i class="bi bi-globe"></i></a>
                <a href="https://x.com/MalithaTishamal" target="_blank" class="btn btn-outline-secondary btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;"><i class="bi bi-twitter-x"></i></a>
                <a href="https://www.linkedin.com/in/malitha-tishamal" target="_blank" class="btn btn-outline-secondary btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;"><i class="bi bi-linkedin"></i></a>
                <a href="https://github.com/malitha-tishamal" target="_blank" class="btn btn-outline-secondary btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;"><i class="bi bi-github"></i></a>
            </div>
            <a href="https://wa.me/94785530992" target="_blank" class="btn btn-success rounded-pill px-4 fw-bold">
                <i class="fab fa-whatsapp me-2"></i> Hire the Developer
            </a>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
