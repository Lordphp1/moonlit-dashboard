<?php
include "../../includes/session.php";
?>
<!DOCTYPE html>
<html lang="en">
    
<head>

		<!-- Meta Tags -->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="<?php echo $siteinfo['site_name'];?> is a powerful Bootstrap based Inventory Management Admin Template designed for businesses, offering seamless invoicing, project tracking, and estimates.">
		<meta name="keywords" content="inventory management, admin dashboard, bootstrap template, invoicing, estimates, business management, responsive admin, POS system">
		<meta name="author" content="Dreams Technologies">
		<meta name="robots" content="index, follow">
		<title><?php echo $siteinfo['site_name'];?> -  Admin Dashboard Template</title>
		

		<!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">

		<!-- Apple Touch Icon -->
		<link rel="apple-touch-icon" sizes="180x180" href="assets/img/apple-touch-icon.png">
		
		<!-- Bootstrap CSS -->
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
		
		<!-- animation CSS -->
        <link rel="stylesheet" href="assets/css/animate.css">

		<!-- Select2 CSS -->
		<link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css">

		<!-- Datetimepicker CSS -->
		<link rel="stylesheet" href="assets/css/bootstrap-datetimepicker.min.css">

		<!-- Datatable CSS -->
		<link rel="stylesheet" href="assets/css/dataTables.bootstrap5.min.css">
		
        <!-- Fontawesome CSS -->
		<link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
		<link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">

		<!-- Tabler Icon CSS -->
		<link rel="stylesheet" href="assets/plugins/tabler-icons/tabler-icons.min.css">
		
		<!-- Color Picker Css -->
	<link rel="stylesheet" href="assets/plugins/%40simonwep/pickr/themes/nano.min.css">

	    <!-- Main CSS -->
        <link rel="stylesheet" href="assets/css/style.css">
		
    </head>
    <body>
		
		<div id="global-loader" >
			<div class="whirly-loader"> </div>
		</div>

		<!-- Main Wrapper -->
        <div class="main-wrapper">
		
		<!-- Header -->
			<?php include("../../includes/header.php");?>
		<!-- /Header -->
			
			<!-- Sidebar -->
			<?php include("../../includes/sidemenu.php");?>
			<!-- /Sidebar -->


			<div class="page-wrapper">
				<div class="content">
					<div class="page-header">
						<div class="add-item d-flex">
							<div class="page-title">
								<h4 class="fw-bold">Category</h4>
								<h6>Manage your categories</h6>
							</div>
						</div>
						<ul class="table-top-head">
							<li>
								<a data-bs-toggle="tooltip" data-bs-placement="top" title="Pdf"><img src="assets/img/icons/pdf.svg" alt="img"></a>
							</li>
							<li>
								<a data-bs-toggle="tooltip" data-bs-placement="top" title="Excel"><img src="assets/img/icons/excel.svg" alt="img"></a>
							</li>
							<li>
								<a data-bs-toggle="tooltip" data-bs-placement="top" title="Refresh"><i class="ti ti-refresh"></i></a>
							</li>
							<li>
								<a data-bs-toggle="tooltip" data-bs-placement="top" title="Collapse" id="collapse-header"><i class="ti ti-chevron-up"></i></a>
							</li>
						</ul>
						<div class="page-btn">
							<a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-category"><i class="ti ti-circle-plus me-1"></i>Add Category</a>
						</div>
					</div>
					<!-- /product list -->
					<div class="card">
						<div class="card-header d-flex align-items-center justify-content-between flex-wrap row-gap-3">
							<div class="search-set">
								<div class="search-input">
									<span class="btn-searchset"><i class="ti ti-search fs-14 feather-search"></i></span>
								</div>
							</div>
							<div class="d-flex table-dropdown my-xl-auto right-content align-items-center flex-wrap row-gap-3">
								<div class="dropdown">
									<a href="javascript:void(0);" class="dropdown-toggle btn btn-white btn-md d-inline-flex align-items-center" data-bs-toggle="dropdown">
										Status
									</a>
									<ul class="dropdown-menu  dropdown-menu-end p-3">
										<li>
											<a href="javascript:void(0);" class="dropdown-item rounded-1">Active</a>
										</li>
										<li>
											<a href="javascript:void(0);" class="dropdown-item rounded-1">Inactive</a>
										</li>
									</ul>
								</div>
							</div>
						</div>
						
						<div class="card-body p-0">
							<div class="table-responsive">
								<table class="table datatable">
									<thead class="thead-light">
										<tr>
											<th class="no-sort">
												<label class="checkboxs">
													<input type="checkbox" id="select-all">
													<span class="checkmarks"></span>
												</label>
											</th>
											<th>Category</th>
											<th>Category slug</th>
											<th>Created On</th>
											<th>Status</th>
											<th class="no-sort"></th>
										</tr>
									</thead>
								

									<tbody id="categoryTable"></tbody>

								</table>
							</div>
						</div>
					</div>
					<!-- /product list -->
				</div>
				<div class="footer d-sm-flex align-items-center justify-content-between border-top bg-white p-3">
                    <p class="mb-0 text-gray-9">2014 - 2025 &copy; <?php echo $siteinfo['site_name'];?>. All Right Reserved</p>
                    <p>Designed &amp; Developed by <a href="javascript:void(0);" class="text-primary">Tecvator</a></p>
                </div>
			</div>
        </div>
		<!-- /Main Wrapper -->

		<!-- Add Category -->
		<div class="modal fade" id="add-category">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header">
						<div class="page-title">
							<h4>Add Category</h4>
						</div>
						<button type="button" class="close bg-danger text-white fs-16" data-bs-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<form action="">
						<div class="modal-body">
							<div class="mb-3">
								<label class="form-label">Category<span class="text-danger ms-1">*</span></label>
								<input type="text" class="form-control">
							</div>
						
							<div class="mb-0">
								<div class="status-toggle modal-status d-flex justify-content-between align-items-center">
									<span class="status-label">Status<span class="text-danger ms-1">*</span></span>
									<input type="checkbox" id="user2" class="check" checked="">
									<label for="user2" class="checktoggle"></label>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn me-2 btn-secondary" data-bs-dismiss="modal">Cancel</button>
							<button type="submit" class="btn btn-primary">Add Category</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		<!-- /Add Category -->

		<!-- Edit Category -->
		<div class="modal fade" id="edit-category">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header">
						<div class="page-title">
							<h4>Edit Category</h4>
						</div>
						<button type="button" class="close bg-danger text-white fs-16" data-bs-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<form action="">
						<div class="modal-body">
							<div class="mb-3">
								<label class="form-label">Category<span class="text-danger ms-1">*</span></label>
								<input type="text" class="form-control" value="Computers">
							</div>
						
							<div class="mb-0">
								<div class="status-toggle modal-status d-flex justify-content-between align-items-center">
									<span class="status-label">Status<span class="text-danger ms-1">*</span></span>
									<input type="checkbox" id="user3" class="check" checked="">
									<label for="user3" class="checktoggle"></label>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn me-2 btn-secondary" data-bs-dismiss="modal">Cancel</button>
							<button type="submit" class="btn btn-primary">Save Changes</button>
						</div>
					</form>
				</div>
			</div>
		</div>

		<!-- delete modal -->
		<div class="modal fade" id="delete-modal">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="page-wrapper-new p-0">
						<div class="content p-5 px-3 text-center">
								<span class="rounded-circle d-inline-flex p-2 bg-danger-transparent mb-2"><i class="ti ti-trash fs-24 text-danger"></i></span>
								<h4 class="fs-20 fw-bold mb-2 mt-1">Delete Category</h4>
								<p class="mb-0 fs-16">Are you sure you want to delete category?</p>
								<div class="modal-footer-btn mt-3 d-flex justify-content-center">
									<button type="button" class="btn me-2 btn-secondary fs-13 fw-medium p-2 px-3 shadow-none" data-bs-dismiss="modal">Cancel</button>
									<button type="submit" class="btn btn-primary fs-13 fw-medium p-2 px-3">Yes Delete</button>
								</div>						
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- /Edit Category -->
		 <!-- Toast Container (top-right corner) -->
<div class="position-fixed top-0 end-0 p-3" style="z-index: 9999">
  <div id="toastMessage" class="toast align-items-center text-white border-0" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
      <div id="toastText" class="toast-body">
        <!-- Message will appear here -->
      </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>
</div>

		  
<script>
document.addEventListener("DOMContentLoaded", function() {
    fetchCategories();

    // Fetch Categories
    function fetchCategories() {
        fetch("process/category_process.php", {
            method: "POST",
            headers: {"Content-Type": "application/x-www-form-urlencoded"},
            body: new URLSearchParams({action: "fetch"})
        })
        .then(res => res.json())
        .then(data => {
            let tbody = document.getElementById("categoryTable");
            tbody.innerHTML = "";

            if (data.status === "success") {
                data.data.forEach(cat => {
                    tbody.innerHTML += `
                        <tr>
                            <td>
                                <label class="checkboxs">
                                    <input type="checkbox">
                                    <span class="checkmarks"></span>
                                </label>
                            </td>
                            <td><span class="text-gray-9">${cat.category_name}</span></td>
                            <td>${cat.category_unique_id}</td>
                            <td>${cat.created_at}</td>
                            <td><span class="badge ${cat.status === "Active" ? "bg-success" : "bg-danger"} fw-medium fs-10">${cat.status === "Active" ? "Active" : "Inactive"}</span></td>
                            <td class="action-table-data">
                                <div class="edit-delete-action">
                                    <a href="#" class="me-2 p-2 editBtn" 
                                        data-id="${cat.category_id}" 
                                        data-name="${cat.category_name}" 
                                        data-status="${cat.status}">
                                        <i data-feather="edit" class="feather-edit"></i>
                                    </a>
                                    <a href="#" class="p-2 deleteBtn" data-id="${cat.category_id}">
                                        <i data-feather="trash-2" class="feather-trash-2"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    `;
                });
                feather.replace();
            }
        });
    }

    // Add Category
    document.querySelector("#add-category form").addEventListener("submit", function(e) {
        e.preventDefault();
        let name = this.querySelector("input[type=text]").value;
        let status = this.querySelector("input[type=checkbox]").checked ? "1" : "0";

        fetch("process/category_process.php", {
            method: "POST",
            headers: {"Content-Type": "application/x-www-form-urlencoded"},
            body: new URLSearchParams({action: "add", name, status})
        })
        .then(res => res.json())
        .then(data => {
            showToast(data.message, data.status);
            if (data.status === "success") {
                fetchCategories();
                bootstrap.Modal.getInstance(document.getElementById("add-category")).hide();
            }
        });
    });

    // Delete Category
    document.addEventListener("click", function(e) {
        if (e.target.closest(".deleteBtn")) {
            e.preventDefault();
            let id = e.target.closest(".deleteBtn").dataset.id;
            if (confirm("Delete this category?")) {
                fetch("process/category_process.php", {
                    method: "POST",
                    headers: {"Content-Type": "application/x-www-form-urlencoded"},
                    body: new URLSearchParams({action: "delete", id})
                })
                .then(res => res.json())
                .then(data => {
                    showToast(data.message, data.status);
                    if (data.status === "success") {
                        fetchCategories();
                    }
                });
            }
        }
    });

    // Reusable Toast
    function showToast(message, status) {
        const toastEl = document.getElementById("toastMessage");
        const toastText = document.getElementById("toastText");
        toastEl.className = `toast align-items-center text-white border-0 ${status === "success" ? "bg-success" : "bg-danger"}`;
        toastText.textContent = message;
        new bootstrap.Toast(toastEl, { delay: 2000 }).show();
    }
});
</script>


		<!-- jQuery -->
        <script src="assets/js/jquery-3.7.1.min.js" type="bfa76765b7e573dd030ce6b7-text/javascript"></script>

        <!-- Feather Icon JS -->
		<script src="assets/js/feather.min.js" type="bfa76765b7e573dd030ce6b7-text/javascript"></script>

		<!-- Slimscroll JS -->
		<script src="assets/js/jquery.slimscroll.min.js" type="bfa76765b7e573dd030ce6b7-text/javascript"></script>

		<!-- Datatable JS -->
		<script src="assets/js/jquery.dataTables.min.js" type="bfa76765b7e573dd030ce6b7-text/javascript"></script>
		<script src="assets/js/dataTables.bootstrap5.min.js" type="bfa76765b7e573dd030ce6b7-text/javascript"></script>
		
		<!-- Bootstrap Core JS -->
        <script src="assets/js/bootstrap.bundle.min.js" type="bfa76765b7e573dd030ce6b7-text/javascript"></script>

		<!-- Select2 JS -->
		<script src="assets/plugins/select2/js/select2.min.js" type="bfa76765b7e573dd030ce6b7-text/javascript"></script>

		<!-- Datetimepicker JS -->
		<script src="assets/js/moment.min.js" type="bfa76765b7e573dd030ce6b7-text/javascript"></script>
		<script src="assets/js/bootstrap-datetimepicker.min.js" type="bfa76765b7e573dd030ce6b7-text/javascript"></script>

		<!-- Color Picker JS -->
		<script src="assets/plugins/%40simonwep/pickr/pickr.es5.min.js" type="bfa76765b7e573dd030ce6b7-text/javascript"></script>

		<!-- Custom JS -->
		<script src="assets/js/theme-colorpicker.js" type="bfa76765b7e573dd030ce6b7-text/javascript"></script>
		<script src="assets/js/script.js" type="bfa76765b7e573dd030ce6b7-text/javascript"></script>
		
    <script src="../../cdn-cgi/scripts/7d0fa10a/cloudflare-static/rocket-loader.min.js" data-cf-settings="bfa76765b7e573dd030ce6b7-|49" defer></script><script defer src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015" integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ==" data-cf-beacon='{"rayId":"98610be02e4ee911","version":"2025.9.1","serverTiming":{"name":{"cfExtPri":true,"cfEdge":true,"cfOrigin":true,"cfL4":true,"cfSpeedBrain":true,"cfCacheStatus":true}},"token":"3ca157e612a14eccbb30cf6db6691c29","b":1}' crossorigin="anonymous"></script>
</body>

</html>