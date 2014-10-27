<!DOCTYPE html>
<head>
<title>Calendar</title>
<style type="text/css">
table{
    width: 100%;
}

th{
    background-color: #339966;
}

tr:nth-child(even) {
    border: 1px solid black;
    padding: 15px;
    background-color: #33CC33;
}

tr:nth-child(odd) {
    border: 1px solid black;
    padding: 15px;
    background-color: #33FF33;
}

td{
    border: 1px solid black;
    font-family : "Myriad Web",Verdana,Helvetica,Arial,sans-serif;
    vertical-align: top;
    padding: 15px;
    height: 100px;
    width: auto;
}

</style>
</head>
<body>
    
<div class="user"></div>
<div class="function"></div>
<div class="delete"></div>
<div class="creative"></div>
<div class="calendar"></div>
<div class="calendar_button"></div>

<?php session_start();?>

<script type="text/javascript">
    
    function loginPage(event) {
	document.getElementsByClassName("user")[0].appendChild(document.createTextNode("If you are a current user, please enter your username and password, and click Login.\n"));
	document.getElementsByClassName("user")[0].appendChild(document.createElement("br"));	
	document.getElementsByClassName("user")[0].appendChild(document.createTextNode("Don't have an account yet? Create your account below and click Register.\n	"));
	document.getElementsByClassName("user")[0].appendChild(document.createElement("br"));	
	document.getElementsByClassName("user")[0].appendChild(document.createElement("br"));	

	var username = document.createElement("input");
	username.type = "text";
	username.name = "username";
	username.id = "username";
	username.size = "15";
	
	var password = document.createElement("input");
	password.type = "password";
	password.name = "password";
	password.id = "password";
	password.size = "15";
	
	var email = document.createElement("input");
	email.type = "email";
	email.name = "email";
	email.id = "email";

	
	var login_button = document.createElement("input");
	login_button.type = "button";
	login_button.id = "login_btn";
	login_button.value = "Login";

	var register_button = document.createElement("input");
	register_button.type = "button";
	register_button.id = "register";
	register_button.value = "register";
	

	document.getElementsByClassName("user")[0].appendChild(document.createTextNode("Username: "));
	document.getElementsByClassName("user")[0].appendChild(username);
	document.getElementsByClassName("user")[0].appendChild(document.createElement("br"));
	document.getElementsByClassName("user")[0].appendChild(document.createTextNode("Password:  "));
	document.getElementsByClassName("user")[0].appendChild(password);
	document.getElementsByClassName("user")[0].appendChild(document.createElement("br"));
	document.getElementsByClassName("user")[0].appendChild(document.createTextNode("Email (Register Only):  "));
	document.getElementsByClassName("user")[0].appendChild(email);
	document.getElementsByClassName("user")[0].appendChild(document.createElement("br"));	

	document.getElementsByClassName("user")[0].appendChild(login_button);
	document.getElementsByClassName("user")[0].appendChild(register_button);
	
	document.getElementById("login_btn").addEventListener("click", loginAjax, false);
	document.getElementById("register").addEventListener("click", registerAjax, false);
	tableCreate();
    }
    
    document.addEventListener("DOMContentLoaded", loginPage, false);
    
    function february (year) { //according to leap year calculations
        if (((year%4 == 0) && (year%100 != 0)) || ((year%4 == 0) && (year%100 == 0) && (year%400 == 0))){
            return 29
        }else {
            return 28
        }
    }
    
    
    function MonthLength(month,year) {
        if (month==1) {
            return 31;
        }else if (month==2) {
            return february(year);
        }else if (month==3) {
            return 31;
        }else if (month==4) {
            return 30;
        }else if (month==5) {
            return 31;
        }else if (month==6) {
            return 30;
        }else if (month==7) {
            return 31;
        }else if (month==8) {
            return 31;
        }else if (month==9) {
            return 30;
        }else if (month==10) {
            return 31;
        }else if (month==11) {
            return 30;
        }else if (month==12) {
            return 31;
        }else{
            alert("not a valid month");
        }
    }
    
        
    
    var currentdate = new Date();
    var date = currentdate.getDate();
    var day = currentdate.getDay();
    var month = currentdate.getMonth()+1;
    var year = currentdate.getFullYear();
    
    var month_display = month;
    var year_display = year;
    
    var tag = true;
  
    function setCalendar(date, day, month, year) {
        var monthlength = MonthLength(month, year);
        var remainder = date%7;
        var first_day = day - (remainder-1);
        if (first_day ==7) {
            first_day = 0;
        }else if (first_day<0) {
	    first_day = first_day +7;
	}
        
        var current_array = new Array();
        for(i = 1; i <= monthlength; i++){
            current_array[i-1] = new Array(i,first_day);
            first_day++;
            if (first_day ==7) {
            first_day = 0;
            }
        }
        
        return current_array;
    }
   
    
    var current_month = setCalendar(date, day, month, year);
    
    function showtag() {
	if (tag) {
	    tag = false;
	}else{
	    tag = true;
	}
	
	displayAjax();
    }

    
    function tableCreate(events, num_events){
	var index = 0;
	var table="<table>";
	var days = "<tr><th>Sunday</th><th>Monday</th><th>Tuesday</th><th>Wednesday</th><th>Thursday</th><th>Friday</th><th>Saturday</th></tr>";
	table = table + days;
	for(var i=0;i<6;i++){
	    table =table+"<tr>";
	    for(var j=0;j<7;j++){	
		if (i==0 && j < current_month[0][1]) {
		    table = table+"<td>          </td>";		    
		}else{
		    if (index+1<10&&month_display<10) {
			var temp_date = year_display+"-0"+month_display+"-0"+(index+1);
		    }else if(index+1<10){
			var temp_date = year_display+"-"+month_display+"-0"+(index+1);

		    }else if (month_display<10) {
			var temp_date = year_display+"-0"+month_display+"-"+(index+1);
		    }else{
			var temp_date = year_display+"-"+month_display+"-"+(index+1);
		    }
		    table = table+"<td>" +current_month[index][0];
		    var m = 0
		    while (m<num_events) {
			if (events[m].date == temp_date) {
			    if (tag) {
				table = table+" "+events[m].tag;
			    }
			    table = table+"<br>"+events[m].begin +" - "+events[m].end;
			    table = table+" "+"<stong>"+events[m].event+"</stong>";
			}
			m++;
		    }
		    index++;
		    table+="</td>";
		}
		if (index==current_month.length) {
		    break;
		}
	    }
	    table = table + "</tr>";
	    if (index==current_month.length) {
		    break;
	    }
	}
	table = table + "</table>";
	
	current = "Today: "+month + "/"+date+"/"+year;
	displayed_month = " Calendar: "+month_display+"/"+year_display;
	document.getElementsByClassName("calendar")[0].innerHTML = current+displayed_month+table;
    }
    
    
    
    
    function displayAjax(){	 
	var dataString = "currentmonth=" + encodeURIComponent(month_display) + "&year=" + encodeURIComponent(year_display);

	var xmlHttp = new XMLHttpRequest(); 
	xmlHttp.open("POST", "display_event.php", true); 
	xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 
	xmlHttp.addEventListener("load", function(event){
		var jsonData = JSON.parse(event.target.responseText);
		if(jsonData.success){  
			var events = jsonData.data;
			var num_events = jsonData.data.length;
			if (num_events == null||events==null) {
			    tableCreate();
			}else {
			    tableCreate(events, num_events);
			}			
		}else{
			alert("something wrong.  "+jsonData.message);
		}
	}, false); 
	xmlHttp.send(dataString); 
    }
    
    function Previous_Month(){
	var last_day = 0;
	var first_day = current_month[0][1];
	
        if (first_day == 0) {
            last_day = 6;
        }else {
            last_day = first_day-1;
        }
	
        if (month_display == 1) {
            month_display = 12;
            year_display = year_display-1;
        }else{
            month_display = month_display-1;
            year_display = year_display;
        }
	
        var monthlength = MonthLength(month_display, year_display); //also the last date
	current_month = new Array(monthlength);
	
        for (var i = monthlength; i>=1; i--) {
            current_month[i-1] = new Array(i,last_day) //date and day
            last_day--;
            if(last_day == -1){
                last_day = 6;
            }
        }
        displayAjax();
    }
   

    function share_display(){
	var shared_user_email = document.createElement("input");
	shared_user_email.type = "text";
	shared_user_email.name = "shared_email";
	shared_user_email.id = "shared_email";
	
	var shared_user = document.createElement("input");
	shared_user.type = "text";
	shared_user.name = "shared_user";
	shared_user.id = "shared_user";
	
	var share_button = document.createElement("input");
	share_button.type = "button";
	share_button.id = "share_btn";
	share_button.value = "share";
	
	document.getElementsByClassName("creative")[0].appendChild(document.createElement("br"));
	document.getElementsByClassName("creative")[0].appendChild(document.createTextNode(" Want to share your calendar with another user? His/Her name: "));
	document.getElementsByClassName("creative")[0].appendChild(shared_user);	
	document.getElementsByClassName("creative")[0].appendChild(document.createTextNode(" His/Her email: "));
	document.getElementsByClassName("creative")[0].appendChild(shared_user_email);
	document.getElementsByClassName("creative")[0].appendChild(document.createTextNode(" "));
	document.getElementsByClassName("creative")[0].appendChild(share_button);
	
	document.getElementById("share_btn").addEventListener("click", share, false);
    }
    
    
    function share() {
	var email = document.getElementById("shared_email").value;
	var shared_user = document.getElementById("shared_user").value;
	var dataString = "shared_email=" + encodeURIComponent(email) + "&shared_user=" + encodeURIComponent(shared_user);
	
	var xmlHttp = new XMLHttpRequest(); 
	xmlHttp.open("POST", "share_ajax.php", true); 
	xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 
	xmlHttp.addEventListener("load", function(event) {
    	   var jsonData = JSON.parse(event.target.responseText); 
            if(jsonData.success){
		alert("You have shared your calender with "+ shared_user);
            }else{
                alert("You cannot share your calendar with this email.  "+jsonData.message);
            }
        }, false);
	xmlHttp.send(dataString);
	
    }
    
    function See_shared_display() {
	var xmlHttp = new XMLHttpRequest(); 
	xmlHttp.open("POST", "display_shared.php", true); 
	xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 
	xmlHttp.addEventListener("load", function(event){
		var jsonData = JSON.parse(event.target.responseText);
		if(jsonData.success){
		    var shared_users = jsonData.data;
		    if (shared_users[0].message=="share") {
			document.getElementsByClassName("creative")[0].appendChild(document.createElement("br"));
			document.getElementsByClassName("creative")[0].appendChild(document.createTextNode(" See you friend's calendar here:  "));
			for(var i = 0; i<shared_users.length;i++){
			    var share_user = document.createElement("input");
			    share_user.type = "button";
			    share_user.id = shared_users[i].name;
			    share_user.value = shared_users[i].name;
			    
			    document.getElementsByClassName("creative")[0].appendChild(share_user);
			    document.getElementById(shared_users[i].name).addEventListener("click",see_shared, false);
			}
			var current_user = document.createElement("input");
			current_user.type = "button";
			current_user.id = "Back to my Calendar";
			current_user.value = "Back to my Calendar";
			document.getElementsByClassName("creative")[0].appendChild(current_user);
			document.getElementById("Back to my Calendar").addEventListener("click",displayAjax, false);
		    }
		}else{
			alert("something wrong.  "+jsonData.message);
		}
	}, false); 
	xmlHttp.send(null); 
    }
    
    function see_shared() {
	var dataString = "shared_user=" + encodeURIComponent(this.value);
 
	var xmlHttp = new XMLHttpRequest(); 
	xmlHttp.open("POST", "see_shared.php", true); 
	xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 
	xmlHttp.addEventListener("load", function(event){
		var jsonData = JSON.parse(event.target.responseText);
		if(jsonData.success){  
			var events = jsonData.data;
			var num_events = jsonData.data.length;
			if (num_events == null) {
			    tableCreate();
			}
			else {
			    tableCreate(events, num_events);
			}
		}else{
			alert("something wrong.  "+jsonData.message);
		}
	}, false); 
	xmlHttp.send(dataString); 

    }
    
    function group_event_display() {
	var xmlHttp = new XMLHttpRequest(); 
	xmlHttp.open("POST", "display_shared.php", true); 
	xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 
	xmlHttp.addEventListener("load", function(event){
		var jsonData = JSON.parse(event.target.responseText);
		if(jsonData.success){
		    var shared_users = jsonData.data;
		    if (shared_users[0].message=="share") {
			document.getElementsByClassName("creative")[0].appendChild(document.createElement("br"));
			document.getElementsByClassName("creative")[0].appendChild(document.createTextNode(" In order to Create a group event, please use the add event bar on top of this page and choose your friend: "));
			for(var i = 0; i<shared_users.length;i++){
			    var share_user = document.createElement("input");
			    share_user.type = "button";
			    share_user.id = shared_users[i].name+"add";
			    share_user.value = shared_users[i].name;
			    document.getElementsByClassName("creative")[0].appendChild(share_user);
			    document.getElementById(shared_users[i].name+"add").addEventListener("click",add_group_event, false);
			}
		    }
		}else{
			alert("something wrong.  "+jsonData.message);
		}
	}, false); 
	xmlHttp.send(null); 
    }
    
    function add_group_event() {
	var ddmmyy = document.getElementById("date").value; 
	var begin = document.getElementById("begin").value; 
	var end = document.getElementById("end").value; 
	var event = document.getElementById("event").value; 
	var category = document.getElementById("category").value;
	var dataString = "shared_user=" + encodeURIComponent(this.value)+"&ddmmyy=" + encodeURIComponent(ddmmyy) + "&begin=" + encodeURIComponent(begin)+"&end="+encodeURIComponent(end)+"&event="+encodeURIComponent(event)+"&category="+encodeURIComponent(category);
 
	var xmlHttp = new XMLHttpRequest(); 
	xmlHttp.open("POST", "add_group_event.php", true); 
	xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 
	xmlHttp.addEventListener("load", function(event){
		var jsonData = JSON.parse(event.target.responseText);
		if(jsonData.success){  
			alert("Group Event Created!")
		}else{
			alert("something wrong.  "+jsonData.message);
		}
	}, false); 
	xmlHttp.send(dataString); 
    }

    function Next_Month() {
	var monthlength = MonthLength(month_display, year_display);
        if(current_month[monthlength-1][1] == 6) {
            first_day = 0;
        }else {
            first_day = current_month[monthlength-1][1]+1;
        }

        if (month_display == 12) {
            month_display = 1;
            year_display = year_display+1;
        }else{	    
            month_display = month_display+1;
            year_display = year_display;
        }
	monthlength = MonthLength(month_display, year_display);
        current_month = new Array(monthlength);
        for(i = 1; i <= monthlength; i++){
            current_month[i-1] = new Array(i,first_day);
            first_day++;
            if (first_day ==7) {
            first_day = 0;
            }
        }
	displayAjax();
    }
    
   

    function delete_event() {
	var event_id = document.getElementById("delete").value;
 
	var dataString = "event_id=" + encodeURIComponent(event_id);
 
	var xmlHttp = new XMLHttpRequest(); 
	xmlHttp.open("POST", "delete_ajax.php", true); 
	xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 
	xmlHttp.addEventListener("load", function(event) {
    	   var jsonData = JSON.parse(event.target.responseText); 
            if(jsonData.success){
		displayAjax();
		delete_event_display();
            }else{
                    alert("This event cannot be added.  "+jsonData.message);
            }
        }, false);
	xmlHttp.send(dataString);
    }
    
    function delete_event_display(){	 
	var dataString = "currentmonth=" + encodeURIComponent(month) + "&year=" + encodeURIComponent(year);
	
	document.getElementsByClassName("delete")[0].innerHTML = "";
	var xmlHttp = new XMLHttpRequest(); 
	xmlHttp.open("POST", "display_event.php", true); 
	xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 
	xmlHttp.addEventListener("load", function(event){
		var jsonData = JSON.parse(event.target.responseText); 
		if(jsonData.success){  
			var events = jsonData.data;
			var num_events = jsonData.data.length;
			document.getElementsByClassName("delete")[0].appendChild(document.createElement("br"));
			document.getElementsByClassName("delete")[0].appendChild(document.createTextNode("DELETE EVENT >> "));			
			var dropdown = document.createElement("select");
			dropdown.id = "delete";
			document.getElementsByClassName("delete")[0].appendChild(dropdown);
			for(var i = 0; i < num_events; i++){
			    var this_event = document.createElement("option");
			    this_event.setAttribute("value", events[i].id);
			    this_event.appendChild(document.createTextNode(events[i].date+" "+events[i].begin+" - "+events[i].end+": "+events[i].event));
			    document.getElementById("delete").appendChild(this_event);
			}
			
			document.getElementsByClassName("delete")[0].appendChild(dropdown);
			var delete_button = document.createElement("input");
			delete_button.type = "button";
			delete_button.id = "delete_btn";
			delete_button.value = "delete";
			document.getElementsByClassName("delete")[0].appendChild(document.createTextNode(" "));			
			document.getElementsByClassName("delete")[0].appendChild(delete_button);
			document.getElementById("delete_btn").addEventListener("click", delete_event, false);
		}else{
			alert("something wrong.  "+jsonData.message);
		}
	}, false); 
	xmlHttp.send(dataString); 
    }


    
    function add_event_display() {
	var begin = document.createElement("input");
	begin.type = "time";
	begin.name = "begin";
	begin.id = "begin";
	
	var end = document.createElement("input");
	end.type = "time";
	end.name = "end";
	end.id = "end";
	
	var event = document.createElement("input");
	event.type = "text";
	event.name = "event";
	event.id = "event";
	
	var ddmmyy = document.createElement("input");
	ddmmyy.type = "date";
	ddmmyy.name = "date";
	ddmmyy.id = "date";
	
	var add_button = document.createElement("input");
	add_button.type = "button";
	add_button.id = "add_btn";
	add_button.value = "add";
	
	var category = document.createElement("select");
	category.id = "category";
	var c = document.createElement("option");
	c.setAttribute("value", "General");
	c.appendChild(document.createTextNode("General"));
	category.appendChild(c);
	
	var c1 = document.createElement("option");
	c1.setAttribute("value", "Class");
	c1.appendChild(document.createTextNode("Class"));
	category.appendChild(c1);
	
	var c2 = document.createElement("option");
	c2.setAttribute("value", "Homework");
	c2.appendChild(document.createTextNode("Homework"));
	category.appendChild(c2);
	
	var c3 = document.createElement("option");
	c3.setAttribute("value", "FOOD");
	c3.appendChild(document.createTextNode("FOOD"));
	category.appendChild(c3);
	
	var c4 = document.createElement("option");
	c4.setAttribute("value", "Work Out");
	c4.appendChild(document.createTextNode("Work Out"));
	category.appendChild(c4);
	
	document.getElementsByClassName("function")[0].appendChild(document.createTextNode("ADD EVENT >> Which day? "));
	document.getElementsByClassName("function")[0].appendChild(ddmmyy);
	document.getElementsByClassName("function")[0].appendChild(document.createTextNode(" Begin time: "));
	document.getElementsByClassName("function")[0].appendChild(begin);
	document.getElementsByClassName("function")[0].appendChild(document.createTextNode(" End time:"));
	document.getElementsByClassName("function")[0].appendChild(end);
	document.getElementsByClassName("function")[0].appendChild(document.createTextNode(" What to do? "));
	document.getElementsByClassName("function")[0].appendChild(event);
	document.getElementsByClassName("function")[0].appendChild(document.createTextNode(" Tag? "));	
	document.getElementsByClassName("function")[0].appendChild(category);
	document.getElementsByClassName("function")[0].appendChild(document.createTextNode(" "));
	document.getElementsByClassName("function")[0].appendChild(add_button);
	
	document.getElementById("add_btn").addEventListener("click", add_event, false);	
    }
    
    
    
    function add_event() {
	var ddmmyy = document.getElementById("date").value; 
	var begin = document.getElementById("begin").value; 
	var end = document.getElementById("end").value; 
	var event = document.getElementById("event").value; 
	var category = document.getElementById("category").value;
	var dataString = "ddmmyy=" + encodeURIComponent(ddmmyy) + "&begin=" + encodeURIComponent(begin)+"&end="+encodeURIComponent(end)+"&event="+encodeURIComponent(event)+"&category="+encodeURIComponent(category);
 
	var xmlHttp = new XMLHttpRequest(); 
	xmlHttp.open("POST", "add_ajax.php", true); 
	xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 
	xmlHttp.addEventListener("load", function(event) {
    	   var jsonData = JSON.parse(event.target.responseText); 
            if(jsonData.success){
		displayAjax();
		delete_event_display();
            }else{
                alert("This event cannot be added.  "+jsonData.message);
            }
        }, false);
	xmlHttp.send(dataString);
    }
    
    
    
    function calendar_buttons(){
	var next = document.createElement("input");
	next.type = "button";
	next.id = "Next";
	next.value = "Next";	
	
	var Previous = document.createElement("input");
	Previous.type = "button";
	Previous.id = "Previous";
	Previous.value = "Previous";
	
	var Tag = document.createElement("input");
	Tag.type = "button";
	Tag.id = "Tag";
	Tag.value = "Tag";
	
	document.getElementsByClassName("calendar_button")[0].appendChild(Previous);
	document.getElementsByClassName("calendar_button")[0].appendChild(next);
	document.getElementsByClassName("calendar_button")[0].appendChild(Tag);
	document.getElementById("Next").addEventListener("click", Next_Month, false);
	document.getElementById("Tag").addEventListener("click", showtag, false);
	document.getElementById("Previous").addEventListener("click", Previous_Month, false);
    }
   
    function logoutAjax(event){
	
	var xmlHttp = new XMLHttpRequest(); 
	xmlHttp.open("POST", "logout_ajax.php", true); 
	xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 
	xmlHttp.addEventListener("load", function(event) {
    	   var jsonData = JSON.parse(event.target.responseText); 
            if(jsonData.success){
		    alert("You have logged out.");
		    window.location.replace("http://ec2-54-68-83-174.us-west-2.compute.amazonaws.com/~Amy/calendar.php");
	    }else{
                    alert("Something wrong  "+jsonData.message);
            }
        }, false);
	xmlHttp.send();
    }
    
    function loginAjax(event){
	
	var username = document.getElementById("username").value; 
	var password = document.getElementById("password").value; 
 
	// Make a URL-encoded string for passing POST data:
	var dataString = "username=" + encodeURIComponent(username) + "&password=" + encodeURIComponent(password);
 
	var xmlHttp = new XMLHttpRequest(); 
	xmlHttp.open("POST", "login_ajax.php", true); 
	xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 
	xmlHttp.addEventListener("load", function(event) {
    	   var jsonData = JSON.parse(event.target.responseText); 
            if(jsonData.success){
		document.getElementsByClassName("user")[0].innerHTML = "Here is your calendar: :D ";
		
		var logout_button = document.createElement("input");
		logout_button.type = "button";
		logout_button.id = "logout_btn";
		logout_button.value = "Logout";
		
		document.getElementsByClassName("user")[0].appendChild(logout_button);
		document.getElementById("logout_btn").addEventListener("click", logoutAjax, false);
		add_event_display();
		delete_event_display();
		share_display();
		See_shared_display();
		calendar_buttons();
		group_event_display();
		displayAjax();
            }else{
                    alert("You were not logged in.  "+jsonData.message);
            }
        }, false);
	xmlHttp.send(dataString);
	
    }
    
    function registerAjax(event){
	var username = document.getElementById("username").value; 
	var password = document.getElementById("password").value;
	var email = document.getElementById("email").value;
	
 
	// Make a URL-encoded string for passing POST data:
	var dataString = "username=" + encodeURIComponent(username) + "&password=" + encodeURIComponent(password)+"&email=" + encodeURIComponent(email);
 
	var xmlHttp = new XMLHttpRequest(); 
	xmlHttp.open("POST", "register_ajax.php", true); 
	xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 
	xmlHttp.addEventListener("load", function(event) {
    	   var jsonData = JSON.parse(event.target.responseText); 
            if(jsonData.success){  
                    alert("You have your account now! :)");		    
            }else{
                    alert(jsonData.message);
            }
        }, false);
	xmlHttp.send(dataString); 
    }
    
    

</script>
</body>
</html>