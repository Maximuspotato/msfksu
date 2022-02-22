@extends('layouts.app')

@section('content')
	<!-- Page Title -->
    <div class="section section-breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>Invoice</h1>
                </div>
            </div>
        </div>
    </div>

	<div class="section">
        <div class="container">
			<div class="container" id="grille-param">
				<form autocomplete="off" onsubmit="getpdf(event)">
					<div class="div_filter">
					
						<label>Invoice no:</label>
						<input type="text" name="inv_no" id="inv_no" value="" required><br><br>
					
						<input type="submit" value="Go">
					</div>
				</form>

			</div>
		</div>
	</div>
	<script>
		function getpdf(e) {
			e.preventDefault();
			var inv_no = document.getElementById("inv_no").value;
			window.location.replace("<?php echo URL('/inv') ?>?inv_no="+inv_no);
		}
	</script>
@endsection
