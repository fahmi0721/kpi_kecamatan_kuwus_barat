@foreach($buku as $book)
@php
    $img = !empty($book->cover) ? "/uploads/images/".$book->cover : "/uploads/default_book.jpg";
@endphp
<div class="col-md-4 col-lg-3 book-item">
    <div class="card h-100 shadow-sm border-0">
        <img src="{{ $img }}" style='max-height:250px' class="card-img-top" alt="Cover Buku">
        <div class="card-body">
            <h5 class="card-text book-title text-center">{{ $book->judul }}</h5>
            <p class="card-text text-muted mb-1">Penulis: {{ $book->penulis }}</p>
            <p class="card-text text-muted mb-1">Penerbit: {{ $book->penerbit }}</p>
            <p class="card-text text-muted mb-1">Tahun: {{ $book->tahun_terbit }}</p>
            <span class="badge bg-success">{{ $book->stok_buku->status_stok }}</span>
        </div>
        <div class="card-footer bg-white border-0">
            <button class="btn btn-primary w-100">Detail Buku</button>
        </div>
    </div>
</div>
@endforeach