
<div class="container py-5">

    <div class="text-center mb-4">
        <h2 class="fw-bold">Katalog Buku</h2>
        <p class="text-muted">Daftar koleksi buku perpustakaan</p>
    </div>

    <!-- Search -->
    <div class="row mb-4">
        <div class="col-md-6 mx-auto">
            <input type="text" id="searchInput" class="form-control" placeholder="Cari judul buku...">
        </div>
    </div>

    <!-- Katalog -->
    <div class="row g-4" id="bookList">

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
                    <a href="{{ route('dashboard.katalog_buku.show',[$book->id]) }}" class="btn btn-primary w-100">Detail Buku</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="text-center my-4" id="loading" style="display: none;">
        <div class="spinner-border text-primary" role="status"></div>
        <p class="mt-2 text-muted">Memuat buku...</p>
    </div>

    <div class="text-center my-4" id="end-message" style="display: none;">
        <p class="text-muted">Semua buku sudah ditampilkan.</p>
    </div>
</div>

@section('js')
<script>
    let offset = 12;
    let loading = false;
    let finished = false;

    window.addEventListener('scroll', function () {
        if (loading || finished) return;

        let scrollPosition = window.innerHeight + window.scrollY;
        let pageHeight = document.body.offsetHeight;

        if (scrollPosition >= pageHeight - 200) {
            loadMoreBooks();
        }
    });

    function loadMoreBooks() {
        loading = true;
        document.getElementById('loading').style.display = 'block';

        fetch(`{{ route('dashboard.katalog_buku.load') }}?offset=${offset}`)
            .then(response => response.text())
            .then(html => {
                document.getElementById('loading').style.display = 'none';

                if (html.trim() === '') {
                    finished = true;
                    document.getElementById('end-message').style.display = 'block';
                    return;
                }

                document.getElementById('bookList').insertAdjacentHTML('beforeend', html);

                offset += 12;
                loading = false;
            })
            .catch(error => {
                console.error(error);
                document.getElementById('loading').style.display = 'none';
                loading = false;
            });
    }
</script>

@endsection;
