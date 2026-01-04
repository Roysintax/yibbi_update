<?php
// ========================================
// Konfigurasi Database PDO
// ========================================
require_once 'config/database.php';


    // Fetch payment accounts
    $stmt = $pdo->query("SELECT * FROM payment_accounts WHERE is_active = 1 ORDER BY display_order ASC");
    $payment_accounts = $stmt->fetchAll();
    
    // Fetch WhatsApp number from settings
    $stmt = $pdo->query("SELECT whatsapp_donation FROM settings LIMIT 1");
    $settings = $stmt->fetch();
    $whatsapp = $settings['whatsapp_donation'] ?? '6281234567890';


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donate - Yayasan YIBBI</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        .page-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 60px 0;
            margin-bottom: 50px;
        }
        
        .payment-account-card {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .payment-account-card:hover {
            border-color: #667eea;
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.2);
            transform: translateY(-2px);
        }
        
        .payment-account-card.selected {
            border-color: #667eea;
            background-color: #f8f9ff;
        }
        
        .account-icon {
            width: 60px;
            height: 60px;
            object-fit: contain;
            margin-bottom: 10px;
        }
        
        .account-number {
            font-family: 'Courier New', monospace;
            font-size: 18px;
            font-weight: bold;
            color: #333;
            background: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
            position: relative;
        }
        
        .copy-btn {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #667eea;
        }
        
        .copy-btn:hover {
            color: #764ba2;
        }
        
        .form-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            padding: 30px;
        }
        
        .btn-donate {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 12px 40px;
            font-size: 16px;
            font-weight: 600;
        }
        
        .btn-whatsapp {
            background: #25D366;
            border: none;
            padding: 12px 40px;
            font-size: 16px;
            font-weight: 600;
        }
        
        .btn-whatsapp:hover {
            background: #128C7E;
        }
        
        .upload-area {
            border: 2px dashed #ddd;
            border-radius: 10px;
            padding: 30px;
            text-align: center;
            transition: all 0.3s ease;
        }
        
        .upload-area:hover {
            border-color: #667eea;
            background: #f8f9ff;
        }
        
        .upload-area.has-file {
            border-color: #28a745;
            background: #f0f9f4;
        }
        
        #preview-image {
            max-width: 100%;
            max-height: 300px;
            margin-top: 15px;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <!-- Page Header -->
    <div class="page-header">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h1 class="display-4 fw-bold mb-3">
                        <i class="fas fa-hand-holding-heart me-3"></i>Donate for Our Program
                    </h1>
                    <p class="lead">Your contribution makes a difference in our community</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mb-5">
        <?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                <strong>Terima kasih!</strong> Donasi Anda telah diterima dan sedang diverifikasi oleh admin.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <div class="row">
            <!-- Left Column: Payment Accounts -->
            <div class="col-lg-5 mb-4">
                <div class="sticky-top" style="top: 20px;">
                    <h3 class="mb-4">
                        <i class="fas fa-university me-2"></i>Transfer ke Rekening:
                    </h3>
                    
                    <?php foreach ($payment_accounts as $account): ?>
                        <div class="payment-account-card" data-account-id="<?php echo $account['id']; ?>">
                            <div class="d-flex align-items-center mb-3">
                                <?php if (!empty($account['icon'])): ?>
                                    <img src="<?php echo htmlspecialchars($account['icon']); ?>" alt="<?php echo htmlspecialchars($account['bank_name']); ?>" class="account-icon me-3">
                                <?php else: ?>
                                    <div class="account-icon me-3 bg-light rounded d-flex align-items-center justify-content-center">
                                        <i class="fas fa-university fa-2x text-muted"></i>
                                    </div>
                                <?php endif; ?>
                                <div>
                                    <h5 class="mb-0"><?php echo htmlspecialchars($account['bank_name']); ?></h5>
                                    <small class="text-muted">
                                        <?php echo $account['account_type'] == 'bank' ? 'Bank Transfer' : 'E-Wallet'; ?>
                                    </small>
                                </div>
                            </div>
                            
                            <div class="account-number" style="position: relative;">
                                <span id="account-<?php echo $account['id']; ?>"><?php echo htmlspecialchars($account['account_number']); ?></span>
                                <i class="fas fa-copy copy-btn" onclick="copyAccount(<?php echo $account['id']; ?>)" title="Copy"></i>
                            </div>
                            
                            <div class="mt-2">
                                <small class="text-muted">a/n: <strong><?php echo htmlspecialchars($account['account_name']); ?></strong></small>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    
                    <?php if (empty($payment_accounts)): ?>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>Belum ada rekening tersedia saat ini.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Right Column: Donation Form -->
            <div class="col-lg-7">
                <div class="form-card">
                    <h3 class="mb-4">
                        <i class="fas fa-clipboard-list me-2"></i>Form Donasi
                    </h3>
                    
                    <form action="process_donation.php" method="POST" enctype="multipart/form-data" id="donationForm">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="donor_name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="donor_name" name="donor_name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="donor_phone" class="form-label">Nomor HP <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control" id="donor_phone" name="donor_phone" placeholder="08123456789" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="donor_email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="donor_email" name="donor_email" placeholder="email@example.com">
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="amount" class="form-label">Jumlah Donasi (Rp) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="amount" name="amount" min="1" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="payment_account_id" class="form-label">Rekening Tujuan <span class="text-danger">*</span></label>
                                <select class="form-select" id="payment_account_id" name="payment_account_id" required>
                                    <option value="">Pilih Rekening</option>
                                    <?php foreach ($payment_accounts as $account): ?>
                                        <option value="<?php echo $account['id']; ?>">
                                            <?php echo htmlspecialchars($account['bank_name']) . ' - ' . htmlspecialchars($account['account_number']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="payment_proof" class="form-label">Upload Bukti Transfer <span class="text-danger">*</span></label>
                            <div class="upload-area" id="uploadArea">
                                <input type="file" class="d-none" id="payment_proof" name="payment_proof" accept="image/*" required onchange="previewImage(this)">
                                <label for="payment_proof" style="cursor: pointer; width: 100%;">
                                    <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3 d-block"></i>
                                    <p class="mb-0">Klik untuk upload bukti transfer</p>
                                    <small class="text-muted">Format: JPG, PNG (Max 5MB)</small>
                                </label>
                                <img id="preview-image" src="" alt="Preview" style="display: none;">
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="message" class="form-label">Pesan (Optional)</label>
                            <textarea class="form-control" id="message" name="message" rows="3" placeholder="Tulis pesan Anda..."></textarea>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-donate">
                                <i class="fas fa-paper-plane me-2"></i>Kirim Donasi
                            </button>
                            <a href="https://wa.me/<?php echo $whatsapp; ?>?text=Halo,%20saya%20ingin%20konsultasi%20tentang%20donasi" 
                               target="_blank" class="btn btn-success btn-whatsapp">
                                <i class="fab fa-whatsapp me-2"></i>Konsultasi via WhatsApp
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Copy account number to clipboard
        function copyAccount(id) {
            const text = document.getElementById('account-' + id).textContent;
            navigator.clipboard.writeText(text).then(() => {
                // Show success feedback
                const btn = event.target;
                btn.classList.remove('fa-copy');
                btn.classList.add('fa-check');
                btn.style.color = '#28a745';
                
                setTimeout(() => {
                    btn.classList.remove('fa-check');
                    btn.classList.add('fa-copy');
                    btn.style.color = '';
                }, 2000);
            });
        }
        
        // Select payment account
        document.querySelectorAll('.payment-account-card').forEach(card => {
            card.addEventListener('click', function() {
                // Remove selected class from all
                document.querySelectorAll('.payment-account-card').forEach(c => c.classList.remove('selected'));
                
                // Add selected class to clicked
                this.classList.add('selected');
                
                // Update select dropdown
                const accountId = this.getAttribute('data-account-id');
                document.getElementById('payment_account_id').value = accountId;
            });
        });
        
        // Preview uploaded image
        function previewImage(input) {
            const preview = document.getElementById('preview-image');
            const uploadArea = document.getElementById('uploadArea');
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                    uploadArea.classList.add('has-file');
                };
                
                reader.readAsDataURL(input.files[0]);
            }
        }
        
        // Form validation
        document.getElementById('donationForm').addEventListener('submit', function(e) {
            const paymentProof = document.getElementById('payment_proof');
            if (!paymentProof.files.length) {
                e.preventDefault();
                alert('Harap upload bukti transfer terlebih dahulu!');
                return false;
            }
        });
    </script>
<?php include 'includes/footer.php'; ?>
