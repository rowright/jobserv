
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>JobServ - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="//cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    
    <meta name="theme-color" content="#7952b3">    
    <style>
/* Show it is fixed to the top */
body {
  min-height: 75rem;
  padding-top: 4.5rem;
}
        </style>
  </head>
  <body>
        
  <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">JobServ</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
      <ul class="navbar-nav me-auto mb-2 mb-md-0">
      <li class="nav-item"><a class="nav-link" href="/simple/quickadd">Quick New</a></li>

      <li class="nav-item"><div class="dropdown">
        <a class="nav-link dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
        Work Orders
        </a>

        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
            <li><a class="dropdown-item" href="/workorders">Work Orders</a></li>
            <li><a class="dropdown-item" href="/workorders/all">All Work Orders</a></li>
        </ul>
        </div>
</li>
<li class="nav-item"><a class="nav-link" href="/customers">Customers</a></li>

<li class="nav-item"><div class="dropdown">
        <a class="nav-link dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
        Admin
        </a>

        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
        <li><a class="dropdown-item" href="/workers">Workers</a></li>
        <li><a class="dropdown-item"  href="/users">Users</a></li>
        <li><a class="dropdown-item"  href="/jobtypes">Job Types</a></li>
<li><a class="dropdown-item" href="/integrations">Integrations</a></li>
        </ul>
        </div>
</li>
      <li class="nav-item"><a class="nav-link" href="/logout">Signout</a></li>
      </ul>
    </div>
  </div>
</nav>

        <main class="container">
        @if(!empty($errors->first()))
        <div class="row pb-3">
        <div class="col">
        <div class="alert alert-danger">
            <span>{{ $errors->first() }}</span>
            </div></div></div>
        @endif
        <div class="row pb-3"><div class="col-9"><h2>@yield('title')</h2></div><div class="col-3"><div class="float-end">@yield('buttons')</div></div></div>
        
            @yield('body')
        </main>
    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script><script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script><script src="dashboard.js"></script>
    <script src="//cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    @stack('scripts')
  </body>
</html>
