@extends('layouts.app')

@section('content')
<main class="main my-account-page">
	<div class="container-xxl">
		<div class="card">
			<div class="card-body">
				<h3 class="border-bottom pb-4 mb-5">My Account</h3>
				<div class="row">
					<div class="col-lg-3">
						<div class="">
							<label class="form-label">Profile Picture</label>
							<div class="profile-img-wrap">
								<div class="profile-img"></div>
								<div class="profile-btns">
									<button type="button" class="btn btn-light">
										<ion-icon name="duplicate-outline"></ion-icon>
									</button>
									<button type="button" class="btn btn-light">
										<ion-icon name="trash-outline"></ion-icon>
									</button>
								</div>
							</div>
							<div class="profile-hint py-3">Allowed File Types: .png . jpg and .jpeg.</div>
						</div>
					</div>
					<div class="col-lg-9">
						<div class="row">
							<div class="col-md-4 col-sm-6">
								<div class="mb-4">
									<label class="form-label">Participant</label>
									<div class="input-group-overlay">
										<input type="text" placeholder="The Name of the Participant"
											class="form-control appended-form-control">
										<div class="input-group-append-overlay">
											<span class="input-group-text">
												<button type="button" class="btn btn-text p-0 text-primary">
													<ion-icon name="create-outline"></ion-icon>
												</button>
											</span>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-4 col-sm-6">
								<div class="mb-4">
									<label class="form-label">Date of Birth</label>
									<div class="input-group-overlay">
										<input type="text" placeholder="Date of Birth" class="form-control appended-form-control">
										<div class="input-group-append-overlay">
											<span class="input-group-text">
												<button type="button" class="btn btn-text p-0 text-primary">
													<ion-icon name="create-outline"></ion-icon>
												</button>
											</span>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-4 col-sm-6">
								<div class="mb-4">
									<label class="form-label">Unique Identifier</label>
									<div class="input-group-overlay">
										<input type="text" placeholder="16515656115615656" class="form-control appended-form-control">
										<div class="input-group-append-overlay">
											<span class="input-group-text">
												<button type="button" class="btn btn-text p-0 text-primary">
													<ion-icon name="create-outline"></ion-icon>
												</button>
											</span>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-4 col-sm-6">
								<div class="mb-4">
									<label class="form-label">Mailing Address</label>
									<div class="input-group-overlay">
										<textarea class="form-control appended-form-control" name="" id="" cols="30" rows="2" placeholder="Home Address 13,
10000 State, Country."></textarea>
										<div class="input-group-append-overlay">
											<span class="input-group-text">
												<button type="button" class="btn btn-text p-0 text-primary">
													<ion-icon name="create-outline"></ion-icon>
												</button>
											</span>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-4 col-sm-6">
								<div class="mb-4">
									<label class="form-label">E-mail Address</label>
									<div class="input-group-overlay">
										<input type="email" placeholder="paremail@gmail.com" class="form-control appended-form-control">
										<div class="input-group-append-overlay">
											<span class="input-group-text">
												<button type="button" class="btn btn-text p-0 text-primary">
													<ion-icon name="create-outline"></ion-icon>
												</button>
											</span>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-4 col-sm-6">
								<div class="mb-4">
									<label class="form-label">Phone Number</label>
									<div class="input-group-overlay">
										<input type="text" placeholder="0000000000" class="form-control appended-form-control">
										<div class="input-group-append-overlay">
											<span class="input-group-text">
												<button type="button" class="btn btn-text p-0 text-primary">
													<ion-icon name="create-outline"></ion-icon>
												</button>
											</span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div>

				</div>
			</div>
		</div>
		<div class="card mt-4 mt-md-5 plan-card">
			<div class="card-body">
				<h3 class="border-bottom pb-4 mb-5">My Plan</h3>
				<div class="row">
					<div class="col-md-4 col-sm-6">
						<div class="mb-4">
							<label class="form-label">NDIS Plan</label>
							<input type="text" placeholder="NDIS Plan" class="form-control">
						</div>
					</div>
					<div class="col-md-4 col-sm-6">
						<div class="mb-4">
							<label class="form-label">Types of Charges</label>
							<input type="text" placeholder="REPW, TRAN" class="form-control">
						</div>
					</div>
					<div class="col-md-4 col-sm-6">
						<div class="mb-4">
							<label class="form-label">Linked Representative</label>
							<input type="text" placeholder="Name of Representative" class="form-control">
						</div>
					</div>
					<div class="col-md-4 col-sm-6">
						<div class="mb-4">
							<label class="form-label">Start Date</label>
							<input type="date" placeholder="01/01/1999" class="form-control">
						</div>
					</div>
					<div class="col-md-4 col-sm-6">
						<div class="mb-4">
							<label class="form-label">End Date</label>
							<input type="date" placeholder="01/01/1999" class="form-control">
						</div>
					</div>
					<div class="col-md-4 col-sm-6">
						<div class="mb-4">
							<label class="form-label">Your Budget</label>
							<input type="text" placeholder="$180,000" class="form-control">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>
@endsection
