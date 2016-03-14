<!--
$page_tile  页名




-->
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width,initial-scale=1.0" />
        <link type="text/css" rel="stylesheet" href="view/css/bootstrap.min.css<?php echo '?random='.rand() ?>" />
        <link type="text/css" rel="stylesheet" href="view/css/simple.css<?php echo '?random='.rand() ?>" />
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
        <title>
        <?php
            echo $page_title;
        ?>
        </title>
    </head>
    <body>
        <!--modal-->
        
        <!--modal-login-->
        <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="loginModalLabel">Log In</h4>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal">
                            <div class="form-group">
                                <label for="login-username" class="col-sm-4 control-label">Username:</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" id="login-username" placeholder="Username">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="login-password" class="col-sm-4 control-label">Password:</label>
                                <div class="col-sm-5">
                                    <input type="password" class="form-control" id="login-password" placeholder="Username">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <span class="modal-error login-info" style="display:none"></span>
                        <button type="button" class="btn btn-default" data-dismiss="modal">SignUp</button>
                        <button type="button" class="btn btn-primary submit" onclick="getHeader().login()" data-loading-text="Loading..." autocomplete="off" >LogIn</button>
                    </div>
                </div>
            </div>
        </div>
        
        <!--modal-signup-->
        <div class="modal fade" id="signupModal" tabindex="-1" role="dialog" aria-labelledby="signupModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="signupModalLabel">SignUp</h4>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal">
                            <div class="form-group">
                                <label for="signup-username" class="col-sm-4 control-label">Username:</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" id="signup-username" placeholder="Username">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="signup-password" class="col-sm-4 control-label">Password:</label>
                                <div class="col-sm-5">
                                    <input type="password" class="form-control" id="signup-password" placeholder="Username">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="signup-re-password" class="col-sm-4 control-label">RE-Password:</label>
                                <div class="col-sm-5">
                                    <input type="password" class="form-control" id="signup-re-password" placeholder="Username">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="signup-email" class="col-sm-4 control-label">Email:</label>
                                <div class="col-sm-5">
                                    <input type="email" class="form-control" id="signup-email" placeholder="Username">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="signup-school" class="col-sm-4 control-label">School:</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" id="signup-school" placeholder="Username">
                                </div>
                            </div>
                            
                        </form>
                    </div>
                    <div class="modal-footer">
                        <span class="modal-error signup-info" style="display:none"></span>
                        <button type="button" class="btn btn-primary submit" onclick="getHeader().signup()">Submit</button>
                    </div>
                </div>
            </div>
        </div>
        
        <!--nav-bar-->
        <nav class="navbar navbar-default navbar-fixed-top header">
          <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-left" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="/">WHUTOJ</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="navbar-collapse-left">
                <ul class="nav navbar-nav">
                    <li><a href="/index.php?controller=problemlist">Problemlist</a></li>
                    <li><a href="/index.php?controller=status">Status</a></li>
                    <li><a href="/index.php?controller=ranklist">Ranklist</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Contest <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Real Contest</a></li>
                            <li><a href="#">Virtual Contest</a></li>
                        </ul>
                    </li>
              </ul>
                
                <ul class="nav navbar-nav navbar-right">
                <?php
                    if(isset($_SESSION['username']))
                    {
                        echo '<li><a href="javascript:getHeader().logOut()">Logout</a></li>';
                        echo '<li class="dropdown">';
                        echo '    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">' . $_SESSION['username'] .'<span class="caret"></span></a>';
                        echo '    <ul class="dropdown-menu">';
                        echo '        <li><a href="/index.php?controller=viewprofile">View Profile</a></li>';
                        echo '        <li><a href="/index.php?controller=editprofile">Edit Profile</a></li>';
                        echo '    </ul>';
                        echo '</li>';
                    }
                    else
                    {
                        echo '<li><a href="#" data-toggle="modal" data-target="#signupModal">Signup</a></li>';
                        echo '<li><a href="#" data-toggle="modal" data-target="#loginModal">Login</a></li>';
                    }
                    
                    
                ?>
              </ul>
              
            </div><!-- /.navbar-collapse -->
            
              
              
          </div><!-- /.container-fluid -->
        </nav>
      

        
        
