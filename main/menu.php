<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
@import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@500&display=swap');
body {
  font-family: 'Montserrat', sans-serif;
  font-size: 16px;
}

.sidenav {
  display: block;
  height: 100%;
  width: 0px;
  position: fixed;
  z-index: 1;
  top:5.7vh;
  left: 0;
  background-color: whitesmoke;
  overflow-x: hidden;
  transition: 0.5s;
  padding-top: 70px;
  
}

.sidenav a {
  padding: 15px 8px 8px 32px;
  text-decoration: none;
  color: black;
  display: block;
  transition: 0.3s;
}

.sidenav a:hover {
  color: #d35400;
}

.sidenav .closebtn {
  position: absolute;
  top: 0;
  right: 25px;
  font-size: 36px;
  margin-left: 50px;
}

@media screen and (max-height: 450px) {
  .sidenav {padding-top: 15px;}
  .sidenav a {font-size: 18px;}
}
</style>
</head>
<body>

<div id="mySidenav" class="sidenav" >
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  <a href="createProject.php">Create Project</a>
  <a href="projects.php">My Projects</a>
  
</div>


<span id="mySidenav" style="font-size:30px;cursor:pointer" onclick="change(this); sideMenu(this)">&#9776;</span>


<script>
function change(x) {
			x.classList.toggle("change");
		}
		
		function sideMenu(x){
      if(x.classList.contains('change')){ 
        document.getElementById("mySidenav").style.width = "250px";
        document.getElementById("main").style.marginLeft = "150px";
}
else{
  closeNav();

}
}

function closeNav(){
  document.getElementById("mySidenav").style.width = "0";
  document.getElementById("main").style.marginLeft = "0";

}

</script>
   
</body>
</html> 
