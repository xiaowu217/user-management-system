function delete_user( id ){         
	//prompt the user         
	var answer = confirm('Are you sure?');

	if ( answer ){ //if user clicked ok         
	//redirect to url with action as delete and id of the record to be deleted         
		window.location = 'delete.php?action=delete&id=' + id;				 
	}			 
}

function update_user( id ){      
	
	
	var counter = 0;
	
	while(counter<php_data.length){
		if(php_data[counter][0]==id){
			break;
		}
		counter++;
	}			
	document.getElementById("UpdateId").value=php_data[counter][0];
	document.getElementById("UpdateUsername").value=php_data[counter][1];
	document.getElementById("UpdateIsactive").value=php_data[counter][2];
	document.getElementById("UpdatePassword").value=php_data[counter][3];			
}

function validateForm(form) {
	
	var t_n,t_id=-1;
	
	if(form=="AddUser"){
		t_n = document.forms["AddUser"]["AddUsername"].value;
	}
	else if(form=="UpdateUser"){
		t_n = document.forms["UpdateUser"]["UpdateUsername"].value;
		t_id = document.forms["UpdateUser"]["id"].value;
	}
	
	if (t_n == null || t_n == "") {
		alert("Username must be filled out");
		return false;
	}
	for(var i=0; i < php_data.length; i++){
		if(t_n == php_data[i][1]){
			if((t_id==-1)||(t_id!=php_data[i][0])){
				alert("Username already exists. Please use another one.");
				return false;
			}
		}
	}			
}
