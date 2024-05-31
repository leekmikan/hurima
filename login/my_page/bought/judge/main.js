function ch(x){
	var ips = document.getElementsByName("judge[]");
	var star = document.getElementsByName("star");
	for(var i = 0;i < 5;i++){
		if(i <= x){
			ips[i].checked = true;
			star[i].src = "無題3.png";
		}else{
			ips[i].checked = false;
			star[i].src = "無題2.png";
		}
	}
}
ch(2);