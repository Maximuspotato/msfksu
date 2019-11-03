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
						
						{{-- <p>
							Our ambition is value addition to local and regional clients in Africa and the MSF Supply Chain by focusing on the client needs, development of expertise through unlocking the value of supply chain and logistics.<br><br>
							We operate in a manner that recognizes and adapts to the increasing complexity of client needs within a rapidly changing environment. KSU strives to make MSF humanitarian responses more efficient (to save costs) and more effective (to save time) through analyzing and optimizing supply chains to enhance procurement, transportation, warehousing and distribution of medical, non-medical and logistical commodities.<br><br>
							KSU Supports the sustainable development of local labour markets in Kenya in a supply chain setup through the internship program which provides learning opportunities for students from higher learning institutions.<br><br>
							We foster collaboration and knowledge transfer through the detachment program with our clients across Africa and other parts of the world to improve the quality of humanitarian intervention within MSF operations.<br><br>
						</p> --}}
						<h3>About Our Web App</h3>
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
						</p>
						<h3>About Us</h3>
						<h4 style="color:red"><b>COMING SOON!</b></h4><br>
					</div>
					<div class="col-sm-6">
						<div class="video-wrapper">
							<img src="{{URL('/')}}/assets/img/homepage-slider/group.jpg" alt="" height="385">
						</div>
					</div>
					<div class="col-sm-12">
						<br>
						<h3 class="">Organogram</h3>
						<div class="container">
							<img src="{{URL('/')}}/assets/img/organogram.PNG" class="" alt="" height="500">
						</div>
					</div>
				</div>
			</div>
		</div>
@endsection