@extends('layouts.app')

@section('content')
    <!-- Page Title -->
		<div class="section section-breadcrumbs">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<h1>Kenya Supply Unit</h1>
					</div>
				</div>
			</div>
		</div>
        
        <div class="section">
	    	<div class="container">
				<div class="row">
					<div class="col-sm-6">
						{{-- <h3>History</h3>
						<p>KENYA SUPPLY UNIT (KSU) formerly known as Logistical Centre Nairobi (LCN) was established in 2005 following the amalgamations of MSF supply and logistics activities of four sections in Kenya (OCB, OCG, OCP and OCBA). </p> --}}
						
						
						{{-- <h3>About Our Web App</h3>
						<p>
							We hope you will enjoy using our App and find it useful. If you have suggestions feel free to contact us. We want to meet your needs and improve. That’s why we plan to add more features as we launch the second phase of our Web App. The main functionalities we already planned to have in the near future are:- <br>
							• Items in the catalogue can be favorited<br>
							• Registered users can access history of all items requested for quotation<br>
							• Related items will be displayed when searching for a specific item<br>
							• Supply news updates from all OC’s<br>
							• Exploring ERP integration<br>
							• A mapping of processes and lead times for importation and exportation to countries in the region<br>
							• Overview of indicated transport prices to various destinations.<br>
							• Online Feedback form for claims, feedback and complaints.<br><br>
						</p> --}}
						<h3>About Us</h3>
						<p>
							Our ambition is value addition to local and regional clients in Africa and the MSF Supply Chain by focusing on the client needs, development of expertise through unlocking the value of supply chain and logistics.<br><br>
							We operate in a manner that recognizes and adapts to the increasing complexity of client needs within a rapidly changing environment. KSU strives to make MSF humanitarian responses more efficient (to save costs) and more effective (to save time) through analyzing and optimizing supply chains to enhance procurement, transportation, warehousing and distribution of medical, non-medical and logistical commodities.<br><br>
							KSU Supports the sustainable development of local labour markets in Kenya in a supply chain setup through the internship program which provides learning opportunities for students from higher learning institutions.<br><br>
							We foster collaboration and knowledge transfer through the detachment program with our clients across Africa and other parts of the world to improve the quality of humanitarian intervention within MSF operations.<br><br>
						</p>
						{{-- <h4 style="color:red"><b>MORE COMING SOON!</b></h4><br> --}}
					</div>
					<div class="col-sm-6">
						<div class="video-wrapper">
							<img src="{{URL('/')}}/assets/img/homepage-slider/group.jpg" alt="" height="385">
						</div>
					</div>
					<div class="col-sm-12">
						<br>
						<div class="container">
							{{-- <img src="{{URL('/')}}/assets/img/organogram.PNG" class="" alt="" height="720" style="width:100%"> --}}
							<div class="row justify-content-md-center">
								<div class="col-sm-12">
								  <h2 class="mb-4 display-5 text-center">Our Team</h2>
								  <hr class="w-50 mx-auto mb-5 mb-xl-9 border-dark-subtle">
								</div>
							  </div>
							<div class="row">
								<div class="col-sm-3">
									<div class="card" style="width: 18rem; height: auto">
										<img class="card-img-top" src="{{URL('/')}}/assets/img/Picture2.jpg" height="120" width="100%">
										<div class="card-body">
										  <h5 class="card-title">General Manager</h5>
										  <p class="card-text">Antoine Segui</p>
										</div>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="card" style="width: 18rem; height: auto">
										<img class="card-img-top" src="{{URL('/')}}/assets/img/Picture1.jpg" height="120" width="100%">
										<div class="card-body">
										  <h5 class="card-title">Responsible Pharma</h5>
										  <p class="card-text">Muthoni Mulinge</p>
										</div>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="card" style="width: 18rem; height: auto">
										<img class="card-img-top" src="{{URL('/')}}/assets/img/Picture15.jpg" height="120" width="100%">
										<div class="card-body">
										  <h5 class="card-title">Pharma & Quality Officer</h5>
										  <p class="card-text">Bobby Kumar</p>
										</div>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="card" style="width: 18rem; height: auto">
										<img class="card-img-top" src="{{URL('/')}}/assets/img/Picture9.jpg" height="120" width="100%">
										<div class="card-body">
										  <h5 class="card-title">Functional Analyst</h5>
										  <p class="card-text">Lewis Mwathe</p>
										</div>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="card" style="width: 18rem; height: auto">
										<img class="card-img-top" src="{{URL('/')}}/assets/img/Picture22.jpg" height="120" width="100%">
										<div class="card-body">
										  <h5 class="card-title">Procurement Manager</h5>
										  <p class="card-text">Paul Banks</p>
										</div>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="card" style="width: 18rem; height: auto">
										<img class="card-img-top" src="{{URL('/')}}/assets/img/Picture23.jpg" height="120" width="100%">
										<div class="card-body">
										  <h5 class="card-title">Procurement Officer</h5>
										  <p class="card-text">Sharon Kariuki</p>
										</div>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="card" style="width: 18rem; height: auto">
										<img class="card-img-top" src="{{URL('/')}}/assets/img/Picture10.jpg" height="120" width="100%">
										<div class="card-body">
										  <h5 class="card-title">Purchasing Officer</h5>
										  <p class="card-text">Paul Mutuku</p>
										</div>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="card" style="width: 18rem; height: auto">
										<img class="card-img-top" src="{{URL('/')}}/assets/img/Picture18.jpg" height="120" width="100%">
										<div class="card-body">
										  <h5 class="card-title">Product Referent</h5>
										  <p class="card-text">Hayato Oguchi</p>
										</div>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="card" style="width: 18rem; height: auto">
										<img class="card-img-top" src="{{URL('/')}}/assets/img/Picture3.jpg" height="120" width="100%">
										<div class="card-body">
										  <h5 class="card-title">Product Referent Assist</h5>
										  <p class="card-text">Aluda Duncan</p>
										</div>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="card" style="width: 18rem; height: auto">
										<img class="card-img-top" src="{{URL('/')}}/assets/img/Picture21.jpg" height="120" width="100%">
										<div class="card-body">
										  <h5 class="card-title">Supply Chain Manager</h5>
										  <p class="card-text">Justine Mecha</p>
										</div>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="card" style="width: 18rem; height: auto">
										<img class="card-img-top" src="{{URL('/')}}/assets/img/Picture26.jpg" height="120" width="100%">
										<div class="card-body">
										  <h5 class="card-title">Transport Manager</h5>
										  <p class="card-text">Mary Karanja</p>
										</div>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="card" style="width: 18rem; height: auto">
										<img class="card-img-top" src="{{URL('/')}}/assets/img/Picture16.jpg" height="120" width="100%">
										<div class="card-body">
										  <h5 class="card-title">Transport Officer</h5>
										  <p class="card-text">Irene Njoroge</p>
										</div>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="card" style="width: 18rem; height: auto">
										<img class="card-img-top" src="{{URL('/')}}/assets/img/Picture11.jpg" height="120" width="100%">
										<div class="card-body">
										  <h5 class="card-title">Driver</h5>
										  <p class="card-text">Tom Nyamao</p>
										</div>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="card" style="width: 18rem; height: auto">
										<img class="card-img-top" src="{{URL('/')}}/assets/img/Picture12.jpg" height="120" width="100%">
										<div class="card-body">
										  <h5 class="card-title">Driver</h5>
										  <p class="card-text">Simon Mbugua</p>
										</div>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="card" style="width: 18rem; height: auto">
										<img class="card-img-top" src="{{URL('/')}}/assets/img/Picture8.jpg" height="120" width="100%">
										<div class="card-body">
										  <h5 class="card-title">Customer Service</h5>
										  <p class="card-text">David Mutua</p>
										</div>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="card" style="width: 18rem; height: auto">
										<img class="card-img-top" src="{{URL('/')}}/assets/img/Picture7.jpg" height="120" width="100%">
										<div class="card-body">
										  <h5 class="card-title">Customer Service Inter</h5>
										  <p class="card-text">Isaack Ochieng</p>
										</div>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="card" style="width: 18rem; height: auto">
										<img class="card-img-top" src="{{URL('/')}}/assets/img/Picture13.jpg" height="120" width="100%">
										<div class="card-body">
										  <h5 class="card-title">Warehouse Supervisor</h5>
										  <p class="card-text">Patrick Kamau</p>
										</div>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="card" style="width: 18rem; height: auto">
										<img class="card-img-top" src="{{URL('/')}}/assets/img/Picture19.jpg" height="120" width="100%">
										<div class="card-body">
										  <h5 class="card-title">Warehouse Attendant</h5>
										  <p class="card-text">Wilson Njeru</p>
										</div>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="card" style="width: 18rem; height: auto">
										<img class="card-img-top" src="{{URL('/')}}/assets/img/Picture24.jpg" height="120" width="100%">
										<div class="card-body">
										  <h5 class="card-title">Warehouse Attendant</h5>
										  <p class="card-text">Zakayo Karanu</p>
										</div>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="card" style="width: 18rem; height: auto">
										<img class="card-img-top" src="{{URL('/')}}/assets/img/Picture27.jpg" height="120" width="100%">
										<div class="card-body">
										  <h5 class="card-title">Finco</h5>
										  <p class="card-text">Yannick Remans</p>
										</div>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="card" style="width: 18rem; height: auto">
										<img class="card-img-top" src="{{URL('/')}}/assets/img/Picture5.jpg" height="120" width="100%">
										<div class="card-body">
										  <h5 class="card-title">Accounting Manager</h5>
										  <p class="card-text">Vicky Rono</p>
										</div>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="card" style="width: 18rem; height: auto">
										<img class="card-img-top" src="{{URL('/')}}/assets/img/Picture14.jpg" height="120" width="100%">
										<div class="card-body">
										  <h5 class="card-title">Accountant</h5>
										  <p class="card-text">Enock Kering</p>
										</div>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="card" style="width: 18rem; height: auto">
										<img class="card-img-top" src="{{URL('/')}}/assets/img/Picture25.jpg" height="120" width="100%">
										<div class="card-body">
										  <h5 class="card-title">Stephen Kimani</h5>
										  <p class="card-text">Cashier</p>
										</div>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="card" style="width: 18rem; height: auto">
										<img class="card-img-top" src="{{URL('/')}}/assets/img/Picture20.jpg" height="120" width="100%">
										<div class="card-body">
										  <h5 class="card-title">HR Manager</h5>
										  <p class="card-text">Patience Lusinde</p>
										</div>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="card" style="width: 18rem; height: auto">
										<img class="card-img-top" src="{{URL('/')}}/assets/img/Picture17.jpg" height="120" width="100%">
										<div class="card-body">
										  <h5 class="card-title">Recepionist</h5>
										  <p class="card-text">Boniface Mbithi</p>
										</div>
									</div>
								</div>
								<div class="col-sm-3">
									<div class="card" style="width: 18rem; height: auto">
										<img class="card-img-top" src="{{URL('/')}}/assets/img/Picture4.jpg" height="120" width="100%">
										<div class="card-body">
										  <h5 class="card-title">Office Cleaner</h5>
										  <p class="card-text">Sally Vuguza</p>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- Team 1 - Bootstrap Brain Component -->
					</div>
				</div>
			</div>
		</div>
@endsection