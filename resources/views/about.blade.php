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
						<h3>History</h3>
							<p>KENYA SUPPLY UNIT (KSU) formerly known as Logistical Centre Nairobi (LCN) was established in 2005 following the amalgamations of MSF supply and logistics activities of four sections in Kenya (OCB, OCG, OCP and OCBA). </p>
						<h3>About Us</h3>
						<p>
							Our ambition is value addition to local and regional clients in Africa and the MSF Supply Chain by focusing on the client needs, development of expertise through unlocking the value of supply chain and logistics.<br><br>
							We operate in a manner that recognizes and adapts to the increasing complexity of client needs within a rapidly changing environment. KSU strives to make MSF humanitarian responses more efficient (to save costs) and more effective (to save time) through analyzing and optimizing supply chains to enhance procurement, transportation, warehousing and distribution of medical, non-medical and logistical commodities.<br><br>
							KSU Supports the sustainable development of local labour markets in Kenya in a supply chain setup through the internship program which provides learning opportunities for students from higher learning institutions.<br><br>
							We foster collaboration and knowledge transfer through the detachment program with our clients across Africa and other parts of the world to improve the quality of humanitarian intervention within MSF operations.<br><br>
							{{-- <i>THE FOLLOWING SERVICES ARE PROVIDED TO MSF MISSIONS:</i>
							<h5><u>PROCUREMENT</u></h5>
							Local and international procurement of MSF approved medical and non-medical supplies
							<h5><u>PHARMACY</u></h5>
							Medical manufacture and supplier validation and managing Good Distribution Practices [GDP]
							<h5><u>WAREHOUSING</u></h5>
							Reception, storage, dispatch of medical [i.e. Cold Chain, controlled, expires drugs], logistical supplies [e.g. dangers goods, electrical, mechanical] and consumables [e.g. stationary, cleaning]. KSU had 3 types of warehouse facilities in Nairobi: Transit Go Down [TGD], Export Processing Zone [EPZ] and an open warehouse
							<h5><u>STOCK MANAGEMENT</u></h5>
							Quality control, Inventory management, kitting, packing and labeling
							<h5><u>TRANSPORT</u></h5>
							Transit cargo management, cargo consolidation, local and international distribution of supplies by road, air and sea
							<h5><u>IMPORT/EXPORT</u></h5>
							Clearing and forwarding of supplies purchased locally and internationally --}}
						</p>
					</div>
					<div class="col-sm-6">
						<div class="video-wrapper">
							<img src="{{URL('/')}}/assets/img/homepage-slider/wh1.jpg" alt="" height="210">
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