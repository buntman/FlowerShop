<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Manage Accounts</title>


  <script src="../public/js/sidebar.js" defer></script>
  <script> src = "./../public/js/sidebar.js"</script>


  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <!-- <link rel="stylesheet" type="text/css" href="css/globalstyle.css"> -->
  <link rel="stylesheet" type="text/css" href="/css/navbar-style.css">
  <link rel="stylesheet" type="text/css" href="/css/manage.css">


  <link rel="stylesheet" type="text/css" href="./../public/css/navbar-style.css">
  <link rel="stylesheet" type="text/css" href="./../public/css/manage.css">


  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">


  <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />


</head>

<body>



  <nav class="sb-topnav navbar navbar-expand ">

    <!-- Sidebar Toggle-->
    <button class="btn btn-link btn-sm me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>

    <!-- <div class="d-flex "> -->
    <div class="d-sm-flex align-self-center align-items-center justify-content-between manager-accounts w-100">
      <h2 class="page-title">Manage Accounts</h2>
      <div class="manager-accounts d-flex justify-content-center align-content-center mb-auto">
        <p class="pe-4">Manager</p>
        <img class="mx-5" src="/images/icons/person.svg" alt="">
      </div>
    </div>
    <!-- </div> -->


  </nav>






  <div id="layoutSidenav">


    <div class="d-flex flex-column sidebar" id="layoutSidenav_nav">


      <nav class="sb-sidenav accordion" id="sidenavAccordion">
        <!-- Navbar Brand-->
        <h2 class="navbar-brand ps-4 pe-4 pb-0" href="index.html">Menu</h2>

        <div class="sb-sidenav-menu">
          <div class="nav">
            <ul class="nav nav-pills nav-flush flex-column mb-auto text-center">
              <!-- INVENTORY -->
              <li class="my-2">
                <a href="/admin-inventory" class="nav-link border_bottom" title="Dashboard" data-bs-toggle="tooltip"
                  data-bs-placement="right">
                  <i class="bi bi-database nav-icons"></i>
                  <p>Inventory</p>
                </a>
              </li>

              <!-- REPORTS -->
              <li class="my-2">
                <a href="/admin-reports" class="nav-link py-3 border_bottom" title="Orders" data-bs-toggle="tooltip"
                  data-bs-placement="right">
                  <div class="">
                    <i class="bi bi-clipboard-data"></i>
                    <p>Reports</p>
                  </div>
                </a>
              </li>

              <!-- MANAGE -->
              <li class="my-2">
                <a href="/admin-manage-account" class="nav-link" title="Products" data-bs-toggle="tooltip"
                  data-bs-placement="right">
                  <div class="border_box">
                    <i class="bi bi-person-circle"></i>
                    <p>Manage</p>
                  </div>
                </a>
              </li>
            </ul>
          </div>
        </div>

        <!-- SIGN OUT -->
        <!-- <div class="nav-link-exit nav-link">
          <form action="/logout" method="POST"
            class="d-flex flex-column align-items-center justify-content-center link-dark text-decoration-none"
            style="cursor: pointer; border: none; background: none; padding: 0;">
            <button type="submit" style="background: none; border: none; padding: 0; cursor: pointer;">
              <i class="bi bi-escape"></i>
              <p class="d-block p-exit">Sign Out</p>
            </button>
          </form>
        </div> -->


        <div class="sb-sidenav-footer">
          <div class="small">Log Out</div>
        </div>

      </nav>

    </div>
    <!-- </div> -->
    <!-- END OF NAVBAR -->






    <!-- START OF MAIN CONTENT -->

    <div id="layoutSidenav_content">
      <main>

        <div class="px-4 mt-5">

          <!-- INPUT GROUPS -->
            <div class=" container d-flex justify-content-end align-items-center mb-3 ">

              <!-- SEARCH BAR -->
              <!-- <div class="input-group search-bar">
                <span class="input-group-text"><i class="fas fa-search"></i></span>
                <input type="text" class="form-control" placeholder="Search Name">
              </div> -->


              <!-- FILTER MENU -->
              <!-- <select class="form-select  w-25">
                <option selected value="">Filter by:</option>
                <option value="Manager">Manager</option>
                <option value="Designer">Designer</option>
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
              </select> -->


              <div class="container-flex">
                <button type="button" class="btn btn-new-staff toggle-status-off" onclick="deactivateStatus()">Deactive
                  Account</button>
                <button type="button" class="btn btn-new-staff toggle-status-on" onclick="activateStatus()">Activate
                  Account</button>
              </div>
            </div>


          <!-- TABLE SECTION -->
          <div class="container mt-4 table-accounts">

            <div class="card-body card p-3 table-responsive">
              
              <table id="datatablesSimple" class="table table-hover ">
                <thead class="">
                  <tr>
                    <th data-sortable="false"></th>
                    <th>Staff Name</th>
                    <th>Email Address</th>
                    <th>Phone Number</th>
                    <th>Status</th>
                    <th>Role</th>
                    <th data-sortable="false"></th>
                  </tr>
                </thead>
                <tbody>
                  {% for account in accounts %}
                  <tr data-id="{{ account.id }}" onclick="fetchUser({{ account.id }})">
                    <td><img class="profile-icons" src="/images/images/profile.png" alt="Profile"></td>
                    <td>{{ account.first_name }} {{ account.last_name }}</td>
                    <td>{{ account.email }}</td>
                    <td>{{ account.contact_number }}</td>
                    <td>{{ account.status }} </td>
                    <td>{{ account.role }}</td>
                    <td>
                      <button type="button" class="btn btn-sm remove-btn" onclick="deleteAccount({{ account.id }})">
                        <i class="fas fa-minus-circle"></i>
                      </button>
                    </td>
                  </tr>
                  {% endfor %}
                </tbody>
              </table>


            </div>
          </div>

        </div>

      </main>
      <!-- END OF TABLE SECTION -->



    </div>
  </div>



  <script> src = "../public/js/sidebar.js"</script>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <!-- <script src="Javascript/dashboard.js"></script> -->
  <!-- <script src="/js/nav.js"></script>
  <script src="/js/account-management.js"></script> -->



  <script>
    window.addEventListener('DOMContentLoaded', event => {
      // Simple-DataTables
      // https://github.com/fiduswriter/Simple-DataTables/wiki

      const datatablesSimple = document.getElementById('datatablesSimple');
      if (datatablesSimple) {
        new simpleDatatables.DataTable(datatablesSimple);
      }
    });
  </script>
  <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
    crossorigin="anonymous"></script>
</body>

</html>