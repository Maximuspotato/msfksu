@extends('layouts.app')

@section('content')
     <!-- Page Title -->
		<div class="section section-breadcrumbs">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
                        <h1>Human resource > {{$deet}}</h1>
					</div>
				</div>
			</div>
		</div>
        
        <div class="section">
	    	<div class="container">
				<div class="row">
					<div class="col-md-7">
                        @if ($deet == "Front-End-Developer")
                            <div class="job-details-wrapper">
                                <h3>Front End Developer</h3>
                                <p>
                                    Donec hendrerit massa metus, a ultrices elit iaculis eu. Pellentesque ullamcorper augue lacus. Phasellus et est quis diam iaculis fringilla id nec sapien. Sed tempor ornare felis, non vulputate dolor. Etiam ornare diam vitae ligula malesuada tempor. Vestibulum nec odio vel libero ullamcorper euismod et in sapien. Suspendisse potenti.
                                </p>
                                <h4>Skills required for the Ruby on Rails Developer</h4>
                                <ul>
                                    <li>Nullam dictum augue nec iaculis rhoncus. Aenean lobortis fringilla orci, vitae varius purus eleifend vitae.</li>
                                    <li>Nunc ornare, dolor a ultrices ultricies, magna dolor convallis enim, sed volutpat quam sem sed tellus.</li>
                                    <li>Aliquam malesuada cursus urna a rutrum. Ut ultricies facilisis suscipit.</li>
                                    <li>Duis a magna iaculis, aliquam metus in, luctus eros.</li>
                                    <li>Aenean nisi nibh, imperdiet sit amet eleifend et, gravida vitae sem.</li>
                                    <li>Donec quis nisi congue, ultricies massa ut, bibendum velit.</li>
                                </ul>
                                <h4>How to apply?</h4>
                                <p>
                                    Please email your CV and a portfolio to: <a href="mailto:MSFOCB-KSU-IT@brussels.msf.org">MSFOCB-KSU-IT@brussels.msf.org</a>
                                </p>
                            </div>
                        @elseif($deet == "Procurement-Assistant")
                            <div class="job-details-wrapper">
                                <h3>Procurement Assistant</h3>
                                <p>
                                    Donec hendrerit massa metus, a ultrices elit iaculis eu. Pellentesque ullamcorper augue lacus. Phasellus et est quis diam iaculis fringilla id nec sapien. Sed tempor ornare felis, non vulputate dolor. Etiam ornare diam vitae ligula malesuada tempor. Vestibulum nec odio vel libero ullamcorper euismod et in sapien. Suspendisse potenti.
                                </p>
                                <h4>Skills required for the Ruby on Rails Developer</h4>
                                <ul>
                                    <li>Nullam dictum augue nec iaculis rhoncus. Aenean lobortis fringilla orci, vitae varius purus eleifend vitae.</li>
                                    <li>Nunc ornare, dolor a ultrices ultricies, magna dolor convallis enim, sed volutpat quam sem sed tellus.</li>
                                    <li>Aliquam malesuada cursus urna a rutrum. Ut ultricies facilisis suscipit.</li>
                                    <li>Duis a magna iaculis, aliquam metus in, luctus eros.</li>
                                    <li>Aenean nisi nibh, imperdiet sit amet eleifend et, gravida vitae sem.</li>
                                    <li>Donec quis nisi congue, ultricies massa ut, bibendum velit.</li>
                                </ul>
                                <h4>How to apply?</h4>
                                <p>
                                    Please email your CV and a portfolio to: <a href="mailto:MSFOCB-KSU-IT@brussels.msf.org">MSFOCB-KSU-IT@brussels.msf.org</a>
                                </p>
                            </div>
                        @elseif($deet == "Pharmacy-Intern")
                            <div class="job-details-wrapper">
                                <h3>Pharmacy Intern</h3>
                                <p>
                                    Donec hendrerit massa metus, a ultrices elit iaculis eu. Pellentesque ullamcorper augue lacus. Phasellus et est quis diam iaculis fringilla id nec sapien. Sed tempor ornare felis, non vulputate dolor. Etiam ornare diam vitae ligula malesuada tempor. Vestibulum nec odio vel libero ullamcorper euismod et in sapien. Suspendisse potenti.
                                </p>
                                <h4>Skills required for the Ruby on Rails Developer</h4>
                                <ul>
                                    <li>Nullam dictum augue nec iaculis rhoncus. Aenean lobortis fringilla orci, vitae varius purus eleifend vitae.</li>
                                    <li>Nunc ornare, dolor a ultrices ultricies, magna dolor convallis enim, sed volutpat quam sem sed tellus.</li>
                                    <li>Aliquam malesuada cursus urna a rutrum. Ut ultricies facilisis suscipit.</li>
                                    <li>Duis a magna iaculis, aliquam metus in, luctus eros.</li>
                                    <li>Aenean nisi nibh, imperdiet sit amet eleifend et, gravida vitae sem.</li>
                                    <li>Donec quis nisi congue, ultricies massa ut, bibendum velit.</li>
                                </ul>
                                <h4>How to apply?</h4>
                                <p>
                                    Please email your CV and a portfolio to: <a href="mailto:MSFOCB-KSU-IT@brussels.msf.org">MSFOCB-KSU-IT@brussels.msf.org</a>
                                </p>
                            </div>
                        @endif
					</div>
					<!-- Sidebar -->
					<div class="col-md-4 col-md-offset-1">
						<h4>You may also be interested in</h4>
						<table class="jobs-list">
	    					<tr>
	    						<td class="job-position">
	    							<a href="{{URL('/hr/Front-End-Developer?deet=Front-End-Developer')}}">Front End Developer</a> <span class="label label-danger">New</span>
	    						</td>
	    					</tr>
	    					<tr>
	    						<td class="job-position">
	    							<a href="{{URL('/hr/Procurement-Assistant?deet=Procurement-Assistant')}}">Procurement Assistant</a> <span class="label label-danger">New</span>
	    						</td>
	    					</tr>
	    					<tr>
	    						<td class="job-position">
	    							<a href="{{URL('/hr/Pharmacy-intern?deet=Pharmacy-Intern')}}">Pharmacy Intern</a>
	    						</td>
	    					</tr>
	    				</table>
					</div>
					<!-- End Sidebar -->
				</div>
			</div>
		</div>
@endsection