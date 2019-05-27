<?php
include_once("./php_header.php");
include_once("./header.php");
if ( $manager_id == '' && $manager_passwd == '' ) {
    HEADER("Location:./on_air.php");
    exit;
}
if ( $_SESSION['sm-auth'] === true ) {
    HEADER("Location:./on_air.php");
}

?>
	<div class="error-pagewrap">
		<div class="error-page-int">
			<div class="text-center m-b-md custom-login">
				<h3>Showdown Manager Login</h3>
			</div>
			<div class="content-error">
				<div class="hpanel">
                    <div class="panel-body">
                        <form action="#" id="loginForm">
                            <div class="form-group">
                                <label class="control-label" for="username">ID</label>
                                <input type="text" placeholder="ID 를 입력세요" required="" value="" name="username" id="username" class="form-control">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="password">Password</label>
                                <input type="password" title="비밀번호를 입력하세요" placeholder="******" required="" value="" name="password" id="password" class="form-control">
                            </div>
                            <button class="btn btn-success btn-block loginbtn">Login</button>
                        </form>
                    </div>
                </div>
			</div>
		</div>
    </div>
<?php
include_once("./footer.php");
include_once("./php_footer.php");
?>
