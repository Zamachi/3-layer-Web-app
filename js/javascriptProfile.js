console.log("OK");

$(document).ready(function(){
	
		$("#azurirajPodatke").submit(function(dogadjaj){
			
			document.querySelector("#poljeGresaka").style.display="none";
			document.querySelector("#poljeGresaka").innerHTML="";
			
			var greske=[];
			
			var passwordNew=document.querySelector("#newPassword1").value;
			var passwordConfirmation=document.querySelector("#newPassword2").value;
			
			var password_pattern=/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])\w{8,}$/;
			
			if(passwordNew.length>0){
				if(password_pattern.test(passwordNew)){
					document.querySelector("#newPassword1").style.border="2px solid gray";
					document.querySelector("#newPassword1").style.color="black;";
				}else{
					greske.push("You must insert a correct password; it must contain at least one capital and small leter and a number and be at least 12 characters long!");
					document.querySelector("#newPassword1").style.border="2px solid red";
					document.querySelector("#newPassword1").style.color="red";
				}
			}else{
				document.querySelector("#newPassword1").style.border="2px solid gray";
					document.querySelector("#newPassword1").style.color="black;";
				
			}
			if(passwordNew === passwordConfirmation){
				document.querySelector("#newPassword2").style.border="2px solid gray";
				document.querySelector("#newPassword2").style.color="black;";
			}else{
				greske.push("The passwords in both fields 'new password' and 'confirm password' must match!");
				document.querySelector("#newPassword2").style.border="2px solid red";
				document.querySelector("#newPassword2").style.color="red";
			}
			
			if(greske.length!=0){
				
				for(var i=0; i<greske.length; i++){
					
					document.querySelector("#poljeGresaka").style.display="block";
					document.querySelector("#poljeGresaka").innerHTML+="*"+greske[i]+"<br><br>";
					
				}
				
				dogadjaj.preventDefault();
				return;
			}

			
		});
				
	
});

function prikazi(){
	$("#searchWindow").fadeIn("slow");
}
function zatvori(){
	
	$("#searchWindow").fadeOut("slow");

}



