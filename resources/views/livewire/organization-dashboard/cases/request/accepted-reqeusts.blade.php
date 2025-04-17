<div class="row row-cols-1 row-cols-md-3 g-4 mt-3">
    @foreach ($requests as $request)
        <div class="col">
            <div class="card" style="min-height: 400px;"> 
                <img src="{{ asset('storage/' . $request->case_photo) }}" class="card-img-top" alt="صورة المشروع" style="object-fit: cover; height: 200px;">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ $request->case_name }}</h5>
                    <p class="card-text ">
                        {{ $request->description }}
                    </p>
                </div>
                <div class="card-footer" style="background-color: rgba(7, 204, 253, 0.6);">
                    <small class="text-white">تمت المراجعة : {{ $request->reviewed_at }}</small>
                  </div>
            </div>
        </div>
    @endforeach
</div>
