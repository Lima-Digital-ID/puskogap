<form action="" method="get">
  <div class="input-group">
      <input type="text" class="form-control" name="keyword"
          value="{{ Request::get('keyword') }}" placeholder="Search">
      <div class="input-group-append">
          <button class="btn btn-sm btn-primary px-3"><i class="fa fa-search"></i></button>
      </div>
  </div>
</form>