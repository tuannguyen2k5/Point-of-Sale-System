@if ($errors->any())
<div class="alert alert-danger alert-dismissible fade show w-100" role="alert">
  <div>
    The form has errors, please see bellow!
  </div>
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if (session()->has('success'))
<div class="alert alert-success alert-dismissible fade show w-100" role="alert">
  <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:">
    <use xlink:href="#check-circle-fill" /></svg>
  <div>
    {{ session('success')}}
  </div>
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if (session()->has('info'))
<div class="alert alert-warning alert-dismissible fade show w-100" role="alert">
  <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:">
    <use xlink:href="#check-circle-fill" /></svg>
  <div>
    {{ session('info')}}
  </div>
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if (session()->has('error'))
<div class="alert alert-danger alert-dismissible fade show w-100" role="alert">
  <div>
    {{ session('error')}}
  </div>
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif