@extends('layout')
@section('title', 'Beranda - Toko Online')
@section('content')
  <!-- Hero Section -->
  <div class="bg-light py-5 text-center">
    <div class="container">
      <h1 class="fw-bold">Selamat Datang di Toko Online</h1>
      <p class="lead">Temukan produk terbaik dengan harga termurah!</p>
      <a href="#produk" class="btn btn-primary btn-lg">Belanja Sekarang</a>
    </div>
  </div>

  <!-- Produk -->
  <div class="container my-5" id="produk">
    <h2 class="mb-4 text-center">Produk Kami</h2>
    <div class="row g-4">
      <!-- Produk 1 -->
      <div class="col-md-3">
        <div class="card h-100 shadow-sm">
          <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Produk 1">
          <div class="card-body text-center">
            <h5 class="card-title">Produk 1</h5>
            <p class="card-text text-muted">Rp100.000</p>
            <a href="#" class="btn btn-success">Tambah ke Keranjang</a>
          </div>
        </div>
      </div>
      <!-- Produk 2 -->
      <div class="col-md-3">
        <div class="card h-100 shadow-sm">
          <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Produk 2">
          <div class="card-body text-center">
            <h5 class="card-title">Produk 2</h5>
            <p class="card-text text-muted">Rp150.000</p>
            <a href="#" class="btn btn-success">Tambah ke Keranjang</a>
          </div>
        </div>
      </div>
      <!-- Produk 3 -->
      <div class="col-md-3">
        <div class="card h-100 shadow-sm">
          <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Produk 3">
          <div class="card-body text-center">
            <h5 class="card-title">Produk 3</h5>
            <p class="card-text text-muted">Rp200.000</p>
            <a href="#" class="btn btn-success">Tambah ke Keranjang</a>
          </div>
        </div>
      </div>
      <!-- Produk 4 -->
      <div class="col-md-3">
        <div class="card h-100 shadow-sm">
          <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Produk 4">
          <div class="card-body text-center">
            <h5 class="card-title">Produk 4</h5>
            <p class="card-text text-muted">Rp250.000</p>
            <a href="#" class="btn btn-success">Tambah ke Keranjang</a>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection