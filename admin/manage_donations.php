<?php
require_once 'auth_check.php';
include 'includes/header.php';
?>

<?php include 'includes/sidebar.php'; ?>

<main class="main-content">
    <div class="page-header-wrapper">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
            <div>
                <h1>
                    <i class="fas fa-list-alt me-3"></i>Manage Donations
                </h1>
                <p class="text-muted mb-0 mt-2">Lihat dan verifikasi donasi yang masuk</p>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    <?php if (isset($_GET['status'])): ?>
        <?php if ($_GET['status'] == 'verified'): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>Donasi berhasil diverifikasi!
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php elseif ($_GET['status'] == 'rejected'): ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="fas fa-times-circle me-2"></i>Donasi ditolak!
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <!-- Filter -->
    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Filter by Status:</label>
                    <select name="status_filter" class="form-select" onchange="this.form.submit()">
                        <option value="">All Status</option>
                        <option value="pending" <?php echo (isset($_GET['status_filter']) && $_GET['status_filter'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
                        <option value="verified" <?php echo (isset($_GET['status_filter']) && $_GET['status_filter'] == 'verified') ? 'selected' : ''; ?>>Verified</option>
                        <option value="rejected" <?php echo (isset($_GET['status_filter']) && $_GET['status_filter'] == 'rejected') ? 'selected' : ''; ?>>Rejected</option>
                    </select>
                </div>
            </form>
        </div>
    </div>

    <!-- Donations Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0 p-3 ps-4">Date</th>
                            <th class="border-0 p-3">Donor Info</th>
                            <th class="border-0 p-3">Payment To</th>
                            <th class="border-0 p-3 text-end">Amount</th>
                            <th class="border-0 p-3 text-center">Proof</th>
                            <th class="border-0 p-3 text-center">Status</th>
                            <th class="border-0 p-3 text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $whereClause = '';
                        if (isset($_GET['status_filter']) && !empty($_GET['status_filter'])) {
                            $status = $_GET['status_filter'];
                            $whereClause = "WHERE d.status = " . $pdo->quote($status);
                        }
                        
                        $stmt = $pdo->query("
                            SELECT d.*, p.bank_name, p.account_number 
                            FROM donations d
                            LEFT JOIN payment_accounts p ON d.payment_account_id = p.id
                            $whereClause
                            ORDER BY d.created_at DESC
                        ");
                        $donations = $stmt->fetchAll();

                        if (count($donations) > 0) {
                            foreach($donations as $donation) {
                                $statusBadge = '';
                                switch($donation['status']) {
                                    case 'pending':
                                        $statusBadge = '<span class="badge bg-warning">Pending</span>';
                                        break;
                                    case 'verified':
                                        $statusBadge = '<span class="badge bg-success">Verified</span>';
                                        break;
                                    case 'rejected':
                                        $statusBadge = '<span class="badge bg-danger">Rejected</span>';
                                        break;
                                }
                                ?>
                                <tr>
                                    <td class="p-3 ps-4">
                                        <small><?php echo date('d M Y H:i', strtotime($donation['created_at'])); ?></small>
                                    </td>
                                    <td class="p-3">
                                        <h6 class="mb-0 fw-bold"><?php echo htmlspecialchars($donation['donor_name']); ?></h6>
                                        <small class="text-muted"><?php echo htmlspecialchars($donation['donor_phone']); ?></small><br>
                                        <small class="text-muted"><?php echo htmlspecialchars($donation['donor_email']); ?></small>
                                    </td>
                                    <td class="p-3">
                                        <strong><?php echo htmlspecialchars($donation['bank_name']); ?></strong><br>
                                        <code class="small"><?php echo htmlspecialchars($donation['account_number']); ?></code>
                                    </td>
                                    <td class="p-3 text-end">
                                        <strong class="text-primary">Rp <?php echo number_format($donation['amount'], 0, ',', '.'); ?></strong>
                                    </td>
                                    <td class="p-3 text-center">
                                        <button class="btn btn-sm btn-outline-info" onclick="viewProof('<?php echo htmlspecialchars($donation['payment_proof']); ?>')">
                                            <i class="fas fa-image"></i> View
                                        </button>
                                    </td>
                                    <td class="p-3 text-center">
                                        <?php echo $statusBadge; ?>
                                    </td>
                                    <td class="p-3 text-end pe-4">
                                        <?php if ($donation['status'] == 'pending'): ?>
                                            <div class="btn-group">
                                                <a href="verify_donation.php?id=<?php echo $donation['id']; ?>&action=verify" class="btn btn-sm btn-success" title="Verify">
                                                    <i class="fas fa-check"></i>
                                                </a>
                                                <a href="verify_donation.php?id=<?php echo $donation['id']; ?>&action=reject" class="btn btn-sm btn-danger" title="Reject">
                                                    <i class="fas fa-times"></i>
                                                </a>
                                            </div>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo '<tr><td colspan="7" class="text-center p-5 text-muted">Belum ada donasi.</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<!-- View Proof Modal -->
<div class="modal fade" id="proofModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Payment Proof</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="proofImage" src="" alt="Payment Proof" class="img-fluid">
            </div>
        </div>
    </div>
</div>

<script>
function viewProof(imagePath) {
    document.getElementById('proofImage').src = '../' + imagePath;
    new bootstrap.Modal(document.getElementById('proofModal')).show();
}
</script>

<?php include 'includes/footer.php'; ?>
