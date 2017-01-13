var flag=false;
var newFlag=false;

function checkoldpwd(){
	var current_pwd=document.getElementById("oldpwd").value;
	if(current_pwd==''){
		return;
	}
	var xmlhttp;
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			flag=xmlhttp.responseText;
			//alert(xmlhttp.responseText);
		}
	}
	newFlag=true;
	xmlhttp.open("POST","../../vulnerabilities/ctf/?pid=9",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("password_current="+current_pwd+"&Change=check");
}


function checkvaild(){
	if(newFlag==false){
		alert('please input current password');
		return false;
	}
	if(flag==false || flag=='false'){
		alert('please input vaild current password');
		return false;
	}
	
	if(document.getElementById("newpwd_1").value!=document.getElementById("newpwd_2").value){
		alert('Its different for twice password');
		return false;
	}
}