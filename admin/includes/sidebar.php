<style>
    .sidebar-wrapper {
        width: 280px;
        min-height: 100vh;
        background: var(--sidebar-bg);
        box-shadow: 5px 0 20px rgba(0, 0, 0, 0.1);
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease; /* Add transition for smoothness */
    }
    
    .sidebar-wrapper::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 200px;
        background: radial-gradient(circle at top, rgba(102, 126, 234, 0.3), transparent);
        pointer-events: none;
    }
    
    .sidebar-brand {
        padding: 2rem 1.5rem;
        text-decoration: none;
        color: white;
        text-align: center;
        position: relative;
        z-index: 1;
    }
    
    .sidebar-brand h4 {
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0;
        background: linear-gradient(135deg, #667eea 0%, #f5f7fa 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    .sidebar-brand small {
        color: rgba(255, 255, 255, 0.7);
        font-size: 0.8rem;
        display: block;
        margin-top: 0.25rem;
    }
    
    .sidebar-divider {
        border-color: rgba(255, 255, 255, 0.1);
        margin: 1rem 0;
    }
    
    .sidebar-nav {
        padding: 0 1rem;
    }
    
    .sidebar-nav .nav-link {
        color: rgba(255, 255, 255, 0.8);
        border-radius: 12px;
        padding: 0.875rem 1.25rem;
        margin-bottom: 0.5rem;
        transition: all 0.3s ease;
        font-weight: 500;
        position: relative;
        overflow: hidden;
    }
    
    .sidebar-nav .nav-link::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
        transition: left 0.5s ease;
    }
    
    .sidebar-nav .nav-link:hover::before {
        left: 100%;
    }
    
    .sidebar-nav .nav-link:hover {
        background: rgba(255, 255, 255, 0.1);
        color: white;
        transform: translateX(5px);
    }
    
    .sidebar-nav .nav-link.active {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    }
    
    .sidebar-nav .nav-link i {
        margin-right: 0.75rem;
        width: 20px;
        text-align: center;
    }
    
    .sidebar-footer {
        margin-top: auto;
        padding: 1.5rem;
    }
    
    .user-profile {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 15px;
        padding: 1rem;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .user-profile:hover {
        background: rgba(255, 255, 255, 0.1);
        transform: translateY(-2px);
    }
    
    .user-profile img {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        border: 3px solid rgba(255, 255, 255, 0.2);
        object-fit: cover;
    }
    
    .user-info {
        flex-grow: 1;
        margin-left: 1rem;
    }
    
    .user-info strong {
        display: block;
        color: white;
        font-size: 1rem;
        margin-bottom: 0.2rem;
    }
    
    .user-info small {
        color: rgba(255, 255, 255, 0.6);
        font-size: 0.8rem;
    }
    
    .dropdown-menu-dark {
        background: rgba(30, 30, 47, 0.95);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    }
    
    .dropdown-item {
        border-radius: 8px;
        margin: 0.25rem;
        transition: all 0.2s ease;
    }
    
    .dropdown-item:hover {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
</style>

<!-- Sidebar Menu -->
<div class="sidebar-wrapper d-flex flex-column flex-shrink-0">
    <a href="index.php" class="sidebar-brand">
        <h4>
            <i class="fas fa-mosque me-2"></i>Hafsa
        </h4>
        <small>Admin Dashboard</small>
    </a>
    
    <hr class="sidebar-divider">
    
    <ul class="nav nav-pills flex-column sidebar-nav mb-auto">
        <li class="nav-item">
            <a href="index.php" class="nav-link active" aria-current="page">
                <i class="fas fa-home"></i>
                Home
            </a>
        </li>
        <!-- Sidebar item lain sengaja dikosongkan sesuai permintaan -->
    </ul>
    
    <hr class="sidebar-divider">
    
    <div class="sidebar-footer">
        <div class="dropdown">
            <a href="#" class="user-profile d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="../assets/images/logo/01.png" alt="Admin">
                <div class="user-info">
                    <strong>Admin</strong>
                    <small>Administrator</small>
                </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Profile</a></li>
                <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Settings</a></li>
                <li><hr class="dropdown-divider" style="border-color: rgba(255,255,255,0.1);"></li>
                <li><a class="dropdown-item" href="#"><i class="fas fa-sign-out-alt me-2"></i>Sign out</a></li>
            </ul>
        </div>
    </div>
</div>
