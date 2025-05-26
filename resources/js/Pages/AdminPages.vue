
<template>
    <div class="admin-layout">
      <aside class="sidebar">
        <div class="logo">Админ-панель</div>
        <nav>
          <Link :href="route('admin.products.index')" class="nav-link">
            Товары
          </Link>
        </nav>
      </aside>
      
      <main class="content">
        <header class="header">
          <div class="user-info">
            {{ $page.props.auth.user.name }}
            <Link :href="route('logout')" method="post" class="logout-btn">
              Выйти
            </Link>
          </div>
        </header>
        
        <slot />
      </main>
    </div>
  </template>
  
  <script setup>
  import { Link } from '@inertiajs/vue3';
  </script>
  
  <style scoped>
  .admin-layout {
    display: flex;
    min-height: 100vh;
  }
  
  .sidebar {
    width: 250px;
    background: #2c3e50;
    color: white;
    padding: 20px 0;
  }
  
  .logo {
    padding: 0 20px 20px;
    font-size: 20px;
    font-weight: bold;
    border-bottom: 1px solid rgba(255,255,255,0.1);
    margin-bottom: 20px;
  }
  
  .nav-link {
    display: block;
    padding: 10px 20px;
    color: white;
    text-decoration: none;
    transition: background 0.3s;
  }
  
  .nav-link:hover {
    background: rgba(255,255,255,0.1);
  }
  
  .content {
    flex: 1;
    background: #f5f5f5;
  }
  
  .header {
    background: white;
    padding: 15px 20px;
    display: flex;
    justify-content: flex-end;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
  }
  
  .user-info {
    display: flex;
    align-items: center;
    gap: 15px;
  }
  
  .logout-btn {
    color: #888;
    text-decoration: none;
    font-size: 14px;
  }
  
  .logout-btn:hover {
    color: #333;
  }
  </style>