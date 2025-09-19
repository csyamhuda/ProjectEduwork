@extends('layout')
@section('title', 'Keranjang - Toko Online')
@section('content')
    <!-- Konten Keranjang -->
    <div class="container my-5">
        <h2 class="mb-4">Keranjang Belanja</h2>

        @if(count($cartItems) > 0)
            <table class="table table-bordered align-middle text-center">
                <thead class="table-dark">
                    <tr>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @php $grandTotal = 0; @endphp
                    @foreach($cartItems as $item)
                        @php 
                            $total = $item['harga'] * $item['qty']; 
                            $grandTotal += $total; 
                        @endphp
                        <tr>
                            <td>{{ $item['nama'] }}</td>
                            <td>Rp{{ number_format($item['harga'], 0, ',', '.') }}</td>
                            <td>{{ $item['qty'] }}</td>
                            <td>Rp{{ number_format($total, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="fw-bold">
                        <td colspan="3" class="text-end">Grand Total</td>
                        <td>Rp{{ number_format($grandTotal, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
            <div class="text-end">
                <a href="#" class="btn btn-success">Checkout</a>
            </div>
        @else
            <div class="alert alert-warning">Keranjang belanja masih kosong.</div>
        @endif
    </div>
@endsection