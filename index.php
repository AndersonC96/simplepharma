
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Simple Pharma Chamados</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
		<link rel="icon" type="image/png" href="img/favicon.png"/>
		<link rel="stylesheet" href="CSS/style.css">
	</head>
	<body>
		<div class="login-page bg-light">
			<div class="container">
				<div class="row">
					<div class="col-lg-10 offset-lg-1">
						<div class="bg-white shadow rounded">
							<div class="row">
								<div class="col-md-7 pe-0">
									<div class="form-left h-100 py-5 px-5">
										<form action="autenticarUsuario.php" method="POST" role="form" class="row g-4">
											<div class="col-12">
                                                <!--<label>Username<span class="text-danger">*</span></label>-->
                                                <div class="input-group">
                                                    <div class="input-group-text"><i class="bi bi-person-fill"></i></div>
                                                    <!--<input type="text" class="form-control" placeholder="Enter Username">-->
													<input type="text" name="username" class="form-control" placeholder="Usuário" required autofocus>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <!--<label>Password<span class="text-danger">*</span></label>-->
                                                <div class="input-group">
                                                    <div class="input-group-text"><i class="bi bi-lock-fill"></i></div>
                                                    <!--<input type="text" class="form-control" placeholder="Enter Password">-->
													<input type="password" name="password" class="form-control" placeholder="Senha" required>
                                                </div>
                                            </div>
                                            <!--<div class="col-sm-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="inlineFormCheck">
                                                    <label class="form-check-label" for="inlineFormCheck">Remember me</label>
                                                </div>
                                            </div>-->
                                            <!--<div class="col-sm-6">
                                                <a href="#" class="float-end text-primary">Forgot Password?</a>
                                            </div>-->
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-success px-4 float-end mt-4">Entrar</button>
                                            </div>
										</form>
									</div>
								</div>
								<div class="col-md-5 ps-0 d-none d-md-block">
									<div class="form-right h-100 bg-info text-white text-center pt-5">
										<!--<i class="bi bi-bootstrap"></i>-->
										<img src="img/logo.png" alt="Simple Pharma" class="img-fluid">
										<h2 class="fw-bold">Simple Pharma</h2>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
	</body>
</html>