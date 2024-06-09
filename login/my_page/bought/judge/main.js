function ch(x){
	var ips = document.getElementsByName("judge[]");
	var star = document.getElementsByName("star");
	for(var i = 0;i < 5;i++){
		if(i <= x){
			ips[i].checked = true;
			star[i].src = "../../../../img/star_.png";
		}else{
			ips[i].checked = false;
			star[i].src = "../../../../img/star.png";
		}
	}
}
ch(2);