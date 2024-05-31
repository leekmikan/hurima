function set_data(data,str){
    if (window.localStorage) {
		let jsd = JSON.stringify(data, undefined, 1);
		localStorage.setItem(str, jsd);
	}
}
function get_data(str){
    if (window.localStorage) {
        let data = localStorage.getItem(str);
		if(data){
			return JSON.parse(data);
		}
        return null;
	}
}
function set_ip(x){
	document.getElementById("genre").value = x;
	document.getElementById("myForm").submit();
}
function pg(x){
    document.getElementById('page').value = x;
    document.getElementById('pgForm').submit();
}