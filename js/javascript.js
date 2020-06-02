console.log("OK");

$(document).ready(function(){
	
		$("#forma").submit(function(dogadjaj){
			
			document.querySelector("#poljeGresaka").style.display="none";
			document.querySelector("#poljeGresaka").innerHTML="";
			
			var greske=[];
			var username=document.querySelector("#username").value;
			var password=document.querySelector("#password").value;
			var country=document.querySelector("#country").selectedIndex;
			
			var username_pattern=/^[A-Z]\w{6,}$/;
			var password_pattern=/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])\w{8,}$/;
			
			
			if(country==0){
				greske.push("You must select a country of origin!");
				document.querySelector("#country").style.border="2px solid red";
				document.querySelector("#country").style.color="red";
			}else{
				document.querySelector("#country").style.border="2px solid gray";
				document.querySelector("#country").style.color="black;";
			}
			
			if(password_pattern.test(password)){
				document.querySelector("#password").style.border="2px solid gray";
				document.querySelector("#password").style.color="black;";
			}else{
				greske.push("You must insert a correct password; it must contain at least one capital and small leter and a number and be at least 12 characters long!");
				document.querySelector("#password").style.border="2px solid red";
				document.querySelector("#password").style.color="red";
			}
			
			if(username_pattern.test(username)){
				document.querySelector("#username").style.border="2px solid gray";
				document.querySelector("#username").style.color="black;";
			}else{
				greske.push("You must insert a correct username; it must start with a capital letter and be at least 8 characters long!");
				document.querySelector("#username").style.border="2px solid red";
				document.querySelector("#username").style.color="red";
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



