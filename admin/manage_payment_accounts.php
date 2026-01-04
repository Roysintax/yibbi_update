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
                    <i class="fas fa-university me-3"></i>Manage Payment Accounts
                </h1>
                <p class="text-muted mb-0 mt-2">Kelola rekening bank dan e-wallet untuk donasi</p>
            </div>
            <div class="btn-toolbar mb-2 mb-md-0">
                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addAccountModal">
                    <i class="fas fa-plus me-2"></i>Add New Account
                </button>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    <?php if (isset($_GET['status'])): ?>
        <?php if ($_GET['status'] == 'success'): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>Data rekening berhasil disimpan!
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php elseif ($_GET['status'] == 'deleted'): ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>Data rekening berhasil dihapus!
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php elseif ($_GET['status'] == 'updated'): ?>
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>Data rekening berhasil diperbarui!
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <!-- Payment Accounts Table -->
    <div class="card border-0 shadow-sm mt-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0 p-3 ps-4">Icon</th>
                            <th class="border-0 p-3">Bank/E-Wallet</th>
                            <th class="border-0 p-3">Account Number</th>
                            <th class="border-0 p-3">Account Name</th>
                            <th class="border-0 p-3 text-center">Type</th>
                            <th class="border-0 p-3 text-center">Order</th>
                            <th class="border-0 p-3 text-center">Active</th>
                            <th class="border-0 p-3 text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $stmt = $pdo->query("SELECT * FROM payment_accounts ORDER BY display_order ASC, id DESC");
                        $accounts = $stmt->fetchAll();

                        if (count($accounts) > 0) {
                            foreach($accounts as $account) {
                                $isActive = $account['is_active'] == 1 ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-secondary">Inactive</span>';
                                $typeLabel = $account['account_type'] == 'bank' ? '<span class="badge bg-primary">Bank</span>' : '<span class="badge bg-info">E-Wallet</span>';
                                ?>
                                <tr>
                                    <td class="p-3 ps-4" style="width: 80px;">
                                        <?php if (!empty($account['icon'])): ?>
                                            <img src="../<?php echo htmlspecialchars($account['icon']); ?>" alt="Icon" class="img-fluid rounded" style="height: 40px; width: 40px; object-fit: contain;">
                                        <?php else: ?>
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 40px; width: 40px;">
                                                <i class="fas fa-university text-muted"></i>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td class="p-3">
                                        <h6 class="mb-0 fw-bold"><?php echo htmlspecialchars($account['bank_name']); ?></h6>
                                    </td>
                                    <td class="p-3">
                                        <code class="bg-light px-2 py-1 rounded"><?php echo htmlspecialchars($account['account_number']); ?></code>
                                    </td>
                                    <td class="p-3">
                                        <span class="text-muted"><?php echo htmlspecialchars($account['account_name']); ?></span>
                                    </td>
                                    <td class="p-3 text-center">
                                        <?php echo $typeLabel; ?>
                                    </td>
                                    <td class="p-3 text-center">
                                        <span class="badge bg-primary"><?php echo $account['display_order']; ?></span>
                                    </td>
                                    <td class="p-3 text-center">
                                        <?php echo $isActive; ?>
                                    </td>
                                    <td class="p-3 text-end pe-4">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="tooltip" title="Edit" onclick="editAccount(<?php echo $account['id']; ?>)">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" title="Delete" onclick="confirmDelete(<?php echo $account['id']; ?>)">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo '<tr><td colspan="8" class="text-center p-5 text-muted">Belum ada rekening pembayaran. Silakan tambahkan rekening baru.</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<!-- Add Account Modal -->
<div class="modal fade" id="addAccountModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-plus-circle me-2"></i>Add New Payment Account
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="addAccountForm" action="process_payment_account.php" method="POST">
                <input type="hidden" name="action" value="add">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="bank_name" class="form-label">Bank/E-Wallet Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="bank_name" name="bank_name" placeholder="BCA, BNI, Mandiri, Gopay" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="account_type" class="form-label">Account Type <span class="text-danger">*</span></label>
                            <select class="form-select" id="account_type" name="account_type" required>
                                <option value="bank">Bank</option>
                                <option value="ewallet">E-Wallet</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="account_number" class="form-label">Account Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="account_number" name="account_number" placeholder="1234567890" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="account_name" class="form-label">Account Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="account_name" name="account_name" placeholder="Yayasan YIBBI" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="display_order" class="form-label">Display Order</label>
                            <input type="number" class="form-control" id="display_order" name="display_order" value="0">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="is_active" class="form-label">Status</label>
                            <select class="form-select" id="is_active" name="is_active">
                                <option value="1" selected>Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Icon (Optional)</label>
                        <input type="file" class="form-control" id="icon" name="icon" accept="image/*">
                        <small class="text-muted">Upload icon bank/e-wallet (recommended 100x100px)</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Save Account
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Account Modal -->
<div class="modal fade" id="editAccountModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-edit me-2"></i>Edit Payment Account
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editAccountForm" action="process_payment_account.php" method="POST">
                <input type="hidden" name="action" value="edit">
                <input type="hidden" name="id" id="edit_id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_bank_name" class="form-label">Bank/E-Wallet Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_bank_name" name="bank_name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_account_type" class="form-label">Account Type <span class="text-danger">*</span></label>
                            <select class="form-select" id="edit_account_type" name="account_type" required>
                                <option value="bank">Bank</option>
                                <option value="ewallet">E-Wallet</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_account_number" class="form-label">Account Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_account_number" name="account_number" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_account_name" class="form-label">Account Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_account_name" name="account_name" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_display_order" class="form-label">Display Order</label>
                            <input type="number" class="form-control" id="edit_display_order" name="display_order">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_is_active" class="form-label">Status</label>
                            <select class="form-select" id="edit_is_active" name="is_active">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Current Icon</label>
                        <div class="mb-2">
                            <img id="edit_current_icon" src="" alt="Current Icon" class="img-thumbnail" style="max-height: 80px; display: none;">
                            <span id="edit_no_icon" class="text-muted">No icon</span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_icon" class="form-label">Change Icon (Optional)</label>
                        <input type="file" class="form-control" id="edit_icon" name="icon" accept="image/*">
                        <small class="text-muted">Leave empty to keep current icon</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Update Account
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function editAccount(id) {
    fetch('get_payment_account.php?id=' + id)
        .then(response => response.json())
        .then(data => {
            document.getElementById('edit_id').value = data.id;
            document.getElementById('edit_bank_name').value = data.bank_name;
            document.getElementById('edit_account_type').value = data.account_type;
            document.getElementById('edit_account_number').value = data.account_number;
            document.getElementById('edit_account_name').value = data.account_name;
            document.getElementById('edit_display_order').value = data.display_order;
            document.getElementById('edit_is_active').value = data.is_active;
            
            if (data.icon) {
                document.getElementById('edit_current_icon').src = '../' + data.icon;
                document.getElementById('edit_current_icon').style.display = 'block';
                document.getElementById('edit_no_icon').style.display = 'none';
            } else {
                document.getElementById('edit_current_icon').style.display = 'none';
                document.getElementById('edit_no_icon').style.display = 'block';
            }
            
            new bootstrap.Modal(document.getElementById('editAccountModal')).show();
        });
}

function confirmDelete(id) {
    if (confirm('Apakah Anda yakin ingin menghapus rekening ini?')) {
        window.location.href = 'delete_payment_account.php?id=' + id;
    }
}

// Initialize tooltips
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
});
</script>

<?php include 'includes/footer.php'; ?>
