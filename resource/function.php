<?php
//helper function
function redirect($location){
	header("Location:$location");
}

function query($sql){
global $connection;
return mysqli_query($connection,$sql);

}

function confirm($resultat){
		if(!$resultat){
			die("query failed ".mysqli_error($connection));
		}
}

function escape_string($string){
 global $connection;
 return mysqli_real_escape_string($connection,$string);
}

function fetch_array($result){
	return mysqli_fetch_array($result);
}
//get produit form data base 
function get_product (){
	$query =query("SELECT * FROM produit");
	confirm($query);
	while ($data = fetch_array($query)){

		$prod=<<<DELIMETER
 <div class="col-lg-4 col-md-6 mb-4">
              <div class="card h-100">
                <a href="items.php?id= {$data['produit_id']}"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>
                <div class="card-body">
                  <h4 class="card-title">
                    <a href="#">{$data['produit_titre']}</a>
                  </h4>
                  <h5>{$data['produit_prix']} dinar</h5>
                  <p class="card-text">{$data['produit_desc']}</p>
                </div>
                <div class="card-footer">
                 <a class="btn btn-primary pull-right"target="_self" href="items.php?id= {$data['produit_id']} ">view more</a>
                  <small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>
                </div>
              </div>
            </div>
DELIMETER;
            echo $prod;
	}
}

// get catagory 
 function get_catagories (){
	$query =query("SELECT * FROM categorie");
	confirm($query);
	while ($data = fetch_array($query)){

		$cat=<<<DELIMETER
<a href='category.php?id={$data['id_categorie']}' class='list-group-item'>{$data['titre_categorie']}</a>
DELIMETER;
            echo $cat;
	}
}




function login_user(){
    if(isset($_POST['submit'])){
        $username = escape_string($_POST['username']);
        $password = escape_string($_POST['password']);

        $query = query("SELECT * FROM users WHERE user_name = '{$username}' AND user_password = '{$password}'");
        confirm($query);

        if(mysqli_num_rows($query) == 0){
            set_message("Wrong!");
            redirect("login.php");

        }
        else{
            set_message("Welcome {$username}");
            redirect("index.php");
        }
    }
}

function set_message($msg){
    if(!empty($msg)){
        $_SESSION['message']=$msg;
    }else{
        $msg = "";
    }
}

function display_message(){
    if(isset($_SESSION['message'])){
        echo $_SESSION['message'];
        unset($_SESSION['message']);
    }
}

?>