<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Dashboard</title>
  <!-- <link rel="stylesheet" type="text/css" href="css/globalstyle.css"> -->

  <!-- BOOTSTRAP LINK -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <!-- BOOTSTRAP ICONS LINK -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <!-- ???? -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <!-- GOOGLE ICONS (MATERIAL ICONS) LINK`` -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">


  <link rel="stylesheet" type="text/css" href="/css/dashboard.css">
  <link rel="stylesheet" href="css/navbar-style.css">

  <link rel="stylesheet" type="text/css" href="./../public/css/dashboard.css">
  <link rel="stylesheet" href="./../public/css/navbar-style.css">

  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap"
    rel="stylesheet">



</head>

<body>


  <!-- TOP NAVBAR -->
  <nav class="sb-topnav navbar navbar-expand ">

    <!-- Sidebar Toggle-->
    <button class="btn btn-link btn-sm me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>

    <!-- <div class="d-flex "> -->
    <div class="d-sm-flex align-self-center align-items-center justify-content-between manager-accounts w-100">
      <h2 class="page-title">Dashboard</h2>
      <div class="manager-accounts d-flex justify-content-center align-content-center mb-auto">
        <p class="pe-4">Manager</p>
        <img class="mx-5" src="/images/icons/person.svg" alt="">
      </div>
    </div>
    <!-- </div> -->


  </nav>


  <div id="layoutSidenav">


    <!-- SIDEBAR -->
    <div class="d-flex flex-column sidebar" id="layoutSidenav_nav">


      <nav class="sb-sidenav accordion" id="sidenavAccordion">
        <!-- Navbar Brand-->
        <h2 class="navbar-brand ps-4 pe-4 pb-0" href="index.html">Menu</h2>

        <div class="sb-sidenav-menu">
          <div class="nav">

            <ul class="nav nav-pills nav-flush flex-column mb-auto text-center">

              <!-- DASHBOARD -->
              <li class="my-2">
                <a href="/designer/dashboard" class="nav-link px-0" title="Dashboard" data-bs-toggle="tooltip"
                  data-bs-placement="right">
                  <div class="border_box px-xxl-2 px-1">
                    <i class="material-icons">dashboard</i>
                    <p>Dashboard</p>
                  </div>
                </a>
              </li>

              <!-- NOTIFICATION -->
              <li class="my-2">
                <a href="/designer/notification" class="nav-link py-3 border_top px-0" title="Orders"
                  data-bs-toggle="tooltip" data-bs-placement="right">
                  <i class="bi bi-bell-fill"></i>
                  <p>Notification</p>
                </a>
              </li>

            </ul>

          </div>
        </div>


        <!-- SIGN OUT -->
        <!-- <div class="nav-link-exit nav-link">
          <form action="/employee/logout" method="POST"
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
    <!-- END OF NAVBAR -->


    <!-- START OF MAIN CONTENT -->


    <div id="layoutSidenav_content">
      <main class="col-md-11 p-4 container-lg">



        <div class="row">

          <div class="col-md-6 mb-3">
            <div class="card-custom">
              <div class="d-flex justify-content-between align-items-center">
                <h5 class="text-light">Pending Orders</h5>
              </div>
              <!-- SCROLLABLE CONTENT -->
              <div class="scrollable mt-2">
                <!-- CONTENT-SECTION -->
                {% for order in orders %}
                <div data-id="{{order.item_id}}" class="order-card d-flex align-items-center w-100">
                  <img src="{{order.product_image}}" alt="Bouquet" width="120" height="120" class="rounded">
                  <div class="d-flex flex-column w-100 gap-0 ps-3">
                    <p class="mb-0 fw-bold product_name">{{order.product_name}}</p>
                    <p class=" m-0 order-details">Customer: <span class="started">{{ order.customer_name }}</span></p>
                    <p class=" m-0 order-details">Quantity: <span class="started">{{ order.quantity }}</span></p>
                    <div class=" d-flex flex justify-content-start align-items-center">
                      <span>
                        <p class=" m-0 order-details">Pickup Schedule: <span class="started">{{ order.pickup_date }}
                            {{order.pickup_time}}</span></p>
                      </span>
                    </div>
                  </div>
                  <button id="check-button" type="button" rel="tooltip"
                    class="btn btn-success btn-just-icon btn-sm me-4" onclick="updateOrderStatus({{ order.item_id}})">
                    <i class="fas fa-check"></i>
                  </button>
                </div>
                {% endfor %}
              </div>
            </div>
          </div>

          <div class="col-md-6 mb-3">
            <div class="card-custom">
              <div class="d-flex justify-content-between align-items-center">
                <h5 class="text-light">Completed Orders</h5>
              </div>
              <div id="container" class="scrollable mt-2">
                <!-- SECOND SECTION OF SCROLLABLE CONTENT -->
                <div id="card" class="order-card d-flex align-items-center w-100" style="display:none;">
                  <img class="product_image rounded" src="" alt="Bouquet" width="120" height="120">
                  <div class="d-flex flex-column w-100 me-5 gap-0 ps-3">
                    <p class="mb-0 fw-bold product_name"></p>
                    <p class=" m-0 order-details">Customer: <span class="started customer_name"></span></p>
                    <div class=" d-flex flex justify-content-start align-items-center">
                      <span>
                        <p class=" m-0 order-details">Pickup Schedule: <span class="started pickup_schedule"></span></p>
                      </span>
                      <span class="ms-3 ps-5">
                        <p class=" m-0 order-details">Status: <span class="status"></span></p>
                      </span>
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </div>



          <!-- CURRENT ORDER DETAILS DASHBOARD -->
          <div class="row mt-3 mx-2">
            <div class="dashboard-content p-4">

              <div class="row">
                <h4 class="fw-bold details-title">Current Order Details</h4>
              </div>


              <div class="row align-items-center ">

                <!-- ORDER DETAILS TEXTS -->
                <div class="col-md-4   align-self-start ">


                  <form class="d-flex justify-content-between align-self-end flex-column p-3 gap-5 mt-3 pt-5">


                    <div class=" details-card ords">
                      <label class="details-category">Flowers:</label>
                      <p class="details-texts ms-5 ps-3">Rose 7x</p>
                    </div>

                    <div class=" details-card ords">
                      <label class="details-category">Package:</label>
                      <p class="details-texts ms-5 ps-3">Craft</p>
                    </div>

                    <div class=" details-card ords">
                      <label class="details-category">Card:</label>
                      <p class="details-texts ms-5 ps-3">Anniversary Card</p>
                    </div>
                  </form>
                </div>


                <!-- ORDER DETAILS IMAGE -->
                <div
                  class="col-md-4 d-flex flex-column align-self-start align-items-center justify-content-center details-img">
                  <p class="text-white">Flower Arrangement</p>
                  <img src="images/boks.png" class="img-fluid img-thumbnail rounded mt-2" alt="Bouquet">

                </div>


                <!-- ORDER DETAILS ADDIONAL INFO -->
                <div class="col-md-4 pt-0 p-4 d-flex flex-column  align-self-start">
                  <div class="mb-3 additional-message text-center">
                    <label class="form-label text-white mb-4">Additional Message</label>
                    <textarea class="form-control message-box "
                      placeholder="Additional Message to the Designer..."></textarea>

                  </div>
                  <div class="price-box px-5 d-flex justify-content-between align-items-center">
                    <p class="price-text m-0">Total price: </p>
                    <span class="price">₱650.00 PHP</span>
                  </div>
                  <div class="d-flex info-buttons justify-content-between">
                    <button class="btn btn-cancel">Cancel Order</button>
                    <button class="btn btn-complete">Complete Order</button>
                  </div>
                </div>
              </div>
            </div>
          </div>

      </main>
    </div>


  </div>

  <script src="./../public/js/sidebar.js"></script>
  <!-- <script src="/js/designer-dashboard.js"></script>
  <script src="/js/nav.js"></script> -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>